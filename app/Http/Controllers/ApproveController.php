<?php

namespace App\Http\Controllers;

use App\Models\AuditPlan;
use App\Models\Observation;
use App\Models\AuditPlanAuditor;
use App\Models\AuditPlanCategory;
use App\Models\AuditPlanCriteria;
use App\Models\Department;
use App\Models\Location;
use App\Models\ObservationChecklist;
use App\Models\Setting;
use App\Models\StandardCategory;
use App\Models\StandardCriteria;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ApproveController extends Controller
{
    public function lpm(Request $request){
        $data = AuditPlan::all();
        return view('lpm.index', compact('data'));
    }

    public function lpm_edit(Request $request, $id){
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
        $obs_c = ObservationChecklist::where('observation_id', $id)->get();
        $hodLPM = Setting::find('HODLPM');
        $hodBPMI = Setting::find('HODBPMI');
        return view('observations.print',
        compact('standardCategories', 'standardCriterias',
        'auditorData', 'auditor', 'data', 'category', 'criteria', 'observations', 'obs_c', 'hodLPM', 'hodBPMI'));
    }

    public function lpm_update(Request $request, $id){
        $request->validate([
            'remark_by_lpm'    => '',
        ]);

        $obs = Observation::findOrFail($id);
        $obs->update([
            'remark_by_lpm' => $request->remark_by_lpm,
            'audit_status_id' => '3',
        ]);
    }

    public function approver(Request $request){
        $data = AuditPlan::all();
        return view('approver.index', compact('data'));
    }

    public function approver_edit(Request $request, $id){
        $request->validate([
            'remark_by_approver'    => 'required',
        ]);

        $obs = Observation::findOrFail($id);
        $obs->update([
            'remark_by_approver' => $request->remark_by_approver,
            'audit_status_id' => '3',
        ]);
    }

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
}
