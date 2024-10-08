<?php

namespace App\Http\Controllers;

use App\Mail\CommentDocs;
use App\Mail\sendEmail;
use App\Mail\remakeDocAutitee;
use App\Models\AuditPlan;
use App\Models\AuditPlanAuditor;
use App\Models\AuditPlanCategory;
use App\Models\AuditPlanCriteria;
use App\Models\Department;
use App\Models\Location;
use App\Models\ObservationChecklist;
use Illuminate\Http\Request;
use App\Models\Observation;
use App\Models\Rtm;
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

    //remark document
    public function remark_doc(Request $request, $id)
    {
        $data = AuditPlan::findOrFail($id);
        $auditorId = Auth::user()->id;
        $observations = Observation::where('audit_plan_id', $id)->get();

        if ($request->isMethod('POST')) {
            $action = $request->input('action');

            // Process Save Draft
            if ($action === 'Save') {
                foreach ($observations as $observation) {
                    foreach ($request->indicator_id as $index => $indicatorId) {
                        ObservationChecklist::updateOrCreate(
                            [
                                'observation_id' => $observation->id,
                                'indicator_id' => $indicatorId,
                            ],
                            [
                                'remark_docs' => $request->remark_docs[$index] ?? null,
                            ]
                        );
                    }
                }
                return redirect()->route('observations.index')->with('msg', 'Save Draft Observations Success');
            }

            // Process Submit
            if ($action === 'Submit') {
                $this->validate($request, [
                    'remark_docs' => ['required', 'array'],
                    'remark_docs.*' => ['required'],  // Ensure all remark_docs are filled
                ]);

                foreach ($observations as $observation) {
                    foreach ($request->indicator_id as $index => $indicatorId) {
                        ObservationChecklist::updateOrCreate(
                            [
                                'observation_id' => $observation->id,
                                'indicator_id' => $indicatorId,
                            ],
                            [
                                'remark_docs' => $request->remark_docs[$index] ?? null,
                            ]
                        );
                    }
                }

                // Update the AuditPlan's status
                $data->update([
                    'audit_status_id' => '3',  // Assuming '3' is the status for submitted
                ]);

                // Email notification logic can be added here

                return redirect()->route('observations.index')->with('msg', 'Auditor Comment Added Successfully!');
            }
        }

        // Fetching necessary data for the view
        $locations = Location::orderBy('title')->get();
        $category = StandardCategory::orderBy('description')->get();
        $criteria = StandardCriteria::orderBy('title')->get();

        $auditor = AuditPlanAuditor::where('audit_plan_id', $id)->get();
        $auditPlanAuditorIds = $auditor->pluck('id');

        $categories = AuditPlanCategory::whereIn('audit_plan_auditor_id', $auditPlanAuditorIds)->get();
        $standardCategoryIds = $categories->pluck('standard_category_id');
        $standardCategories = StandardCategory::whereIn('id', $standardCategoryIds)->orderBy('description')->get();

        $criterias = AuditPlanCriteria::whereIn('audit_plan_auditor_id', $auditPlanAuditorIds)->get();
        $standardCriteriaIds = $criterias->pluck('standard_criteria_id');
        $standardCriterias = StandardCriteria::whereIn('id', $standardCriteriaIds)
            ->with('statements.indicators', 'statements.reviewDocs')
            ->orderBy('title')
            ->get();

        $observationIds = $observations->pluck('id');
        $obs_c = ObservationChecklist::whereIn('observation_id', $observationIds)->get();

        // Additional settings if needed
        $hodLPM = Setting::find('HODLPM');
        $hodBPMI = Setting::find('HODBPMI');

        return view('observations.view_doc', compact(
            'standardCategories', 'standardCriterias', 'auditor', 'data',
            'categories', 'criterias', 'observations', 'obs_c', 'hodLPM', 'hodBPMI'
        ));
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

    // Ambil semua data observasi terkait audit plan
    $observations = Observation::where('audit_plan_id', $id)->get();

    if ($request->isMethod('POST')) {
        // dd($request->all());


        $action = $request->input('action');

        // Proses Save Draft
        if ($action === 'Save') {
            foreach ($observations as $observation) {
                $observation->update([
                    'location_id' => $request->input('location_id'),
                    'remark_plan' => $request->input('remark_plan'),
                    'date_checked' => $request->input('date_checked'),
                ]);

                foreach ($request->indicator_id as $index => $indicatorId) {
                    ObservationChecklist::updateOrCreate(
                        [
                            'observation_id' => $observation->id,
                            'indicator_id' => $indicatorId,
                        ],
                        [
                            'remark_description' => $request->remark_description[$index] ?? null,
                            'obs_checklist_option' => $request->obs_checklist_option[$index] ?? null,
                            'remark_success_failed' => $request->remark_success_failed[$index] ?? null,
                            'remark_recommend' => $request->remark_recommend[$index] ?? null,
                        ]
                    );
                }
            }

            return redirect()->route('observations.index')->with('msg', 'Save Draft Observations Success');
        }

        // Proses Submit
        if ($action === 'Submit') {
            $this->validate($request, [
                'location_id' => ['required'],
                'remark_plan' => ['required'],
                'date_checked' => ['required'],
                'remark_description.*' => ['required'],
                'obs_checklist_option.*' => ['required'],
                'remark_success_failed.*' => ['required'],
                'remark_recommend.*' => ['required'],
            ]);
            foreach ($observations as $observation) {
                $observation->update([
                    'location_id' => $request->input('location_id'),
                    'remark_plan' => $request->input('remark_plan'),
                    'date_checked' => $request->input('date_checked'),
                ]);

                foreach ($request->indicator_id as $index => $indicatorId) {
                    ObservationChecklist::updateOrCreate(
                        [
                            'observation_id' => $observation->id,
                            'indicator_id' => $indicatorId,
                        ],
                        [
                            'remark_description' => $request->remark_description[$index] ?? null,
                            'obs_checklist_option' => $request->obs_checklist_option[$index] ?? null,
                            'remark_success_failed' => $request->remark_success_failed[$index] ?? null,
                            'remark_recommend' => $request->remark_recommend[$index] ?? null,
                        ]
                    );
                }
            }

            return redirect()->route('observations.index')->with('msg', 'Observations Updated Successfully');
        }
    }
}

    //remark audit report
    public function remark($id)
    {
        $locations = Location::orderBy('title')->get();
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

        // Ambil daftar observation_id dari koleksi observations
        $observationIds = $observations->pluck('id');

        // Ambil data ObservationChecklist berdasarkan observation_id yang ada dalam daftar
        $obs_c = ObservationChecklist::whereIn('observation_id', $observationIds)->get();
        $hodLPM = Setting::find('HODLPM');
        $hodBPMI = Setting::find('HODBPMI');

        return view('observations.remark',
        compact('standardCategories', 'standardCriterias', 'locations',
        'auditor', 'data', 'category', 'criteria', 'observations', 'obs_c', 'hodLPM', 'hodBPMI'));
    }

    public function update_remark(Request $request, $id)
    {
        $data = AuditPlan::findOrFail($id);
        $auditorId = Auth::user()->id;

        $observations = Observation::where('audit_plan_id', $id)->get();

        if ($request->isMethod('POST')) {
            // dd($request->all());


            $action = $request->input('action');

            // Proses Save Draft
            if ($action === 'Save') {
                foreach ($observations as $observation) {
                    $observation->update([
                        'location_id' => $request->input('location_id'),
                        'remark_plan' => $request->input('remark_plan'),
                        'date_checked' => $request->input('date_checked'),
                    ]);

                    foreach ($request->indicator_id as $index => $indicatorId) {
                        ObservationChecklist::updateOrCreate(
                            [
                                'observation_id' => $observation->id,
                                'indicator_id' => $indicatorId,
                            ],
                            [
                                'plan_completed' => $request->plan_completed[$index] ?? null,
                                'person_in_charge' => $request->person_in_charge[$index] ?? null,
                                'remark_upgrade_repair' => $request->remark_upgrade_repair[$index] ?? null,
                                'remark_description' => $request->remark_description[$index] ?? null,
                                'obs_checklist_option' => $request->obs_checklist_option[$index] ?? null,
                                'remark_success_failed' => $request->remark_success_failed[$index] ?? null,
                                'remark_recommend' => $request->remark_recommend[$index] ?? null,
                            ]
                        );
                    }
                }

                return redirect()->route('observations.index')->with('msg', 'Save Draft Observations Success');
            }

            // Proses Submit
            if ($action === 'Submit') {
                $this->validate($request, [
                    'location_id' => ['required'],
                    'remark_plan' => ['required'],
                    'date_checked' => ['required'],
                    'remark_description.*' => ['required'],
                    'obs_checklist_option.*' => ['required'],
                    'remark_success_failed.*' => ['required'],
                    'remark_recommend.*' => ['required'],
                    'plan_completed.*' => ['required'],
                    'person_in_charge.*' => ['required'],
                    'remark_upgrade_repair.*' => ['required'],
                ]);
                foreach ($observations as $observation) {
                    $observation->update([
                        'location_id' => $request->input('location_id'),
                        'remark_plan' => $request->input('remark_plan'),
                        'date_checked' => $request->input('date_checked'),
                    ]);

                    foreach ($request->indicator_id as $index => $indicatorId) {
                        ObservationChecklist::updateOrCreate(
                            [
                                'observation_id' => $observation->id,
                                'indicator_id' => $indicatorId,
                            ],
                            [
                                'plan_completed' => $request->plan_completed[$index] ?? null,
                                'person_in_charge' => $request->person_in_charge[$index] ?? null,
                                'remark_upgrade_repair' => $request->remark_upgrade_repair[$index] ?? null,
                                'remark_description' => $request->remark_description[$index] ?? null,
                                'obs_checklist_option' => $request->obs_checklist_option[$index] ?? null,
                                'remark_success_failed' => $request->remark_success_failed[$index] ?? null,
                                'remark_recommend' => $request->remark_recommend[$index] ?? null,
                            ]
                        );
                    }
                    $data->update([
                        'audit_status_id' => '12', // Ganti dengan ID status audit yang sesuai
                    ]);
                }

                return redirect()->route('observations.index')->with('msg', 'Observations Updated Successfully');
            }
        }
    }

    public function remark_rtm(Request $request, $id)
    {
        $data = AuditPlan::findOrFail($id);
        $auditorId = Auth::user()->id;

        $observation = Observation::where('audit_plan_id', $id)->get();
        $auditPlanAuditorId = $data->auditor()->where('auditor_id', $auditorId)->first()->id;

        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'status' => [''],
                'remark_rtm_auditor' => [''],
            ]);

            foreach ($observation as $obs) {
                $obs->update([
                'audit_plan_id' => $id,
                'audit_plan_auditor_id' => $auditPlanAuditorId,
            ]);
        }

            foreach ($request->remark_rtm_auditor as $key => $rrtm) {
                $rtm = Rtm::where('observation_id', $obs->id)
                    ->where('indicator_id', $key)
                    ->get(); // Use get() instead of firstOrFail()

                foreach ($rtm as $r) {
                    $r->update([
                        'remark_rtm_auditor' => $rrtm ?? '',
                        'status' => $request->status[$key] ?? '',
                    ]);
                }
            }

            $data->update([
                'audit_status_id'   => '14',
            ]);
            // kirim Email Auditi dan Lpm
        return redirect()->route('observations.index')->with('msg', 'RTM Report Updated Successfully');
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
        $observationIds = $observations->pluck('id');
        $obs_c = ObservationChecklist::whereIn('observation_id', $observationIds)->get();

        $rtm = Rtm::whereIn('observation_id', $observationIds)->get();
        // dd($rtm);
        $hodLPM = Setting::find('HODLPM');
        $hodBPMI = Setting::find('HODBPMI');

        return view('observations.remark_rtm',
        compact('standardCategories', 'standardCriterias',
        'auditor', 'data', 'category', 'criteria',
        'observations', 'obs_c', 'rtm', 'hodLPM', 'hodBPMI'));
    }

    public function rtm($id){
        $data = AuditPlan::with('locations', 'auditee')->findOrFail($id);
        $auditors = AuditPlanAuditor::where('audit_plan_id', $id)
            ->with('auditor:id,name,nidn')
            ->get();

        $categories = AuditPlanCategory::whereIn('audit_plan_auditor_id', $auditors->pluck('id'))->get();
        $criterias = AuditPlanCriteria::whereIn('audit_plan_auditor_id', $auditors->pluck('id'))->get();

        $standardCategoryIds = $categories->pluck('standard_category_id');
        $standardCriteriaIds = $criterias->pluck('standard_criteria_id');

        $standardCategories = StandardCategory::whereIn('id', $standardCategoryIds)->get();
        $standardCriterias = StandardCriteria::with(['statements', 'statements.indicators', 'statements.reviewDocs'])
                                    ->whereIn('id', $standardCriteriaIds)
                                    ->get();

        $observations = Observation::where('audit_plan_id', $id)->get();
        $observationIds = $observations->pluck('id');
        $obs_c = ObservationChecklist::whereIn('observation_id', $observationIds)->get();

        $rtm = Rtm::whereIn('observation_id', $observationIds)->get();

        $hodLPM = Setting::find('HODLPM');
        $hodBPMI = Setting::find('HODBPMI');
        // dd($standardCriterias);
        $pdf = PDF::loadView('pdf.rtm',
        $data = [
            'data' => $data,
            'auditors' => $auditors,
            'categories' => $categories,
            'criterias' => $criterias,
            'standardCategories' => $standardCategories,
            'standardCriterias' => $standardCriterias,
            'observations' => $observations,
            'obs_c' => $obs_c,
            'rtm' => $rtm,
            'hodLPM' => $hodLPM,
            'hodBPMI' => $hodBPMI
        ]);
    // dd( $standardCriterias, $auditor, $data, $observations, $obs_c, $hodLPM, $hodBPMI);

    return $pdf->stream('rtm-report.pdf');
        // return view('pdf.rtm',
        // compact('standardCategories', 'standardCriterias',
        // 'auditors', 'data', 'categories', 'rtm',
        // 'criterias', 'observations', 'obs_c', 'hodLPM', 'hodBPMI'));
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
    ])
    ->leftJoin('locations', 'locations.id', '=', 'location_id')
    ->select(
        'audit_plans.*',
        'locations.title as location'
    )
    ->whereHas('auditor', function ($query) {
        $query->where('auditor_id', Auth::user()->id);
    })
    ->orderBy("id", "desc");

    return DataTables::of($data)
        ->filter(function ($instance) use ($request) {
            // Filter berdasarkan select_auditee
            if (!empty($request->get('select_auditee'))) {
                $instance->whereHas('auditee', function ($q) use ($request) {
                    $q->where('id', $request->get('select_auditee'));
                });
            }

            // Filter berdasarkan pencarian (search)
            if (!empty($request->get('search'))) {
                $search = $request->get('search');
                $instance->where(function ($w) use ($search) {
                    $w->orWhere('date_start', 'LIKE', "%$search%")
                        ->orWhere('date_end', 'LIKE', "%$search%")
                        ->orWhere('locations.title', 'LIKE', "%$search%")
                        ->orWhereHas('auditee', function ($query) use ($search) {
                            $query->where('name', 'LIKE', "%$search%");
                        })
                        ->orWhereHas('auditor.auditor', function ($query) use ($search) {
                            $query->where('name', 'LIKE', "%$search%");
                        });
                });
            }
        })
        ->make(true);
}


