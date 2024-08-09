<?php

namespace App\Http\Controllers;

use App\Models\AuditPlan;
use App\Models\Department;
use App\Models\Observation;
use App\Models\AuditPlanAuditor;
use App\Models\AuditPlanCategory;
use App\Models\AuditPlanCriteria;
use App\Models\Location;
use App\Models\StandardCategory;
use App\Models\StandardCriteria;
use App\Models\ObservationChecklist;
use App\Models\RTM;
use App\Models\User;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


class MyAuditController extends Controller{
    //Tampilan My Audit
    public function index(Request $request){
        $data = AuditPlan::all();
        return view('my_audit.index', compact('data'));
    }

    public function my_standard(Request $request, $id)
{
    $data = AuditPlan::findOrFail($id);
    $auditorId = Auth::user()->id;

    if ($request->isMethod('POST')) {
        $this->validate($request, [
            'doc_path.*' => 'mimes:pdf|max:10000', // Validate each file
        ]);

        $auditPlanAuditorId = $data->auditor()->where('auditor_id', $auditorId)->first()->id;
        $observation = Observation::where('audit_plan_id', $id)
        ->where('audit_plan_auditor_id', $data->auditor()->where('auditor_id', $auditorId)->first()->id)
        ->firstOrFail();
        // Create Observation
        $observation->update([
            'audit_plan_id' => $id,
            'audit_plan_auditor_id' => $auditPlanAuditorId,
        ]);

        $files = $request->file('doc_path');
        $filePaths = [];

        if ($files) {
            foreach ($files as $index => $file) {
                $ext = $file->extension();
                $name = str_replace(' ', '_', $file->getClientOriginalName());
                $fileName = Auth::user()->id . '_' . $name;
                $folderName = "storage/FILE/" . Carbon::now()->format('Y/m');
                $path = public_path($folderName);

                if (!File::exists($path)) {
                    File::makeDirectory($path, 0755, true); // Create folder if not exists
                }

                $upload = $file->move($path, $fileName);
                if ($upload) {
                    $filePaths[$index] = $folderName . "/" . $fileName;
                } else {
                    $filePaths[$index] = null;
                }
            }
        }

        // Create Observation Checklists
        foreach ($request->indicator_ids as $index => $indicatorId) {
            ObservationChecklist::create([
                'observation_id' => $observation->id,
                'indicator_id' => $indicatorId,
                'doc_path' => $filePaths[$index] ?? null,
            ]);
        }

        $data->update([
            'audit_status_id'   => '11',
        ]);

        return redirect()->route('my_audit.index')->with('msg', 'Document Success Uploaded');
    }

        $data = AuditPlan::findOrFail($id);
        $auditor = AuditPlanAuditor::where('audit_plan_id', $id)->get();
        $auditPlanAuditorIds = $auditor->pluck('id');

        $category = AuditPlanCategory::whereIn('audit_plan_auditor_id', $auditPlanAuditorIds)->get();
        $standardCategoryIds = $category->pluck('standard_category_id');
        $standardCategories = StandardCategory::whereIn('id', $standardCategoryIds)->orderBy('description')->get();

        $criteria = AuditPlanCriteria::whereIn('audit_plan_auditor_id', $auditPlanAuditorIds)->get();
        $standardCriteriaIds = $criteria->pluck('standard_criteria_id');
        $standardCriterias = StandardCriteria::whereIn('id', $standardCriteriaIds)
                            ->with('statements')
                            ->with('statements.indicators')
                            ->with('statements.reviewDocs')
                            ->groupBy('id','title','status','standard_category_id','created_at','updated_at')
                            ->orderBy('title')
                            ->get();

        $observations = Observation::where('audit_plan_id', $id)->get();
        $obs_c = ObservationChecklist::where('observation_id', $id)->get();
        $hodLPM = Setting::find('HODLPM');
        $hodBPMI = Setting::find('HODBPMI');
        return view('my_audit.view',
        compact('standardCategories', 'standardCriterias',
        'auditor', 'data', 'category', 'criteria', 'observations', 'obs_c', 'hodLPM', 'hodBPMI'));
    }

