<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ObservationController extends Controller{
    public function index(Request $request){
        if ($request->isMethod('POST')) {
            $this->validate($request, [
            'lecture_id'    => ['required'],
            'date'    => ['required'],
            'location'    => ['required'],
            'department_id'   => ['required'],
            'auditor_id'    => ['required'],
        ]);
        $data = Observation::create([
            'lecture_id'=> $request->lecture_id,
            'date'=> $request->date,
            'audit_status_id'=> '1',
            'location'=> $request->location,
            'department_id'=> $request->department_id,
            'auditor_id'=> $request->auditor_id,
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
