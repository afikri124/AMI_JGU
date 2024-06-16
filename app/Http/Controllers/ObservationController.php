<?php

namespace App\Http\Controllers;

use App\Models\AuditPlan;
use App\Models\Department;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\Observation;
use App\Models\StandardCategory;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class ObservationController extends Controller{
    public function index(Request $request){
        $data = AuditPlan::all();
        $category = StandardCategory::orderBy('description')->get();
        $lecture = User::with(['roles' => function ($query) {
            $query->select( 'id','name' );
        }])
        ->whereHas('roles', function($q) use($request){
            $q->where('name', 'lecture');
        })
        ->orderBy('name')->get();
        return view('observations.index', compact('data', 'lecture', 'category'));
    }

    public function make(Request $request){
        if ($request->isMethod('POST')) {
            $this->validate($request, [
            'audit_plan_id'    => ['required'],
            'auditor_id'    => ['string'],
            'location_id'    => ['required'],
            'department_id'   => ['required'],
            'standard_id'    => ['required'],
            'indicator_id'    => ['required'],
            'standard_criterias_id'    => ['required'],
            'remark'    => ['required'],
            'file_path'    => ['required'],
            'required'   => ['required'],
            'topic'    => ['required'],
            'class_type'    => ['required'],
            'total_students'    => ['required'],
            ]);
        $data = Observation::create([
            'audit_plan_id'=> $request->audit_plan_id,
            'auditor_id'=> $request->auditor_id,
            'location_id'=> $request->location_id,
            'department_id'=> $request->department_id,
            'audit_status_id'   => '3',
            'standard_id'=> $request->standard_id,
            'indicator_id'=> $request->indicator_id,
            'remark'=> $request->remark,
            'file_path'=> $request->file_path,
            'required'=> $request->required,
            'topic'=> $request->topic,
            'class_type'=> $request->class_type,
            'total_students'=> $request->total_students,
        ]);
        if($data){
            return redirect()->route('observations.index')->with('message','Data Auditee ('.$request->lecture_id.') pada tanggal '.$request->date.' BERHASIL ditambahkan!!');
            }
        }
            $audit_plan =AuditPlan::with('auditStatus')->get();
            $locations = Location::orderBy('title')->get();
            $departments = Department::orderBy('name')->get();
            $lecture = User::with(['roles' => function ($query) {
            $query->select( 'id','name' );
            }])
            ->whereHas('roles', function($q) use($request){
                $q->where('name', 'lecture');
            })
            ->orderBy('name')->get();
            // dd($lecture);
            $data = AuditPlan::all();
            return view("observations.make", compact("lecture", "locations", "departments", "audit_plan"));
       }

       public function data(Request $request){
        $data = AuditPlan::
        with([
            'lecture' => function ($query) {
                $query->select('id','name');
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
        ->leftJoin('locations', 'locations.id' , '=', 'location_id')
        ->select('audit_plans.*',
        'locations.title as location'
        )->orderBy("id");
            return DataTables::of($data)
                ->filter(function ($instance) use ($request) {
                    //jika pengguna memfilter berdasarkan roles
                    if (!empty($request->get('select_lecture'))) {
                        $instance->whereHas('lecture', function($q) use($request){
                            $q->where('lecture_id', $request->get('select_lecture'));
                        });
                    }
                    })->make(true);
    }
}