    public function my_remark( $id)
        {
        $locations = Location::orderBy('title')->get();
        $category = StandardCategory::orderBy('description')->get();
        $criteria = StandardCriteria::orderBy('title')->get();
        $data = AuditPlan::findOrFail($id);

        $auditorId = Auth::user()->id;
        $auditorData = AuditPlanAuditor::where('auditor_id', $auditorId)->where('audit_plan_id', $id)->firstOrFail();

        $categories = AuditPlanCategory::where('audit_plan_auditor_id', $auditorData->id)->get();
        $criterias = AuditPlanCriteria::where('audit_plan_auditor_id', $auditorData->id)->get();

        $standardCategoryIds = $categories->pluck('standard_category_id');
        $standardCriteriaIds = $criterias->pluck('standard_criteria_id');

        $standardCategories = StandardCategory::whereIn('id', $standardCategoryIds)->get();
        $standardCriterias = StandardCriteria::with('statements')
                        ->with('statements.indicators')
                        ->with('statements.reviewDocs')
                        ->whereIn('id', $standardCriteriaIds)
                        ->groupBy('id','title','status','standard_category_id','created_at','updated_at')
                        ->get();
        // dd($standardCriterias);

        $auditor = AuditPlanAuditor::where('audit_plan_id', $id)
                                    ->with('auditor:id,name')
                                    ->firstOrFail();

        $observations = Observation::where('audit_plan_id', $id)->get();

        $obs_c = ObservationChecklist::whereIn('observation_id', $observations->pluck('id'))->get();

        $hodLPM = Setting::find('HODLPM');
        $hodBPMI = Setting::find('HODBPMI');
        return view('my_audit.view',
        compact('standardCategories', 'standardCriterias',
        'auditor', 'data', 'category', 'criteria', 'observations', 'obs_c', 'hodLPM', 'hodBPMI'));
    }

    //Narik data untuk Observations
    public function obs( $id)
    {
        $locations = Location::orderBy('title')->get();
        $category = StandardCategory::orderBy('description')->get();
        $criteria = StandardCriteria::orderBy('title')->get();
        $data = AuditPlan::findOrFail($id);

        $auditorId = Auth::user()->id;
        $auditorData = AuditPlanAuditor::where('auditor_id', $auditorId)->where('audit_plan_id', $id)->firstOrFail();

        $categories = AuditPlanCategory::where('audit_plan_auditor_id', $auditorData->id)->get();
        $criterias = AuditPlanCriteria::where('audit_plan_auditor_id', $auditorData->id)->get();

        $standardCategoryIds = $categories->pluck('standard_category_id');
        $standardCriteriaIds = $criterias->pluck('standard_criteria_id');

        $standardCategories = StandardCategory::whereIn('id', $standardCategoryIds)->get();
        $standardCriterias = StandardCriteria::with('statements')
                        ->with('statements.indicators')
                        ->with('statements.reviewDocs')
                        ->whereIn('id', $standardCriteriaIds)
                        ->groupBy('id','title','status','standard_category_id','created_at','updated_at')
                        ->get();
        // dd($standardCriterias);

        $auditor = AuditPlanAuditor::where('audit_plan_id', $id)
                                    ->with('auditor:id,name')
                                    ->firstOrFail();

        $department = Department::where('id', $data->department_id)->orderBy('name')->get();

        $observations = Observation::where('audit_plan_id', $id)->get();

        $obs_c = ObservationChecklist::whereIn('observation_id', $observations->pluck('id'))->get();

        $hodLPM = Setting::find('HODLPM');
        $hodBPMI = Setting::find('HODBPMI');
        // dd($obs_c);
        if ($data->audit_status_id == 3) {
            return view('my_audit.show', [
                'standardCategories' => $standardCategories,
                'standardCriterias' => $standardCriterias,
                'auditorData' => $auditorData,
                'auditor' => $auditor,
                'data' => $data,
                'category' => $category,
                'criteria' => $criteria,
                'observations' => $observations,
                'obs_c' => $obs_c,
                'hodLPM' => $hodLPM,
                'hodBPMI' => $hodBPMI
            ]);
        } elseif ($data->audit_status_id == 6) {
            $pdf = Pdf::loadView('pdf.audit_report',
            $data = [
            'data' => $data,
            'locations' => $locations,
            'auditor' => $auditor,
            'category' => $category,
            'criteria' => $criteria,
            'standardCriterias' => $standardCriterias,
            'observations' => $observations,
            'obs_c' => $obs_c,
            'hodLPM' => $hodLPM,
            'hodBPMI' => $hodBPMI
        ]);
        // dd( $standardCriterias, $auditor, $data, $observations, $obs_c, $hodLPM, $hodBPMI);
        return $pdf->stream('rtm-report.pdf');
        } elseif ($data->audit_status_id == 7) {
            return view('my_audit.edit_rtm', [
                'standardCategories' => $standardCategories,
                'standardCriterias' => $standardCriterias,
                'auditorData' => $auditorData,
                'auditor' => $auditor,
                'data' => $data,
                'category' => $category,
                'criteria' => $criteria,
                'observations' => $observations,
                'obs_c' => $obs_c,
                'hodLPM' => $hodLPM,
                'hodBPMI' => $hodBPMI
            ]);
        }
    }

