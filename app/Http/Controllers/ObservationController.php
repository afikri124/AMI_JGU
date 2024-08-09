<?php

namespace App\Http\Controllers;

use App\Mail\CommentDocs;
use App\Mail\sendEmail;
use App\Models\AuditPlan;
use App\Models\AuditPlanAuditor;
use App\Models\AuditPlanCategory;
use App\Models\AuditPlanCriteria;
use App\Models\Department;
use App\Models\Location;
use App\Models\ObservationChecklist;
use Illuminate\Http\Request;
use App\Models\Observation;
use App\Models\Setting;
use App\Models\StandardCategory;
use App\Models\StandardCriteria;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class ObservationController extends Controller
{
    public function index(Request $request)
    {
        $data = AuditPlan::all();
        $auditee = User::with(['roles' => function ($query) {
            $query->select('id', 'name');
        }])
            ->whereHas('roles', function ($q) use ($request) {
                $q->where('name', 'auditee');
            })
            ->orderBy('name')->get();
        return view('observations.index', compact('data', 'auditee'));
    }

    public function remark_doc(Request $request, $id)
{
    $data = AuditPlan::findOrFail($id);
    $auditorId = Auth::user()->id;

    if ($request->isMethod('POST')) {
        // Validasi request
        $this->validate($request, [
            'remark_docs' => [], // Pastikan remark_docs adalah array
        ]);

        $observation = Observation::where('audit_plan_id', $id)
            ->where('audit_plan_auditor_id', $auditorId)
            ->firstOrFail();

        foreach ($request->remark_docs as $key => $rd) {
            $checklist = ObservationChecklist::where('observation_id', $observation->id)
                ->where('indicator_id', $key)
                ->firstOrFail();

            if ($checklist) {
                $checklist->update([
                    'remark_docs' => $rd,
                ]);
            }
        }

        // Update status audit
        $data->update([
            'audit_status_id' => '3',
        ]);

        return redirect()->route('observations.index')->with('msg', 'Observation updated successfully!!');
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

    // Fetch other data needed
    $observations = Observation::where('audit_plan_id', $id)->get();
    $obs_c = ObservationChecklist::where('observation_id', $id)->get();
    $hodLPM = Setting::find('HODLPM');
    $hodBPMI = Setting::find('HODBPMI');

        return view('observations.view_doc',
        compact('standardCategories', 'standardCriterias',
        'auditor', 'data', 'category', 'criteria',
        'observations', 'obs_c','hodLPM', 'hodBPMI'));
}

    //form assesment
    public function create(Request $request, $id)
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

        $auditor = User::with(['roles' => function ($query) {
                $query->select('id', 'name');
            }])
            ->whereHas('roles', function ($q) {
                $q->where('name', 'auditor');
            })
            ->where('id', $auditorId)
            ->orderBy('name')
            ->get();

        $department = Department::where('id', $data->department_id)->orderBy('name')->get();

        $observations = Observation::where('audit_plan_id', $id)->get();

        $obs_c = ObservationChecklist::whereIn('observation_id', $observations->pluck('id'))->get();

        return view('observations.make',
        compact('standardCategories', 'standardCriterias',
        'observations', 'obs_c', 'auditorData', 'auditor', 'data',
        'locations', 'department', 'category', 'criteria'));
    }

    //make report audit lapangan
    public function make(Request $request, $id)
    {
        $data = AuditPlan::findOrFail($id);
        $auditorId = Auth::user()->id;

        if ($request->isMethod('POST')) {
            // dd($request);
            $this->validate($request, [
                'location_id' => [''],
                'remark_description' => [''],
                'obs_checklist_option' => [''],
                'remark_success_failed' => [''],
                'remark_recommend' => [''],
            ]);

            $observation = Observation::where('audit_plan_id', $id)
            ->where('audit_plan_auditor_id', $data->auditor()->where('auditor_id', $auditorId)->first()->id)
            ->firstOrFail();

            $observation->update([
                'location_id' => $request->location_id,
            ]);

            // Update Observation Checklists
            foreach ($request->obs_checklist_option as $key => $obs_c) {
                $checklist = ObservationChecklist::where('observation_id', $observation->id)
                    ->where('indicator_id', $key)
                    ->first();

                if ($checklist) {
                    $checklist->update([
                    'remark_description' => $request->remark_description[$key] ?? '',
                    'obs_checklist_option' => $obs_c ?? '',
                    'remark_success_failed' => $request->remark_success_failed[$key] ?? '',
                    'remark_recommend' => $request->remark_recommend[$key] ?? '',
                    ]);
                }
            }
            return redirect()->route('observations.index')->with('msg', 'Observasition succeeded!!');
        }
    }

    //print pdf audit report
    public function edit($id)
    {
        $locations = Location::orderBy('title')->get();
        $data = AuditPlan::findOrFail($id);
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

        $obs_c = ObservationChecklist::whereIn('observation_id', $observations->pluck('id'))->get();

        $hodLPM = Setting::find('HODLPM');
        $hodBPMI = Setting::find('HODBPMI');

        $pdf = PDF::loadView('pdf.audit_report',
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

    return $pdf->stream('make-report.pdf');

        // $observations = Observation::with([
        //     'observations' => function ($query) use ($id) {
        //         $query->select('*')->where('id', $id);
        //     },
        // ])->get();

        // $obs_c = ObservationChecklist::with([
        //     'obs_c' => function ($query) use ($id) {
        //         $query->select('*')->where('id', $id);
        //     },
        // ])->get();
        // // dd($obs_c);

        // $hodLPM = Setting::find('HODLPM');
        // $hodBPMI = Setting::find('HODBPMI');

        // return view('pdf.audit_report',
        // compact('standardCategories', 'standardCriterias',
        // 'auditorData', 'auditor', 'data', 'category', 'criteria',
        // 'observations', 'obs_c', 'hodLPM', 'hodBPMI'));
    }

    //remark audit report
    public function remark($id)
    {
        $data = AuditPlan::findOrFail($id);
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

        $observations = Observation::where('audit_plan_id', $id)->get();

        $obs_c = ObservationChecklist::where('observation_id', $observations->pluck('id'))->get();

        $hodLPM = Setting::find('HODLPM');
        $hodBPMI = Setting::find('HODBPMI');

        return view('observations.remark',
        compact('standardCategories', 'standardCriterias',
        'auditorData', 'auditor', 'data', 'category', 'criteria',
        'observations', 'obs_c','hodLPM', 'hodBPMI'));
    }

    public function update_remark(Request $request, $id)
    {
        $data = AuditPlan::findOrFail($id);
        $auditorId = Auth::user()->id;

        // Retrieve the observation using the ID
            $observation = Observation::where('audit_plan_id', $id)
                ->where('audit_plan_auditor_id', $data->auditor()->where('auditor_id', $auditorId)->first()->id)
                ->firstOrFail();

        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'remark_plan' => [''],
                'date_checked' => [''],
                'remark_description' => [''],
                'obs_checklist_option' => [''],
                'remark_success_failed' => [''],
                'remark_recommend' => [''],
            ]);

            $observation->update([
                'remark_plan' => $request->remark_plan,
                'date_checked' => $request->date_checked,
            ]);

            foreach ($request->obs_checklist_option as $key => $obs_c) {
                $checklist = ObservationChecklist::where('observation_id', $observation->id)
                    ->where('indicator_id', $key)
                    ->firstOrFail();

                if ($checklist) {
                    $checklist->update([
                    'remark_description' => $request->remark_description[$key] ?? '',
                    'obs_checklist_option' => $obs_c ?? '',
                    'remark_success_failed' => $request->remark_success_failed[$key] ?? '',
                    'remark_recommend' => $request->remark_recommend[$key] ?? '',
                    ]);
                }
            }

            $data->update([
                'audit_status_id'   => '6',
            ]);

        return redirect()->route('observations.index')->with('msg', 'Document reviewed, thanks for your time');
    }
}


    public function data(Request $request)
    {
        $data = AuditPlan::with([
            'auditee' => function ($query) {
                $query->select('id', 'name', 'no_phone');
            },
            'auditstatus' => function ($query) {
                $query->select('id', 'title', 'color');
            },
            'auditor.auditor' => function ($query) {
                $query->select('id', 'name', 'no_phone');
            },
        ])->leftJoin('locations', 'locations.id', '=', 'location_id')
            ->select(
                'audit_plans.*',
                'locations.title as location'
            )
            // ->where('auditor_id', Auth::user()->id)
            ->orderBy("id");
        return DataTables::of($data)
            ->filter(function ($instance) use ($request) {
                //jika pengguna memfilter berdasarkan roles
                if (!empty($request->get('select_auditee'))) {
                    $instance->whereHas('auditee', function ($q) use ($request) {
                        $q->where('auditee_id', $request->get('select_auditee'));
                    });
                }
                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('date_start', 'LIKE', "%$search%")
                        ->orWhere('date_end', 'LIKE', "%$search%")
                        ->orWhere('locations.title', 'LIKE', "%$search%")
                        ->orWhereHas('auditee', function ($query) use ($search) {
                            $query->where('name', 'LIKE', "%$search%");
                        });
                    });
                }
            })->make(true);
        }


