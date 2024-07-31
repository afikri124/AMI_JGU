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
use App\Models\User;
use App\Models\Setting;
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

    //Upload Document Audit
    public function update(Request $request, $id){
        $request->validate([
            'doc_path' => 'mimes:pdf|max:10000|',
        ]);
        $fileName = null;
        if ($request->hasFile('doc_path')) {
            $ext = $request->doc_path->extension();
            $name = str_replace(' ', '_', $request->doc_path->getClientOriginalName());
            $fileName = Auth::user()->id . '_' . $name;
            $folderName = "storage/FILE/" . Carbon::now()->format('Y/m');
            $path = public_path() . "/" . $folderName;
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true); //create folder
            }
            $upload = $request->doc_path->move($path, $fileName); //upload file to folder
            if ($upload) {
                $fileName = $folderName . "/" . $fileName;
            } else {
                $fileName = null;
            }
        }
        //document upload
        $data = AuditPlan::findOrFail($id);
        $data->update([
        'doc_path'          => $fileName,
        'audit_status_id'   => '10',
    ]);
        return redirect()->route('my_audit.index')->with('msg', 'Thank you for uploading the document ');
    }

    //Narik data untuk Observations
    public function obs(Request $request, $id)
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

        $observations = Observation::with([
            'observations' => function ($query) use ($id) {
                $query->select('*')->where('id', $id);
            },
        ])->get();

        $obs_c = ObservationChecklist::with([
            'obs_c' => function ($query) use ($id) {
                $query->select('*')->where('id', $id);
            },
        ])->get();

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
        } elseif ($data->audit_status_id == 4) {
            return view('my_audit.add', [
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
        ->where('audit_plan_auditor_id', $data->auditor()->where('auditor_id', $auditorId)->first()->id)
        ->firstOrFail();

    if ($request->isMethod('POST')) {
        // Validate the request
        $this->validate($request, [
            'person_in_charge' => ['required'],
            'plan_complated' => ['required'],
            'remark_upgrade_repair' => ['required', 'array'],
        ]);

        // Update the Observation
        $observation->update([
            'person_in_charge' => $request->person_in_charge,
            'plan_complated' => $request->plan_complated,
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
// dd($request);
        return redirect()->route('my_audit.index')->with('msg', 'Observation updated successfully!!');
    }

    // Pass data to view if needed
    return view('my_audit.show', [
        'data' => $data,
        'observation' => $observation,
    ]);
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
