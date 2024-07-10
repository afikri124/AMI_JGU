<?php

namespace App\Http\Controllers;

use App\Mail\CommentDocs;
use App\Mail\sendEmail;
use App\Models\AuditPlan;
use App\Models\AuditPlanAuditor;
use App\Models\AuditPlanCriteria;
use App\Models\CategoriesAmi;
use App\Models\CriteriasAmi;
use App\Models\Department;
use App\Models\Indicator;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\Observation;
use App\Models\ReviewDocs;
use App\Models\StandardCategory;
use App\Models\StandardCriteria;
use App\Models\SubIndicator;
use App\Models\User;
use App\Models\UserStandard;
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

    public function make(Request $request, $id)
    {
        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'audit_plan_id' => ['required'],
                'auditor_id' => ['string'],
            ]);

            $data = Observation::create([
                'audit_plan_id' => $request->audit_plan_id,
                'auditor_id' => $request->auditor_id,
                'location_id' => $request->location_id,
            ]);

            if ($data) {
                return redirect()->route('observations.index')->with('msg', 'Data Auditee (' . $request->auditee_id . ') pada tanggal ' . $request->date . ' BERHASIL ditambahkan!!');
            }
        }

        $audit_plan = AuditPlan::with('auditStatus')->get();
        $locations = Location::orderBy('title')->get();
        $department = Department::orderBy('name')->get();
        $category = StandardCategory::orderBy('description')->get();
        $criteria = StandardCriteria::orderBy('title')->get();
        $auditors = AuditPlanAuditor::where('audit_plan_id', $id)->get();
        $data = AuditPlan::findOrFail($id);
        $criterias = AuditPlanCriteria::where('audit_plan_id', $id)->get();
        $categories = AuditPlanCriteria::where('audit_plan_id', $id)->get();
        // Ambil data StandardCriteria ID dari CriteriasAmi
        $standardCriteriasIds = $criterias->pluck('standard_criteria_id');
        // Ambil indicator berdasarkan standard_criteria_id
        $indicators = Indicator::whereIn('standard_criteria_id', $standardCriteriasIds)->get();
        // Ambil sub_indicator berdasarkan indicator_id dari indicators yang didapat
        $subIndicators = SubIndicator::whereIn('indicator_id', $indicators->pluck('id'))->get();
        $reviewDocs = ReviewDocs::whereIn('indicator_id', $indicators->pluck('id'))->get();
        foreach ($subIndicators as $sub) {
            $reviewDocs = ReviewDocs::where('indicator_id', $sub->indicator_id)
                ->where('standard_criteria_id', $sub->standard_criteria_id)
                ->get();

            $sub->reviewDocs = $reviewDocs; // Attach review documents to each sub indicator
        }

    return view('observations.make', compact('criterias', 'categories', 'indicators', 'subIndicators', 'auditors','reviewDocs', "data", "locations", "department", "category", "criteria", "audit_plan"));
    }

    public function edit($id)
    {
        $data = AuditPlan::findOrFail($id);
        $data->doc_path;
        $data->link;
        return view('observations.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'remark_docs'    => '',
        ]);

        $data = AuditPlan::findOrFail($id);
        $data->update([
            'remark_docs' => $request->remark_docs,
            'audit_status_id' => '3',
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
        return redirect()->route('observations.index')->with('msg', 'Document telah di Review, Siap untuk Audit Lapangan');
    }


    public function data(Request $request)
    {
        $data = AuditPlan::with([
            'auditee' => function ($query) {
                $query->select('id', 'name');
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
                            ->orWhere('date_end', 'LIKE', "%$search%");
                    });
                }
            })->make(true);
    }
}
