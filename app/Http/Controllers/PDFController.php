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
use App\Models\Rtm;
use App\Models\Setting;
use App\Models\StandardCategory;
use App\Models\StandardCriteria;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PDFController extends Controller
{
    public function view(Request $request, $id)
    {
        $data = AuditPlan::findOrFail($id);
        return view('pdf.view', compact('data'));
    }

    public function att($id, $type)
    {
        $data = AuditPlan::with('locations', 'auditee')->findOrFail($id);
        $auditorId = Auth::user()->id;
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

        $observations = Observation::where('audit_plan_id', $id)
                                    ->with('location')
                                    ->get();
        $observationIds = $observations->pluck('id');
        $obs_c = ObservationChecklist::whereIn('observation_id', $observationIds)->get();
        $rtm = Rtm::whereIn('observation_id', $observationIds)->get();
        $hodLPM = Setting::find('HODLPM');
        $hodBPMI = Setting::find('HODBPMI');

        $pdf = PDF::loadView('pdf.att', compact('standardCategories', 'standardCriterias',
        'auditors', 'data', 'categories', 'criterias', 'observations', 'obs_c', 'rtm', 'hodLPM', 'hodBPMI'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('Audit Report Absensi'.$data->auditee->name." - ".date('d-m-Y', strtotime($data->date_start)).".pdf");
    }


        public function form_cl($id, $type)
        {
            $data = AuditPlan::with('locations', 'auditee')->findOrFail($id);

            $auditorId = Auth::user()->id;

            if (Auth::user()->role == 'auditee') {
            }
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
            // dd($obs_c);
            $hodLPM = Setting::find('HODLPM');
            $hodBPMI = Setting::find('HODBPMI');

            $pdf = PDF::loadView('pdf.form_cl', compact('standardCategories', 'standardCriterias',
        'auditors', 'data', 'categories', 'criterias', 'observations', 'obs_c', 'rtm', 'hodLPM', 'hodBPMI'));
        $pdf->setPaper('A4', 'potrait');
        return $pdf->stream('Audit Report Form Checklist'.$data->auditee->name." - ".date('d-m-Y', strtotime($data->date_start)).".pdf");
    }

    public function ks_Kts($id, $type)
        {
            $data = AuditPlan::with('locations', 'auditee')->findOrFail($id);

            $auditorId = Auth::user()->id;

            if (Auth::user()->role == 'auditee') {
            }
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
            // dd($obs_c);
            $hodLPM = Setting::find('HODLPM');
            $hodBPMI = Setting::find('HODBPMI');

            $pdf = PDF::loadView('pdf.ks_kts', compact('standardCategories', 'standardCriterias',
        'auditors', 'data', 'categories', 'criterias', 'observations', 'obs_c', 'rtm', 'hodLPM', 'hodBPMI'));
        $pdf->setPaper('A4', 'potrait');
        return $pdf->stream('Audit Report Form KS & KTS'.$data->auditee->name." - ".date('d-m-Y', strtotime($data->date_start)).".pdf");
    }

        public function meet_report($id, $type)
    {
        $data = AuditPlan::with('locations', 'auditee')->findOrFail($id);

        $auditorId = Auth::user()->id;

        if (Auth::user()->role == 'auditee') {
        }
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

        $pdf = PDF::loadView('pdf.meet_report', compact('standardCategories', 'standardCriterias',
        'auditors', 'data', 'categories', 'criterias', 'observations', 'obs_c', 'rtm', 'hodLPM', 'hodBPMI'));
        $pdf->setPaper('A4', 'potrait');
        return $pdf->stream('Audit Report Berita Acara'.$data->auditee->name." - ".date('d-m-Y', strtotime($data->date_start)).".pdf");
    }

        public function ptp_ptk($id, $type)
    {
        $data = AuditPlan::with('locations', 'auditee')->findOrFail($id);

        $auditorId = Auth::user()->id;

        if (Auth::user()->role == 'auditee') {
        }
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
        // dd($obs_c);
        $hodLPM = Setting::find('HODLPM');
        $hodBPMI = Setting::find('HODBPMI');

        $pdf = PDF::loadView('pdf.ptp_ptk', compact('standardCategories', 'standardCriterias',
        'auditors', 'data', 'categories', 'criterias', 'observations', 'obs_c', 'rtm', 'hodLPM', 'hodBPMI'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('Audit Report PTK/PTK'.$data->auditee->name." - ".date('d-m-Y', strtotime($data->date_start)).".pdf");
    }

    public function rtm($id){
        $data = AuditPlan::with('locations', 'auditee', 'departments')->findOrFail($id);

        // Get the auditee's department
        $auditeeDepartment = $data->auditee->departments->department_id;

        // Filter data based on the department
        $auditors = AuditPlanAuditor::where('audit_plan_id', $id)
            ->whereHas('auditor', function($query) use ($auditeeDepartment) {
                $query->where('department_id', $auditeeDepartment);
            })
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

        $observations = Observation::where('audit_plan_id', $id)
            ->where('department_id', $auditeeDepartment)
            ->get();
        $observationIds = $observations->pluck('id');
        $obs_c = ObservationChecklist::whereIn('observation_id', $observationIds)->get();

        $rtm = Rtm::whereIn('observation_id', $observationIds)->get();

        $hodLPM = Setting::find('HODLPM');
        $hodBPMI = Setting::find('HODBPMI');

        // Generate the PDF
        $pdf = PDF::loadView('pdf.rtm', [
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

        return $pdf->stream('rtm-report.pdf');
        // return view('lpm.print',
        // compact('standardCategories', 'standardCriterias',
        // 'auditorData', 'auditor', 'data', 'category',
        // 'criteria', 'observations', 'obs_c', 'hodLPM', 'hodBPMI'));
    }
}
