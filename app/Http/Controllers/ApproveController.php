<?php

namespace App\Http\Controllers;

use App\Mail\revisedStandardToAdmin;
use App\Mail\approveStandardToAdmin;
use App\Mail\notifUplodeDocAuditee;
use App\Mail\approvRTMBylpm;
use App\Models\AuditPlan;
use App\Models\Observation;
use App\Models\AuditPlanAuditor;
use App\Models\AuditPlanCategory;
use App\Models\AuditPlanCriteria;
use App\Models\Department;
use App\Models\Location;
use App\Models\ObservationChecklist;
use App\Models\Rtm;
use App\Models\Setting;
use App\Models\StandardCategory;
use App\Models\StandardCriteria;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Mail;

class ApproveController extends Controller
{
    public function lpm(Request $request){
        $data = AuditPlan::all();
        return view('lpm.index', compact('data'));
    }

    public function lpm_standard(Request $request, $id){
    $data = AuditPlan::findOrFail($id);
    $auditorId = Auth::user()->id;

    if ($request->isMethod('POST')) {
        $this->validate($request, [
            'remark_standard_lpm' => '',
        ]);
        $action = $request->input('action');

        if ($action === 'Approve') {
            $remark = 'Approve';
            $status = 4;

                // Mengirim email ke auditee yang terkait dengan audit plan
                $auditee = $data->auditee;
                Mail::to($auditee->email)->send(new notifUplodeDocAuditee($data));

                // Send email notifications to LPM users
                $lpmUsers = User::whereHas('roles', function ($q) {
                    $q->where('name', 'lpm');
                })->orderBy('name')->get();

                foreach ($lpmUsers as $user) {
                    Mail::to($user->email)->send(new approveStandardToAdmin($id));
                }
            } elseif ($action === 'Revised') {
                $this->validate($request, [
                    'remark_standard_lpm' => ['required'],
                ]);
                $remark = $request->input('remark_standard_lpm');
                $status = 5;

                    // Send email notifications to LPM users
                    $emailData = [
                        'remark_standard_lpm' =>$request->remark_standard_lpm,
                    ];
                    $lpmUsers = User::whereHas('roles', function ($q) {
                    $q->where('name', 'lpm');
                    })->orderBy('name')->get();
                    foreach ($lpmUsers as $user) {
                        Mail::to($user->email)->send(new revisedStandardToAdmin($emailData));
                    }
            }
            $data->update([
                'remark_standard_lpm' => $remark,
                'audit_status_id' => $status,
            ]);
            return redirect()->route('lpm.index')->with('msg', 'Standard Updated by LPM.');
        }

        //     // Mendapatkan ID auditor terkait
        //     $auditPlanAuditorId = $data->auditor()->where('auditor_id', $auditorId)->first()->id;

        //     // Membuat Observation
        //     Observation::create([
        //         'audit_plan_id' => $id,
        //         'audit_plan_auditor_id' => $auditPlanAuditorId,
        //         'remark_standard_lpm' => $remark,
        //     ]);

        //     // Memperbarui status audit plan
        //     $data->update([
        //         'audit_status_id' => $status,
        //     ]);

        //     return redirect()->route('lpm.index')->with('msg', 'Standard diperbarui.');
        // }

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
        $observationIds = $observations->pluck('id');
        $obs_c = ObservationChecklist::whereIn('observation_id', $observationIds)->get();
        $hodLPM = Setting::find('HODLPM');
        $hodBPMI = Setting::find('HODBPMI');
        $StatusCheck = [1, 2, 5, 13];
        $StatusReport = [6, 8];

        if (in_array($data->audit_status_id, $StatusCheck)) {
            return view('lpm.check', [
                'standardCategories' => $standardCategories,
                'standardCriterias' => $standardCriterias,
                'auditor' => $auditor,
                'data' => $data,
                'category' => $category,
                'criteria' => $criteria,
                'observations' => $observations,
                'obs_c' => $obs_c,
                'hodLPM' => $hodLPM,
                'hodBPMI' => $hodBPMI
            ]);
        } elseif (in_array($data->audit_status_id, $StatusReport)) {
            return view('lpm.remark', [
                'standardCategories' => $standardCategories,
                'standardCriterias' => $standardCriterias,
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

    public function lpm_edit($id){
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
        $observations = Observation::where('audit_plan_id', $id)->get();
        $observationIds = $observations->pluck('id');
        $obs_c = ObservationChecklist::whereIn('observation_id', $observationIds)->get();
        $hodLPM = Setting::find('HODLPM');
        $hodBPMI = Setting::find('HODBPMI');
        $rtm = Rtm::whereIn('observation_id', $observationIds)->get();
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
            'rtm' => $rtm,
            'hodLPM' => $hodLPM,
            'hodBPMI' => $hodBPMI
        ]);
    // dd( $standardCriterias, $auditor, $data, $observations, $obs_c, $hodLPM, $hodBPMI);

    return $pdf->stream('make-report.pdf');
        // return view('lpm.print',
        // compact('standardCategories', 'standardCriterias',
        // 'auditorData', 'auditor', 'data', 'category',
        // 'criteria', 'observations', 'obs_c', 'hodLPM', 'hodBPMI'));
    }


    public function lpm_apv_audit(Request $request, $id){
        $data = AuditPlan::findOrFail($id);
        $auditorId = Auth::user()->id;

        if ($request->isMethod('POST')) {
            // dd($request);
            $this->validate($request, [
                'date_validated' => [''],
                'remark_audit_lpm' => [''],
            ]);

            $action = $request->input('action');

            if ($action === 'Approve') {
                $remark = 'Approve';
                $status = 9;
                // kirim email ke auditor auditee
                // email untuk auditee
                $auditee = $data->auditee;
            Mail::to($auditee->email)->send(new approvRTMBylpm($data));
            // Email untuk auditor
            $auditPlanId = $data->id;
            $auditors = AuditPlanAuditor::where('audit_plan_id', $auditPlanId)->with('auditor')->get();
            foreach ($auditors as $auditPlanAuditor) {
                $auditor = $auditPlanAuditor->auditor;

                if ($auditor && $auditor->email) {
                    Mail::to($auditor->email)->send(new approvRTMBylpm($data));
                }
            }

            } elseif ($action === 'Revised') {
                $this->validate($request, [
                    'remark_audit_lpm' => ['required'],
                ]);
                $remark = $request->input('remark_audit_lpm');
                $status = 8;
            }
            // kirim email ke auditor

            $observation = Observation::findOrFail($id);

            $observation->update([
                'date_validated' => $request->date_validated,
                'remark_audit_lpm' => $remark,
            ]);

                $data->update([
                    'audit_status_id' => $status,
                ]);
            }

            return redirect()->route('lpm.index')->with('msg', 'Audit Report Updated by LPM!!');
        }

    public function rtm(Request $request){
        $data = AuditPlan::all();
        $currentYear = date('Y');
        $periode = [];

        for ($i = 0; $i < 3; $i++) {
            $startYear = $currentYear - $i;
            $endYear = $startYear + 1;
            $periode[] = "{$startYear}/{$endYear}";
        }
        return view('rtm.index', compact('data', 'periode'));
    }

    public function rtm_edit($id){
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
        $observations = Observation::where('audit_plan_id', $id)->get();
        $observationIds = $observations->pluck('id');
        $obs_c = ObservationChecklist::whereIn('observation_id', $observationIds)->get();
        $hodLPM = Setting::find('HODLPM');
        $hodBPMI = Setting::find('HODBPMI');
        $rtm = Rtm::whereIn('observation_id', $observationIds)->get();

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
            'rtm' => $rtm,
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

    public function approver(Request $request){
        $data = AuditPlan::all();
        return view('approver.index', compact('data'));
    }

    public function app_rtm($id){
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

    public function approve_data(Request $request){
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
            ->orderBy("id", 'desc');
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

    public function rtm_data(Request $request)
{
    $query = Department::with(['auditPlans']);

    if (!empty($request->get('select_periode'))) {
        $query->whereHas('auditPlans', function($q) use ($request) {
            $q->where('periode', $request->get('select_periode'));
        });
    }

    if (!empty($request->get('search'))) {
        $query->where('name', 'LIKE', "%{$request->get('search')}%");
    }

    $data = $query->get();

    return DataTables::of($data)
        ->addColumn('periode', function ($department) {
            $periodes = $department->auditPlans->pluck('periode')->unique();
            return $periodes->isEmpty() ? 'Has not Audit periode' : $periodes->implode(', ');
        })
        ->make(true);
    }
}
