<?php

namespace App\Http\Controllers;

use App\Mail\CommentDocs;
use App\Mail\sendEmail;
use App\Models\AuditPlan;
use App\Models\Department;
use App\Models\Indicator;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\Observation;
use App\Models\StandardCategory;
use App\Models\StandardCriteria;
use App\Models\SubIndicator;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class ObservationController extends Controller
{
    public function index(Request $request)
    {
        $data = AuditPlan::all();
        $category = StandardCategory::orderBy('description')->get();
        $lecture = User::with(['roles' => function ($query) {
            $query->select('id', 'name');
        }])
            ->whereHas('roles', function ($q) use ($request) {
                $q->where('name', 'lecture');
            })
            ->orderBy('name')->get();
        return view('observations.index', compact('data', 'lecture', 'category'));
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
                'remark_ass' => ['required'],
                'doc_path' => ['required'],
                'link' => ['required'],
                'class_type' => ['required'],
                'total_students' => ['required'],
                'title_ass' => ['required'],
            ]);

            $data = Observation::create([
                'audit_plan_id' => $request->audit_plan_id,
                'auditor_id' => $request->auditor_id,
                'location_id' => $request->location_id,
                'department_id' => $request->department_id,
                'audit_status_id' => '4',
                'standard_categories_id' => $request->standard_categories_id,
                'standard_criterias_id' => $request->standard_criterias_id,
                'remark_ass' => $request->remark_ass,
                'doc_path' => $request->doc_path,
                'link' => $request->link,
                'class_type' => $request->class_type,
                'total_students' => $request->total_students,
                'title_ass' => $request->title_ass,
            ]);

            if ($data) {
                return redirect()->route('observations.index')->with('msg', 'Data Auditee (' . $request->lecture_id . ') pada tanggal ' . $request->date . ' BERHASIL ditambahkan!!');
            }
        }

        $audit_plan = AuditPlan::with('auditStatus')->get();
        $locations = Location::orderBy('title')->get();
        $departments = Department::orderBy('name')->get();
        $category = StandardCategory::orderBy('description')->get();
        $criterias = StandardCriteria::orderBy('title')->get();
        $sub_indicator = SubIndicator::all();


        $data = AuditPlan::findOrFail($id);

        return view("observations.make", compact("sub_indicator", "data", "locations", "departments", "category", "criterias", "audit_plan"));
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

    if ($data) {
        // Cari pengguna dan departemen berdasarkan ID yang ada dalam request
        $lecture = User::find($request->lecture_id);
        $department = Department::find($request->department_id);

        if ($lecture) {
            // Data untuk email
            $emailData = [
                'lecture_id'    => $lecture->name,
                'remark_docs'   => $request->remark_docs,
                'date_start'    => $request->date_start,
                'date_end'      => $request->date_end,
                'department_id' => $department ? $department->name : null,
            ];

            // Kirim email ke pengguna yang ditemukan
            Mail::to($lecture->email)->send(new CommentDocs($emailData));

            // Redirect dengan pesan sukses
            return redirect()->route('observations.index')->with('msg', 'Document telah di Review, Siap untuk Audit Lapangan');
        } else {
            // Redirect dengan pesan error jika pengguna tidak ditemukan
            return redirect()->route('observations.index')->with('msg', 'Pengguna tidak ditemukan');
        }
    } else {
        // Redirect dengan pesan error jika data tidak berhasil diupdate
        return redirect()->route('observations.index')->with('msg', 'Data gagal diupdate');
    }
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
            'auditor' => function ($query) {
                $query->select('id', 'name');
            },
            'category' => function ($query) {
                $query->select('id', 'description');
            },
        ])
            ->leftJoin('locations', 'locations.id', '=', 'location_id')
            ->select(
                'audit_plans.*',
                'locations.title as location'
            )->orderBy("id");
        return DataTables::of($data)
            ->filter(function ($instance) use ($request) {
                //jika pengguna memfilter berdasarkan roles
                if (!empty($request->get('select_lecture'))) {
                    $instance->whereHas('lecture', function ($q) use ($request) {
                        $q->where('lecture_id', $request->get('select_lecture'));
                    });
                }
            })->make(true);
    }
}