// <-----------------  MAKE REPORT  ---------------------->
    // public function make_report(Request $request, $id)
    // {
    //     $data = AuditPlan::findOrFail($id);
    //     $auditee = User::with(['roles' => function ($query) {
    //         $query->select('id', 'name');
    //     }])
    //         ->whereHas('roles', function ($q) use ($request) {
    //             $q->where('name', 'auditee');
    //         })
    //         ->orderBy('name')->get();
    //     return view('observations.make_report.index', compact('data', 'auditee'));
    // }

    // public function att($id, $type)
    // {
    //     $locations = Location::orderBy('title')->get();
    //     $category = StandardCategory::orderBy('description')->get();
    //     $criteria = StandardCriteria::orderBy('title')->get();
    //     $data = AuditPlan::findOrFail($id);

    //     $auditorId = Auth::user()->id;
    //     $auditorData = AuditPlanAuditor::where('auditor_id', $auditorId)->where('audit_plan_id', $id)->firstOrFail();

    //     $categories = AuditPlanCategory::where('audit_plan_auditor_id', $auditorData->id)->get();
    //     $criterias = AuditPlanCriteria::where('audit_plan_auditor_id', $auditorData->id)->get();

    //     $standardCategoryIds = $categories->pluck('standard_category_id');
    //     $standardCriteriaIds = $criterias->pluck('standard_criteria_id');

    //     $standardCategories = StandardCategory::whereIn('id', $standardCategoryIds)->get();
    //     $standardCriterias = StandardCriteria::with('statements')
    //                     ->with('statements.indicators')
    //                     ->with('statements.reviewDocs')
    //                     ->whereIn('id', $standardCriteriaIds)
    //                     ->groupBy('id','title','status','standard_category_id','created_at','updated_at')
    //                     ->get();
    //     // dd($standardCriterias);

    //     $auditor = User::with(['roles' => function ($query) {
    //             $query->select('id', 'name');
    //         }])
    //         ->whereHas('roles', function ($q) {
    //             $q->where('name', 'auditor');
    //         })
    //         ->where('id', $auditorId)
    //         ->orderBy('name')
    //         ->get();

    //     $observations = Observation::where('audit_plan_id', $id)->get();

    //     $obs_c = ObservationChecklist::whereIn('observation_id', $observations->pluck('id'))->get();

    //     // dd($obs_c);

    //     $hodLPM = Setting::find('HODLPM');
    //     $hodBPMI = Setting::find('HODBPMI');

    // //     $pdf = PDF::loadView('observations.make_report.attendance',
    // //     $data = [
    // //         'data' => $data,
    // //         'locations' => $locations,
    // //         'auditor' => $auditor,
    // //         'category' => $category,
    // //         'criteria' => $criteria,
    // //         'standardCriterias' => $standardCriterias,
    // //         'observations' => $observations,
    // //         'obs_c' => $obs_c,
    // //         'hodLPM' => $hodLPM,
    // //         'hodBPMI' => $hodBPMI
    // //     ]);
    // // // dd( $standardCriterias, $auditor, $data, $observations, $obs_c, $hodLPM, $hodBPMI);

    // return $pdf->stream('make-report-absensi.pdf');
// }
    }