    //Proses update Observations
    public function show(Request $request, $id)
{
    $data = AuditPlan::findOrFail($id);
    $auditorId = Auth::user()->id;

    // Retrieve the observation using the ID
    $observation = Observation::where('audit_plan_id', $id)
        ->where('audit_plan_auditor_id', $data->auditor()
        ->where('auditor_id', $auditorId)->first()->id)
        ->firstOrFail();

    if ($request->isMethod('POST')) {
        // Validate the request
        $this->validate($request, [
            'person_in_charge' => ['required'],
            'plan_complated' => ['required'],
            'date_prepared' => ['required'],
            'remark_upgrade_repair' => ['required'],
        ]);

        // Update the Observation
        $observation->update([
            'person_in_charge' => $request->person_in_charge,
            'plan_complated' => $request->plan_complated,
            'date_prepared' => $request->date_prepared,
        ]);

        // Update Observation Checklists
        foreach ($request->remark_upgrade_repair as $key => $remark) {
            $checklist = ObservationChecklist::where('observation_id', $observation->id)
                ->where('indicator_id', $key)
                ->first();

            if ($checklist) {
                $checklist->update([
                    'remark_upgrade_repair' => $remark,
                ]);
            }
        }
        return redirect()->route('my_audit.index')->with('msg', 'Observation updated successfully!!');
    }

    // Pass data to view if needed
    return view('my_audit.show', [
        'data' => $data,
        'observation' => $observation,
    ]);
}

    public function edit_rtm(Request $request, $id)
    {
        $data = AuditPlan::findOrFail($id);
        $auditorId = Auth::user()->id;

        $files = $request->file('doc_path');
        $filePaths = [];

        if ($files) {
            foreach ($files as $index => $file) {
                $ext = $file->extension();
                $name = str_replace(' ', '_', $file->getClientOriginalName());
                $fileName = Auth::user()->id . '_' . $name;
                $folderName = "storage/FILE/" . Carbon::now()->format('Y/m');
                $path = public_path($folderName);

                if (!File::exists($path)) {
                    File::makeDirectory($path, 0755, true); // Create folder if not exists
                }

                $upload = $file->move($path, $fileName);
                if ($upload) {
                    $filePaths[$index] = $folderName . "/" . $fileName;
                } else {
                    $filePaths[$index] = null;
                }
            }
        }

        // Retrieve the observation using the ID
        $observation = Observation::where('audit_plan_id', $id)
            ->where('audit_plan_auditor_id', $data->auditor()
            ->where('auditor_id', $auditorId)->first()->id)
            ->firstOrFail();

        $auditPlanAuditorId = $data->auditor()->where('auditor_id', $auditorId)->first()->id;

        if ($request->isMethod('POST')) {
            // Validate the request
            $this->validate($request, [
                'plan_complated_end' => ['required'],
                'status' => ['required'],
            ]);
            $observation->update([
                'audit_plan_id' => $id,
                'audit_plan_auditor_id' => $auditPlanAuditorId,
            ]);

            foreach ($request->indicator_ids as $index => $indicatorId) {
                RTM::create([
                    'observation_id' => $observation->id,
                    'indicator_id' => $indicatorId,
                    'plan_complated_end' => $request->plan_complated_end[$index] ?? null,
                    'status' => $request->status[$index] ?? null,
                    'doc_path_rtm' => $filePaths[$index] ?? null,
                ]);
            }

    // dd($request);
            return redirect()->route('my_audit.index')->with('msg', 'Observation updated successfully!!');
        }
    }

    public function rtm($id){
        $data = AuditPlan::findOrFail($id);
        $locations = Location::orderBy('title')->get();
        $auditor = AuditPlanAuditor::where('audit_plan_id', $id)
        ->with('auditor:id,name')
        ->firstOrFail();
        $category = StandardCategory::orderBy('description')->get();
        $criteria = StandardCriteria::orderBy('title')->get();

        $auditorId = Auth::user()->id;
        $auditorData = AuditPlanAuditor::where('auditor_id', $auditorId)->where('audit_plan_id', $id)->firstOrFail();

        $categories = AuditPlanCategory::where('audit_plan_auditor_id', $auditorData->id)->get();
        $criterias = AuditPlanCriteria::where('audit_plan_auditor_id', $auditorData->id)->get();

        $standardCategoryIds = $categories->pluck('standard_category_id');
        $standardCriteriaIds = $criterias->pluck('standard_criteria_id');

        $standardCategories = StandardCategory::whereIn('id', $standardCategoryIds)->get();
        $standardCriterias = StandardCriteria::with('statements')
                        ->with('statements.indicators')
                        ->with('statements.reviewDocs')
                        ->whereIn('id', $standardCriteriaIds)
                        ->groupBy('id','title','status','standard_category_id','created_at','updated_at')
                        ->get();
        $observations = Observation::where('audit_plan_auditor_id', $id)->get();
        $obs_c = ObservationChecklist::where('observation_id', $id)->get();
        $hodLPM = Setting::find('HODLPM');
        $hodBPMI = Setting::find('HODBPMI');

        $pdf = Pdf::loadView('pdf.rtm',
        $data = [
            'data' => $data,
            'locations' => $locations,
            'auditor' => $auditor,
            'category' => $category,
            'criteria' => $criteria,
            'standardCriterias' => $standardCriterias,
            'observations' => $observations,
            'obs_c' => $obs_c,
            'hodLPM' => $hodLPM,
            'hodBPMI' => $hodBPMI
        ]);
    // dd( $standardCriterias, $auditor, $data, $observations, $obs_c, $hodLPM, $hodBPMI);

    return $pdf->stream('rtm-report.pdf');
        // return view('lpm.print',
        // compact('standardCategories', 'standardCriterias',
        // 'auditorData', 'auditor', 'data', 'category',
        // 'criteria', 'observations', 'obs_c', 'hodLPM', 'hodBPMI'));
    }

