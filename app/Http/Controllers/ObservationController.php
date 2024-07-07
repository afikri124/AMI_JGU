<?php

namespace App\Http\Controllers;

use App\Mail\CommentDocs;
use App\Mail\sendEmail;
use App\Models\AuditPlan;
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
        $lecture = User::with(['roles' => function ($query) {
            $query->select('id', 'name');
        }])
            ->whereHas('roles', function ($q) use ($request) {
                $q->where('name', 'lecture');
            })
            ->orderBy('name')->get();
        return view('observations.index', compact('data', 'lecture'));
    }

    public function make(Request $request, $id)
    {
        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'audit_plan_id' => ['required'],
                'auditor_id' => ['string'],
                'location_id' => ['required'],
                'department_id' => ['required'],
                'standard_categories_id' => ['required'],
            ]);

            $data = Observation::create([
                'audit_plan_id' => $request->audit_plan_id,
                'auditor_id' => $request->auditor_id,
                'location_id' => $request->location_id,
                'department_id' => $request->department_id,
                'audit_status_id' => '4',
                'standard_categories_id' => $request->standard_categories_id,
                'standard_criterias_id' => $request->standard_criterias_id,
                'type_audit' => $request->type_audit,
                'link' => $request->link,
                'ks' => $request->ks,
                'obs' => $request->obs,
                'kts_minor' => $request->kts_minor,
                'kts_mayor' => $request->kts_mayor,
                'description_remark' => $request->description_remark,
                'success_remark' => $request->success_remark,
                'failed_remark' => $request->failed_remark,
                'recommend_remark' => $request->recommend_remark,
            ]);

            if ($data) {
                return redirect()->route('observations.index')->with('msg', 'Data Auditee (' . $request->lecture_id . ') pada tanggal ' . $request->date . ' BERHASIL ditambahkan!!');
            }
        }

        $audit_plan = AuditPlan::with('auditStatus')->get();
        $locations = Location::orderBy('title')->get();
        $department = Department::orderBy('name')->get();
        $category = StandardCategory::orderBy('description')->get();
        $criteria = StandardCriteria::orderBy('title')->get();
        $auditors = UserStandard::where('audit_plan_id', $id)->get();
        $data = AuditPlan::findOrFail($id);
        $criterias = CriteriasAmi::where('audit_plan_id', $id)->get();
        $categories = CategoriesAmi::where('audit_plan_id', $id)->get();
        // Ambil data StandardCriteria ID dari CriteriasAmi
        $standardCriteriasIds = $criterias->pluck('standard_criterias_id');
        // Ambil indicator berdasarkan standard_criterias_id
        $indicators = Indicator::whereIn('standard_criterias_id', $standardCriteriasIds)->get();
        // Ambil sub_indicator berdasarkan indicator_id dari indicators yang didapat
        $subIndicators = SubIndicator::whereIn('indicator_id', $indicators->pluck('id'))->get();
        $reviewDocs = ReviewDocs::whereIn('indicator_id', $indicators->pluck('id'))->get();
        foreach ($subIndicators as $sub) {
            $reviewDocs = ReviewDocs::where('indicator_id', $sub->indicator_id)
                ->where('standard_criterias_id', $sub->standard_criterias_id)
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
        //     $lecture = User::find($request->lecture_id);
        //     $department = Department::find($request->department_id);

        //     if ($lecture) {
        //         // Data untuk email
        //         $emailData = [
        //             'lecture_id'    => $lecture->name,
        //             'remark_docs'   => $request->remark_docs,
        //             'date_start'    => $request->date_start,
        //             'date_end'      => $request->date_end,
        //             'department_id' => $department ? $department->name : null,
        //         ];

        //         // Kirim email ke pengguna yang ditemukan
        //         Mail::to($lecture->email)->send(new CommentDocs($emailData));

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
            'lecture' => function ($query) {
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
                if (!empty($request->get('select_lecture'))) {
                    $instance->whereHas('lecture', function ($q) use ($request) {
                        $q->where('lecture_id', $request->get('select_lecture'));
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
