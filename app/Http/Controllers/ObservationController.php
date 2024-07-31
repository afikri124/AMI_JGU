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

        return view('observations.make',
        compact('standardCategories', 'standardCriterias',
        //  'indicators', 'subIndicators', 'reviewDocs',
        'auditorData', 'auditor', 'data', 'locations', 'department', 'category', 'criteria'));
    }

    public function make(Request $request, $id)
    {
        $data = AuditPlan::findOrFail($id);
        $auditorId = Auth::user()->id;

        if ($request->isMethod('POST')) {
            // dd($request);

            $this->validate($request, [
                'location_id' => [],
                'remark_plan' => [],
                'remark_description' => [],
                'obs_checklist_option' => [],
                'remark_success_failed' => [],
                'remark_recommend' => [],
                'remark_upgrade_repair' => [],
                'person_in_charge' => [],
                'plan_complated' => [],
            ]);

            // dd($request);
            $auditPlanAuditorId = $data->auditor()->where('auditor_id', $auditorId)->first()->id;

            // Create Observation
            $obs = Observation::create([
                'audit_status_id' => '3',
                'audit_plan_id' => $id,
                'audit_plan_auditor_id' => $auditPlanAuditorId,
                'location_id' => $request->location_id,
                'remark_plan' => $request->remark_plan,
                'person_in_charge' => $request->person_in_charge,
                'plan_complated' => $request->plan_complated,
            ]);

            // Create Observation Checklists
            foreach ($request->obs_checklist_option as $key => $obs_c) {
                ObservationChecklist::create([
                    'indicator_id' => $key,
                    'observation_id' => $obs->id,
                    'remark_description' => $request->remark_description[$key] ?? '',
                    'obs_checklist_option' => $obs_c ?? '',
                    'remark_success_failed' => $request->remark_success_failed[$key] ?? '',
                    'remark_recommend' => $request->remark_recommend[$key] ?? '',
                    'remark_upgrade_repair' => $request->remark_upgrade_repair[$key] ?? '',
                ]);
            }

            return redirect()->route('observations.index')->with('msg', 'Observasition succeeded!!');
        }
    }

    public function edit($id)
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
        // dd($obs_c);

        $hodLPM = Setting::find('HODLPM');
        $hodBPMI = Setting::find('HODBPMI');

        return view('observations.print',
        compact('standardCategories', 'standardCriterias',
        'auditorData', 'auditor', 'data', 'category', 'criteria',
        'observations', 'obs_c', 'hodLPM', 'hodBPMI'));
    }

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

        // dd($obs_c);

        $hodLPM = Setting::find('HODLPM');
        $hodBPMI = Setting::find('HODBPMI');

        return view('observations.remark',
        compact('standardCategories', 'standardCriterias',
        'auditorData', 'auditor', 'data', 'category', 'criteria',
        'observations', 'obs_c','hodLPM', 'hodBPMI'));
    }

    public function update(Request $request, $id)
    {
        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'remark_docs' => '',
            ]);

            $data = AuditPlan::findOrFail($id);
            $data->update([
                'remark_docs' => $request->remark_docs,
                'audit_status_id' => '3',
            ]);

        return redirect()->route('observations.index')->with('msg', 'Document reviewed, you are ready for Observation');
    }
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
                'remark_plan' => '',
            ]);

            $observation->update([
                'audit_status_id' => '4',
                'remark_plan' => $request->remark_plan,
            ]);


        // if ($data) {
        //     // Cari pengguna dan departemen berdasarkan ID yang ada dalam request
        //     $auditee = User::find($request->auditee_id);
        //     $department = Department::find($request->department_id);

        //     if ($auditee) {
        //         // Data untuk email
        //         $emailData = [
        //             'auditee_id'    => $auditee->name,
        //             'remark_docs'   => $request->remark_docs,
        //             'date_start'    => $request->date_start,
        //             'date_end'      => $request->date_end,
        //             'department_id' => $department ? $department->name : null,
        //         ];

        //         // Kirim email ke pengguna yang ditemukan
        //         Mail::to($auditee->email)->send(new CommentDocs($emailData));

        //         // Redirect dengan pesan sukses
        //         return redirect()->route('observations.index')->with('msg', 'Document telah di Review, Siap untuk Audit Lapangan');
        //     } else {
        //         // Redirect dengan pesan error jika pengguna tidak ditemukan
        //         return redirect()->route('observations.index')->with('msg', 'Pengguna tidak ditemukan');
        //     }
        // } else {
        //     // Redirect dengan pesan error jika data tidak berhasil diupdate
        //     return redirect()->route('observations.index')->with('msg', 'Data gagal diupdate');
        // }
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
            'auditorId' => function ($query) {
                $query->select('id', 'name');
            },
            'category' => function ($query) {
                $query->select('id', 'description');
            },
            'departments' => function ($query) {
                $query->select('id', 'name');
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
    }
