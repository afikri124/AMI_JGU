<?php

namespace App\Http\Controllers;

use App\Mail\auditeeUploadDoc;
use App\Mail\auditingFinish;
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
use App\Models\Rtm;
use App\Models\User;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;


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
    $total_indicator = 0;

if ($request->isMethod('POST')) {
    $auditPlanAuditor = AuditPlanAuditor::where('audit_plan_id', $id)->first();

    $obs = Observation::firstOrCreate([
        'audit_plan_id' => $id,
        'audit_plan_auditor_id' => $auditPlanAuditor->id,
    ]);

    if ($request->ajax()) {
        $data = AuditPlan::findOrFail($id);

        if ($request->has('final_submit')) {
            // Menghitung total checklist berdasarkan syarat yang baru
            $totalI = ObservationChecklist::
                        select('*')
                        ->where(function ($query) {
                            $query->where(function ($query) {
                                    // Harus ada salah satu antara file atau link yang diisi
                                    $query->whereNotNull('doc_path')
                                        ->orWhereNotNull('link');
                                })
                                // Komentar/remark harus selalu diisi
                                ->whereNotNull('remark_path_auditee');
                        })
                        ->where('observation_id', '=', $obs->id)
                        ->count();

            if ($totalI != $request->total_indicator) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry, there are incomplete documents. Ensure file or link is filled and remark is provided.'
                ]);
            } else {
                $data->update([
                    'audit_status_id' => '11', // Ganti dengan ID status audit yang sesuai
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Audit Document Successfully Submitted'
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to submit audit document'
        ]);
    } elseif ($request->has('save_file')) {
            // Logika untuk tombol save file
            $this->validate($request, [
                'doc_path' => 'nullable|mimes:png,jpg,jpeg,pdf,xls,xlsx|max:50000',
            ]);

            if ($request->hasFile('doc_path')) {
                $file = $request->file('doc_path');
                $filePath = null;

                if ($file) {
                    $ext = $file->extension();
                    $name = str_replace(' ', '_', $file->getClientOriginalName());
                    $fileName = Auth::user()->id . '_' . $name;
                    $folderName = "storage/FILE/" . Carbon::now()->format('Y/m');
                    $path = public_path($folderName);

                    if (!File::exists($path)) {
                        File::makeDirectory($path, 0755, true); // Buat folder jika belum ada
                    }

                    $upload = $file->move($path, $fileName);
                    if ($upload) {
                        $filePath = $folderName . "/" . $fileName;
                    }
                }

                ObservationChecklist::updateOrCreate(
                    [
                        'observation_id' => $obs->id,
                        'indicator_id' => $request->indicator_id,
                    ],
                    [
                        'doc_path' => $filePath,
                    ]
                );
            }

            return redirect()->route('my_audit.my_standard', $data->id)->with('msg', 'File Successfully Uploaded');
        } elseif ($request->has('save_link')) {
            // Logika untuk tombol save link
            $this->validate($request, [
                'link' => 'nullable|max:500000',
            ]);

            ObservationChecklist::updateOrCreate(
                [
                    'observation_id' => $obs->id,
                    'indicator_id' => $request->indicator_id,
                ],
                [
                    'link' => $request->link,
                ]
            );

            return redirect()->route('my_audit.my_standard', $data->id)->with('msg', 'Link Successfully Saved');
        } elseif ($request->has('save_remark')) {
            // Logika untuk tombol save remark path auditee
            $this->validate($request, [
                'remark_path_auditee' => 'required|max:250',
            ]);

            ObservationChecklist::updateOrCreate(
                [
                    'observation_id' => $obs->id,
                    'indicator_id' => $request->indicator_id,
                ],
                [
                    'remark_path_auditee' => $request->remark_path_auditee,
                ]
            );

            return redirect()->route('my_audit.my_standard', $data->id)->with('msg', 'Remark Successfully Saved');
        }
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
        $obsChecklist = ObservationChecklist::whereHas('obs_c', function ($query) use ($id) {
            $query->where('audit_plan_id', $id);
        })->get();
        $hodLPM = Setting::find('HODLPM');
        $hodBPMI = Setting::find('HODBPMI');
        if ($data->audit_status_id == 4) {
            return view('my_audit.view', [
                'total_indicator' => $total_indicator,
                'data' => $data,
                'auditor' => $auditor,
                'category' => $category,
                'criteria' => $criteria,
                'standardCategories' => $standardCategories,
                'standardCriterias' => $standardCriterias,
                'observations' => $observations,
                'obs_c' => $obs_c,
                'obsChecklist' => $obsChecklist,
                'hodLPM' => $hodLPM,
                'hodBPMI' => $hodBPMI
            ]);
        } elseif ($data->audit_status_id == 3){
            return view('my_audit.doc',[
                'data' => $data,
                'auditor' => $auditor,
                'category' => $category,
                'criteria' => $criteria,
                'standardCategories' => $standardCategories,
                'standardCriterias' => $standardCriterias,
                'observations' => $observations,
                'obs_c' => $obs_c,
                'hodLPM' => $hodLPM,
                'hodBPMI' => $hodBPMI
            ]);
        }
    }

    public function deleteFile($id)
{
    $checklist = ObservationChecklist::findOrFail($id);

    // Hapus file fisik jika ada
    if ($checklist->doc_path && File::exists(public_path($checklist->doc_path))) {
        File::delete(public_path($checklist->doc_path));
    }

    // Hapus file path dari database
    $checklist->doc_path = null;
    $checklist->save();

    return redirect()->back()->with('msg', 'File successfully deleted');
}