// <-----------------  MAKE REPORT  ---------------------->
    // public function view(Request $request, $id)
    // {
    //     $data = AuditPlan::findOrFail($id);
    //     return view('pdf.view', compact('data'));
    // }

    // public function att($id, $type)
    // {
    //     $data = AuditPlan::with('locations', 'auditee')->findOrFail($id);

    //     $auditors = AuditPlanAuditor::where('audit_plan_id', $id)
    //         ->with('auditor:id,name,nidn')
    //         ->get();

    //     $categories = AuditPlanCategory::whereIn('audit_plan_auditor_id', $auditors->pluck('id'))->get();
    //     $criterias = AuditPlanCriteria::whereIn('audit_plan_auditor_id', $auditors->pluck('id'))->get();

    //     $standardCategoryIds = $categories->pluck('standard_category_id');
    //     $standardCriteriaIds = $criterias->pluck('standard_criteria_id');

    //     $standardCategories = StandardCategory::whereIn('id', $standardCategoryIds)->get();
    //     $standardCriterias = StandardCriteria::with(['statements', 'statements.indicators', 'statements.reviewDocs'])
    //                                 ->whereIn('id', $standardCriteriaIds)
    //                                 ->get();

    //     $observations = Observation::where('audit_plan_id', $id)->get();
    //     $observationIds = $observations->pluck('id');
    //     $obs_c = ObservationChecklist::whereIn('observation_id', $observationIds)->get();

    //     $rtm = Rtm::whereIn('observation_id', $observationIds)->get();
    //     // dd($obs_c);
    //     $hodLPM = Setting::find('HODLPM');
    //     $hodBPMI = Setting::find('HODBPMI');

    //     $pdf = PDF::loadView('pdf.att',
    //     $data = [
    //         'data' => $data,
    //         'auditors' => $auditors,
    //         'categories' => $categories,
    //         'criterias' => $criterias,
    //         'standardCategories' => $standardCategories,
    //         'standardCriterias' => $standardCriterias,
    //         'observations' => $observations,
    //         'obs_c' => $obs_c,
    //         'rtm' => $rtm,
    //         'hodLPM' => $hodLPM,
    //         'hodBPMI' => $hodBPMI
    //     ]);
    //     // dd( $standardCriterias, $auditor, $data, $observations, $obs_c, $hodLPM, $hodBPMI);

    //         return $pdf->stream('audit_report_absensi.pdf');
    //     }


    //     public function form_cl($id, $type)
    //     {
    //         $data = AuditPlan::with('locations', 'auditee')->findOrFail($id);

    //         $auditors = AuditPlanAuditor::where('audit_plan_id', $id)
    //         ->with('auditor:id,name,nidn')
    //         ->get();

    //         $categories = AuditPlanCategory::whereIn('audit_plan_auditor_id', $auditors->pluck('id'))->get();
    //         $criterias = AuditPlanCriteria::whereIn('audit_plan_auditor_id', $auditors->pluck('id'))->get();

    //         $standardCategoryIds = $categories->pluck('standard_category_id');
    //         $standardCriteriaIds = $criterias->pluck('standard_criteria_id');

    //         $standardCategories = StandardCategory::whereIn('id', $standardCategoryIds)->get();
    //         $standardCriterias = StandardCriteria::with(['statements', 'statements.indicators', 'statements.reviewDocs'])
    //                                     ->whereIn('id', $standardCriteriaIds)
    //                                     ->get();

    //         $observations = Observation::where('audit_plan_id', $id)->get();
    //         $observationIds = $observations->pluck('id');
    //         $obs_c = ObservationChecklist::whereIn('observation_id', $observationIds)->get();

    //         $rtm = Rtm::whereIn('observation_id', $observationIds)->get();
    //         // dd($obs_c);
    //         $hodLPM = Setting::find('HODLPM');
    //         $hodBPMI = Setting::find('HODBPMI');

    //         $pdf = PDF::loadView('pdf.form_cl',
    //         $data = [
    //             'data' => $data,
    //             'auditors' => $auditors,
    //             'categories' => $categories,
    //             'criterias' => $criterias,
    //             'standardCategories' => $standardCategories,
    //             'standardCriterias' => $standardCriterias,
    //             'observations' => $observations,
    //             'obs_c' => $obs_c,
    //             'rtm' => $rtm,
    //             'hodLPM' => $hodLPM,
    //             'hodBPMI' => $hodBPMI
    //         ]);
    //     // dd( $standardCriterias, $auditor, $data, $observations, $obs_c, $hodLPM, $hodBPMI);

    //         return $pdf->stream('audit_report_form_checklist.pdf');
    //     }

    //     public function meet_report($id, $type)
    // {
    //     $data = AuditPlan::with('locations', 'auditee')->findOrFail($id);

    //     $auditors = AuditPlanAuditor::where('audit_plan_id', $id)
    //         ->with('auditor:id,name,nidn')
    //         ->get();

    //     $categories = AuditPlanCategory::whereIn('audit_plan_auditor_id', $auditors->pluck('id'))->get();
    //     $criterias = AuditPlanCriteria::whereIn('audit_plan_auditor_id', $auditors->pluck('id'))->get();

    //     $standardCategoryIds = $categories->pluck('standard_category_id');
    //     $standardCriteriaIds = $criterias->pluck('standard_criteria_id');

    //     $standardCategories = StandardCategory::whereIn('id', $standardCategoryIds)->get();
    //     $standardCriterias = StandardCriteria::with(['statements', 'statements.indicators', 'statements.reviewDocs'])
    //                                 ->whereIn('id', $standardCriteriaIds)
    //                                 ->get();

    //     $observations = Observation::where('audit_plan_id', $id)->get();
    //     $observationIds = $observations->pluck('id');
    //     $obs_c = ObservationChecklist::whereIn('observation_id', $observationIds)->get();

    //     $rtm = Rtm::whereIn('observation_id', $observationIds)->get();
    //     // dd($obs_c);
    //     $hodLPM = Setting::find('HODLPM');
    //     $hodBPMI = Setting::find('HODBPMI');

    //     $pdf = PDF::loadView('pdf.meet_report',
    //     $data = [
    //         'data' => $data,
    //         'auditors' => $auditors,
    //         'categories' => $categories,
    //         'criterias' => $criterias,
    //         'standardCategories' => $standardCategories,
    //         'standardCriterias' => $standardCriterias,
    //         'observations' => $observations,
    //         'obs_c' => $obs_c,
    //         'rtm' => $rtm,
    //         'hodLPM' => $hodLPM,
    //         'hodBPMI' => $hodBPMI
    //     ]);
    //     // dd( $standardCriterias, $auditor, $data, $observations, $obs_c, $hodLPM, $hodBPMI);

    //         return $pdf->stream('audit_report_berita_acara.pdf');
    //     }
    //     public function ptp_ptk($id, $type)
    // {
    //     $data = AuditPlan::with('locations', 'auditee')->findOrFail($id);

    //     $auditors = AuditPlanAuditor::where('audit_plan_id', $id)
    //         ->with('auditor:id,name,nidn')
    //         ->get();

    //     $categories = AuditPlanCategory::whereIn('audit_plan_auditor_id', $auditors->pluck('id'))->get();
    //     $criterias = AuditPlanCriteria::whereIn('audit_plan_auditor_id', $auditors->pluck('id'))->get();

    //     $standardCategoryIds = $categories->pluck('standard_category_id');
    //     $standardCriteriaIds = $criterias->pluck('standard_criteria_id');

    //     $standardCategories = StandardCategory::whereIn('id', $standardCategoryIds)->get();
    //     $standardCriterias = StandardCriteria::with(['statements', 'statements.indicators', 'statements.reviewDocs'])
    //                                 ->whereIn('id', $standardCriteriaIds)
    //                                 ->get();

    //     $observations = Observation::where('audit_plan_id', $id)->get();
    //     $observationIds = $observations->pluck('id');
    //     $obs_c = ObservationChecklist::whereIn('observation_id', $observationIds)->get();

    //     $rtm = Rtm::whereIn('observation_id', $observationIds)->get();
    //     // dd($obs_c);
    //     $hodLPM = Setting::find('HODLPM');
    //     $hodBPMI = Setting::find('HODBPMI');

    //     $pdf = PDF::loadView('pdf.ptp_ptk',
    //     $data = [
    //         'data' => $data,
    //         'auditors' => $auditors,
    //         'categories' => $categories,
    //         'criterias' => $criterias,
    //         'standardCategories' => $standardCategories,
    //         'standardCriterias' => $standardCriterias,
    //         'observations' => $observations,
    //         'obs_c' => $obs_c,
    //         'rtm' => $rtm,
    //         'hodLPM' => $hodLPM,
    //         'hodBPMI' => $hodBPMI
    //     ]);
    //     return $pdf->stream('audit_report_ptp_ptk.pdf');

    //     // return view('pdf.ptp_ptk',
    //     // compact('standardCategories', 'standardCriterias',
    //     // 'auditors', 'data', 'categories', 'rtm',
    //     // 'criterias', 'observations', 'obs_c', 'hodLPM', 'hodBPMI'));
    //     }
    }
