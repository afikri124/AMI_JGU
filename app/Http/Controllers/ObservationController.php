<?php

namespace App\Http\Controllers;

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
                'remark' => ['required'],
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
                'remark' => $request->remark,
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

        // Fetch lecturers and auditors
        $lecture = User::whereHas('roles', function ($query) {
            $query->where('name', 'lecture');
        })->orderBy('name')->get();

        $auditor = User::whereHas('roles', function ($query) {
            $query->where('name', 'auditor');
        })->orderBy('name')->get();

        $data = AuditPlan::findOrFail($id);

        return view("observations.make", compact("sub_indicator","data", "lecture", "auditor", "locations", "departments", "category", "criterias","audit_plan"));
    }


    public function show($id)
    {
        $data = AuditPlan::findOrFail($id);
        $data->doc_path;
        $data->link;
        return view('observations.show', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'remark'    => '',
        ]);

        $data = AuditPlan::findOrFail($id);
        $data->update([
            'remark' => $request->remark,
            'audit_status_id' => '3',
        ]);
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
