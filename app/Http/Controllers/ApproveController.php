<?php

namespace App\Http\Controllers;

use App\Mail\revisedStandardToAdmin;
use App\Mail\approveStandardToAdmin;
use App\Mail\notifUplodeDocAuditee;
use App\Models\AuditPlan;
use App\Models\Observation;
use App\Models\AuditPlanAuditor;
use App\Models\AuditPlanCategory;
use App\Models\AuditPlanCriteria;
use App\Models\Location;
use App\Models\ObservationChecklist;
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

        // Fungsi untuk mendapatkan data pengguna berdasarkan peran
        function getUsersByRoleId($roleName, $userId) {
            return User::with(['roles' => function ($query) {
                $query->select('id', 'name');
            }])
            ->whereHas('roles', function ($q) use ($roleName) {
                $q->where('name', $roleName);
            })
            ->where('id', $userId)
            ->orderBy('name')
            ->get();
        }

        // Data untuk notifikasi email
        $admin = getUsersByRoleId('admin', $id);
        $auditee = getUsersByRoleId('auditee', $id);

        if ($action === 'Approve') {
            $remark = 'Approve';
            $status = 4;
            // notification email Apabila Standard Di Approve
            $emailData = [
                'approve' =>$request->approve,
                'subject_1' => 'Approve Standard For LPM'
                ]; 
            // foreach ($admin as $user) {Mail::to($user->email)->send(new approveStandardToAdmin($emailData));}
            // foreach ($auditee as $user) {Mail::to($user->email)->send(new notifUplodeDocAuditee($id));}

        } elseif ($action === 'Revised') {
            $this->validate($request, [
                'remark_standard_lpm' => ['required'],
            ]);
            $remark = $request->input('remark_standard_lpm');
            $status = 5;
            // notification email Apabila Standard Revised
            $emailData = [
                'remark_standard_lpm' =>$request->remark_standard_lpm,
                'subject' => 'Revised Standard For LPM'
            ];
            foreach ($admin as $user) {
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
        $obs_c = ObservationChecklist::where('observation_id', $id)->get();
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
        $observations = Observation::where('audit_plan_auditor_id', $id)->get();
        $obs_c = ObservationChecklist::where('observation_id', $id)->get();
        $hodLPM = Setting::find('HODLPM');
        $hodBPMI = Setting::find('HODBPMI');

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
            } elseif ($action === 'Revised') {
                $this->validate($request, [
                    'remark_audit_lpm' => ['required'],
                ]);
                $remark = $request->input('remark_audit_lpm');
                $status = 8;
            }

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
        return view('rtm.index', compact('data'));
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

    // public function approver_edit(Request $request, $id){
    //     $request->validate([
    //         'remark_by_approver'    => 'required',
    //     ]);

    //     $obs = Observation::findOrFail($id);
    //     $obs->update([
    //         'remark_by_approver' => $request->remark_by_approver,
    //         'audit_status_id' => '8',
    //     ]);
    // }

    // public function approve(Request $request)
    //     {
    //         $data = AuditPlan::find($request->id);
    //         if ($data) {
    //             $data->audit_status_id = "6";
    //             $data->save();
    //             return response()->json([
    //                 'success' => true,
    //                 'message' => 'Status berhasil diubah!'
    //             ]);
    //         } else {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Gagal mengubah status!'
    //             ]);
    //         }
    //     }

        // public function revised(Request $request){
        //     $data = AuditPlan::find($request->id);
        //     if($data){
        //         $data->audit_status_id ="7";
        //         $data->save();
        //         return response()->json([
        //             'success' => true,
        //             'message' => ' Status berhasil diubah!'
        //         ]);
        //     } else {
        //         return response()->json([
        //             'success' => false,
        //             'message' => 'Gagal mengubah status!'
        //         ]);
        //     }
        // }

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
}
