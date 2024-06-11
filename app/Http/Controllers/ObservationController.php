<?php

namespace App\Http\Controllers;

use App\Models\AuditPlan;
use App\Models\AuditStatus;
use App\Models\Department;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\Observation;
use App\Models\User;

class ObservationController extends Controller{
    public function index(Request $request){
        if ($request->isMethod('POST')) {
            $this->validate($request, [
            'audit_plan_id'    => ['required'],
            'auditor_id'    => ['required'],
            'location_id'    => ['required'],
            'department_id'   => ['required'],
            'standar_id'    => ['required'],
            'attendance'    => ['required'],
            'remark'    => ['required'],
            'doc_path'    => ['required'],
            'subject_course'   => ['required'],
            'topic'    => ['required'],
            'class_type'    => ['required'],
            'total_students'    => ['required'],
            ]);
        $data = Observation::create([
            'audit_plan_id'=> $request->audit_plan_id,
            'auditor_id'=> $request->auditor_id,
            'audit_status_id'=> '1',
            'location_id'=> $request->location_id,
            'department_id'=> $request->department_id,
            'standar_id'=> $request->standar_id,
        ]);
        if($data){
            return redirect()->route('audit_plan.index')->with('message','Data Auditee ('.$request->lecture_id.') pada tanggal '.$request->date.' BERHASIL ditambahkan!!');
            }
        }
            $audit_plan =AuditPlan::with('auditStatus')->get();
            $locations = Location::orderBy('title')->get();
            $departments = Department::orderBy('name')->get();
            $status = AuditStatus::get();
            $users = User::with(['roles' => function ($query) {
                $query->select( 'id','name' );
            }])->where('name',"!=",'admin')->orderBy('name')->get();
            // dd($users);
            $data = AuditPlan::all();
            return view("audit_plan.index", compact("users", "locations", "departments", "audit_plan"));
       }
}