public function deleteLink($id)
{
    $checklist = ObservationChecklist::findOrFail($id);

    // Hapus link dari database jika ada
    if ($checklist->link) {
        $checklist->link = null;
        $checklist->save();
    }

    return redirect()->back()->with('msg', 'Link successfully deleted');
}

    public function obs( $id)
    {
        $locations = Location::orderBy('title')->get();
        $category = StandardCategory::orderBy('description')->get();
        $criteria = StandardCriteria::orderBy('title')->get();
        $data = AuditPlan::findOrFail($id);

        $auditorId = Auth::user()->id;

        if (Auth::user()->role == 'auditee') {
        }
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
        if ($data->audit_status_id == 6) {
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
            return $pdf->stream('audit-report.pdf');
        }
    }

    //Proses update Observations
    public function show(Request $request, $id)
{
    $data = AuditPlan::findOrFail($id);
    $auditorId = Auth::user()->id;

    // Ambil semua data observasi terkait audit plan
    $observations = Observation::where('audit_plan_id', $id)->get();

    if ($request->isMethod('POST')) {
        // Validasi umum


        $action = $request->input('action');

        // Proses Save Draft
        if ($action === 'Save') {
            $this->validate($request, [
                'person_in_charge' => ['nullable'],
                'plan_completed' => ['nullable'],
                'date_prepared' => ['nullable'],
                'remark_upgrade_repair' => ['nullable'],
            ]);
            // Update data observasi terkait
            foreach ($observations as $observation) {
                $observation->update([
                    'date_prepared' => $request->input('date_prepared'),
                ]);

                // Update checklist observasi
                foreach ($request->indicator_id as $index => $indicatorId) {
                    ObservationChecklist::updateOrCreate(
                        [
                            'observation_id' => $observation->id,
                            'indicator_id' => $indicatorId,
                        ],
                        [
                            'plan_completed' => $request->input("plan_completed.$index"),
                            'person_in_charge' => $request->input("person_in_charge.$index"),
                            'remark_upgrade_repair' => $request->input("remark_upgrade_repair.$index"),
                        ]
                    );
                }
            }

            return redirect()->route('my_audit.index')->with('msg', 'Save Draft Observations Success');
        }
        if ($action === 'Submit') {
            $this->validate($request, [
                'person_in_charge' => ['required'],
                'plan_completed' => ['required'],
                'date_prepared' => ['required'],
                'remark_upgrade_repair' => ['required'],
            ]);
            foreach ($observations as $observation) {
                $observation->update([
                    'date_prepared' => $request->input('date_prepared'),
                ]);

                // Update checklist observasi
                foreach ($request->indicator_id as $index => $indicatorId) {
                    ObservationChecklist::updateOrCreate(
                        [
                            'observation_id' => $observation->id,
                            'indicator_id' => $indicatorId,
                        ],
                        [
                            'plan_completed' => $request->input("plan_completed.$index"),
                            'person_in_charge' => $request->input("person_in_charge.$index"),
                            'remark_upgrade_repair' => $request->input("remark_upgrade_repair.$index"),
                        ]
                    );
                }
                $data->update([
                    'audit_status_id' => '15', // Ganti dengan ID status audit yang sesuai
                ]);
            }
            return redirect()->route('my_audit.index')->with('msg', 'Observations Updated Successfully');
        }
    }
    // Data untuk tampilan
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
    $hodLPM = Setting::find('HODLPM');
    $hodBPMI = Setting::find('HODBPMI');

    return view('my_audit.show',
    compact('standardCategories', 'standardCriterias',
    'auditor', 'data', 'category', 'criteria', 'observations', 'obs_c', 'hodLPM', 'hodBPMI'));
}


    public function edit_rtm(Request $request, $id)
    {
        $data = AuditPlan::findOrFail($id);
        $auditorId = Auth::user()->id;
        $observations = Observation::where('audit_plan_id', $id)->get();
        $auditPlanAuditor = AuditPlanAuditor::where('audit_plan_id', $id)->first();

        if ($request->isMethod('POST')) {
            // Update observation records
            foreach ($observations as $obs) {
                $obs->update([
                    'audit_plan_id' => $data->id,
                    'audit_plan_auditor_id' => $auditPlanAuditor->id,
                ]);
            }

            // Final Submit Logic
            if ($request->ajax()) {
                if ($request->has('final_submit')) {
                    // Validate checklist
                    $totalRtm = Rtm::where(function ($query) use ($obs) {
                        $query->whereNotNull('doc_path_rtm')
                              ->whereNotNull('remark_rtm_auditee')
                              ->where('observation_id', $obs->id);
                    })->count();

                    if ($totalRtm != $request->total_indicator) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Incomplete documents. Ensure files/links and remarks are provided.'
                        ]);
                    }

                    // Update audit status
                    $data->update(['audit_status_id' => '6']);
                    return response()->json([
                        'success' => true,
                        'message' => 'Document RTM uploaded/updated successfully!'
                    ]);
                }

                return response()->json(['success' => false, 'message' => 'Failed to submit audit document']);
            }

            // Save File Logic
            if ($request->has('save_file')) {
                $this->validate($request, [
                    'doc_path_rtm' => 'nullable|mimes:png,jpg,jpeg,pdf,xls,xlsx|max:50000',
                ]);

                $filePaths = [];
                if ($request->hasFile('doc_path_rtm')) {
                    foreach ($request->file('doc_path_rtm') as $index => $file) {
                        $fileName = Auth::user()->id . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                        $folderName = "storage/FILE/RTM" . Carbon::now()->format('Y/m');
                        $path = public_path($folderName);

                        if (!File::exists($path)) {
                            File::makeDirectory($path, 0755, true);
                        }

                        $filePath = $file->move($path, $fileName);
                        $filePaths[$index] = $folderName . "/" . $fileName;
                    }
                }

                // Update each observation checklist with its file path
                    Rtm::updateOrCreate(
                        [
                            'observation_id' => $obs->id,
                            'indicator_id' => $request->indicator_id,
                        ],
                        [
                            'doc_path_rtm' => $filePaths,
                        ]
                    );

                return redirect()->route('my_audit.edit_rtm', $data->id)->with('msg', 'File Successfully Uploaded');
            } elseif ($request->has('save_link')) {
                // Logika untuk tombol save link
                $this->validate($request, [
                    'link_rtm' => 'nullable|max:500000',
                ]);

                Rtm::updateOrCreate(
                    [
                        'observation_id' => $obs->id,
                        'indicator_id' => $request->indicator_id,
                    ],
                    [
                        'link_rtm' => $request->link_rtm,
                    ]
                );

                return redirect()->route('my_audit.edit_rtm', $data->id)->with('msg', 'Link Successfully Saved');
            } elseif ($request->has('save_remark')) {
                $this->validate($request, [
                    'remark_rtm_auditee' => 'required|max:250',
                ]);

                    Rtm::updateOrCreate(
                        [
                            'observation_id' => $obs->id,
                            'indicator_id' => $request->indicator_id,
                        ],
                        [
                            'remark_rtm_auditee' => $request->remark_rtm_auditee,
                        ]
                    );

                // Load related data for the view
                // $auditors = AuditPlanAuditor::where('audit_plan_id', $data->id)->with('auditor')->get();
                // foreach ($auditors as $auditPlanAuditor) {
                //     $auditor = $auditPlanAuditor->auditor;
                //     if ($auditor && $auditor->email) {
                //         Mail::to($auditor->email)->send(new auditeeUploadDoc($data));
                //     }
                // }

                return redirect()->route('my_audit.edit_rtm', $data->id)->with('msg', 'Remark Successfully Saved');
            }
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
        $hodLPM = Setting::find('HODLPM');
        $hodBPMI = Setting::find('HODBPMI');
        return view('my_audit.edit_rtm',
        compact('standardCategories', 'standardCriterias', 'rtm',
        'auditor', 'data', 'category', 'criteria', 'observations', 'obs_c', 'hodLPM', 'hodBPMI'));
    }

    public function deleteFileRTM($id)
    {
        $checklist = Rtm::findOrFail($id);

        // Hapus file fisik jika ada
        if ($checklist->doc_path_rtm && File::exists(public_path($checklist->doc_path_rtm))) {
            File::delete(public_path($checklist->doc_path_rtm));
        }

        // Hapus file path dari database
        $checklist->doc_path_rtm = null;
        $checklist->save();

        return redirect()->back()->with('msg', 'File RTM successfully deleted');
    }

    public function deleteLinkRTM($id)
    {
        $checklist = Rtm::findOrFail($id);

        // Hapus link dari database jika ada
        if ($checklist->link_rtm) {
            $checklist->link_rtm = null;
            $checklist->save();
        }

        return redirect()->back()->with('msg', 'Link RTM successfully deleted');
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
            ->where('auditee_id', Auth::user()->id)
            ->orderBy("id", "desc");
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