    //Data My Audit
    public function data(Request $request){
        $data = AuditPlan::
        with(['auditee' => function ($query) {
                $query->select('id','name', 'no_phone');
            },
            'auditstatus' => function ($query) {
                $query->select('id', 'title', 'color');
            },
            'auditor.auditor' => function ($query) {
                $query->select('id', 'name', 'no_phone');
            },
            ])->leftJoin('locations', 'locations.id' , '=', 'location_id')
            ->select('audit_plans.*',
            'locations.title as location'
            )
            // ->where('auditee_id', Auth::user()->id)
            ->orderBy("id");
            return DataTables::of($data)
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('auditee_id'))) {
                    $instance->where("auditee_id", $request->get('auditee_id'));
                }
                if (!empty($request->get('search'))) {
                    $search = $request->get('search');
                    $instance->where('auditee_id', 'LIKE', "%$search%");
                }
                if (!empty($request->get('search'))) {
                    $instance->where(function($w) use($request){
                        $search = $request->get('search');
                            $w->orWhere('date_start', 'LIKE', "%$search%")
                            ->orWhere('date_end', 'LIKE', "%$search%");
                    });
                }
            })->make(true);
    }

        // public function reupload(Request $request, $id){
    //     //document upload
    //     $data = AuditPlan::findOrFail($id);
    //     $data->update([
    //     'audit_status_id'   => '11',
    // ]);
    //     return redirect()->route('my_audit.index')->with('msg', 'Thank you for reuploading the document ');
    // }

    // public function add($id)
    // {
    //     $data = AuditPlan::findOrFail($id);
    //     return view('my_audit.add', compact('data'));
    // }

    // Upload Document Audit
    // public function update(Request $request, $id){
    //     $request->validate([
    //         'doc_path' => 'mimes:pdf|max:10000|',
    //     ]);
    //     $fileName = null;
    //     if ($request->hasFile('doc_path')) {
    //         $ext = $request->doc_path->extension();
    //         $name = str_replace(' ', '_', $request->doc_path->getClientOriginalName());
    //         $fileName = Auth::user()->id . '_' . $name;
    //         $folderName = "storage/FILE/" . Carbon::now()->format('Y/m');
    //         $path = public_path() . "/" . $folderName;
    //         if (!File::exists($path)) {
    //             File::makeDirectory($path, 0755, true); //create folder
    //         }
    //         $upload = $request->doc_path->move($path, $fileName); //upload file to folder
    //         if ($upload) {
    //             $fileName = $folderName . "/" . $fileName;
    //         } else {
    //             $fileName = null;
    //         }
    //     }
    //     //document upload
    //     $data = AuditPlan::findOrFail($id);
    //     $data->update([
    //     'doc_path'          => $fileName,
    //     'audit_status_id'   => '10',
    // ]);
    //     return redirect()->route('my_audit.index')->with('msg', 'Thank you for uploading the document ');
    // }


//Json
    public function getData(){
        $data = AuditPlan::with('users')->with('auditstatus')->with('locations')->get()->map(function ($data) {
            return [
                'auditee_id' => $data->auditee_id,
                'date_start' => $data->date_start,
                'date_end' => $data->date_end,
                'audit_status_id' => '1',
                'location_id' => $data->location_id,
                'auditor_id' => $data->auditor_id,
                'department_id' => $data->department_id,
                'doc_path' => $data->doc_path,
                'link' => $data->link,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            ];
        });
        return response()->json($data);
        }

    public function datatables(){
        $audit_plan = AuditPlan::select('*');
        return DataTables::of($audit_plan)->make(true);
    }
}
