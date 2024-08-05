<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuditPlan;
use App\Models\AuditPlanAuditor;
use App\Models\AuditPlanCategory;
use App\Models\AuditPlanCriteria;
use App\Models\Department;
use App\Models\Location;
use App\Models\ObservationChecklist;
use App\Models\Observation;
use App\Models\Setting;
use App\Models\StandardCategory;
use App\Models\StandardCriteria;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class PDFController extends Controller
{
    public function view(Request $request, $id)
    {
        $data = AuditPlan::findOrFail($id);
        $auditee = User::with(['roles' => function ($query) {
            $query->select('id', 'name');
        }])
            ->whereHas('roles', function ($q) use ($request) {
                $q->where('name', 'auditee');
            })
            ->orderBy('name')->get();
        return view('make_report.view', compact('data', 'auditee'));
    }

    public function att(Request $request, $id)
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

        return view('make_report.att',
        compact('standardCategories', 'standardCriterias',
        //  'indicators', 'subIndicators', 'reviewDocs',
        'auditorData', 'auditor', 'data', 'locations', 'department', 'category', 'criteria'));
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
