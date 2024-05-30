<?php

namespace App\Http\Controllers;

use App\Models\AuditPlan;
use App\Models\AuditPlanStatus;
use App\Models\Department;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;
use App\Models\Location;

class AuditPlanController extends Controller{
    public function index(Request $request){
        if ($request->isMethod('POST')) { 
            $this->validate($request, [
            'date'    => ['required'],
            'location_id'    => ['required'],
            'lecture_id'    => ['required'],
            'auditor_id'    => ['required'],
            'department_id'   => ['required'],
        ]);
        $data = AuditPlan::create([
            'date'=> $request->date,
            'audit_plan_status_id'=> "Pending", //status pending
            'location_id'=> $request->location_id,
            'lecture_id'=> $request->lecture_id,
            'auditor_id'=> $request->auditor_id,
            'department_id'=> $request->department_id,
        ]);
        if($data){
            return redirect()->route('audit_plan.index')->with('message','Data Auditee ('.$request->lecture_id.') pada tanggal '.$request->date.' BERHASIL ditambahkan!!');
            }
        }
            $audit_plan =AuditPlan::with('auditPlanStatus')->get();   
            $locations = Location::orderBy('title')->get();
            $departments = Department::orderBy('title')->get();
            $users = User::with(['roles' => function ($query) {
                $query->select( 'id','name' );
            }])->where('name',"!=",'admin')->orderBy('name')->get();
            // dd($users);
            $data = AuditPlan::all();
            return view("audit_plan.index", compact("users", "locations", "departments", "audit_plan"));
       }

    public function edit($id){
        $data = AuditPlan::all('*');
        $auditstatus = AuditPlanStatus::all();
        $locations = Location::all();
        $users = User::all();
        $departments = Department::all();
        return view('audit_plan.edit_audit', compact('data', 'auditstatus', 'locations', 'users', 'departments'));
    }

        public function update(Request $request, $id){
        $request->validate([
            'date'    => 'required',
            // 'audit_plan_status_id' => 'required',
            'location_id'    => 'required',
            'lecture_id'    => 'required',
            'auditor_id'    => 'required',
            'department_id'   => 'required',
        ]);

        $data = AuditPlan::findOrFail($id);
        $data->update([
            'date'=> $request->date,
            'audit_plan_status_id'=> 'Pending',
            'location_id'=> $request->location_id,
            'lecture_id'=> $request->lecture_id,
            'auditor_id'=> $request->auditor_id,
            'department_id'=> $request->department_id,
        ]);
        return redirect()->route('audit_plan.index')->with('Success', 'Audit Plan berhasil diperbarui.');
    }

    public function delete(Request $request){
        $data = AuditPlan::find($request->id);
        if($data){
            $data->delete();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil dihapus!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal dihapus!'
            ]);
        }
    }
    public function data(Request $request){
        $data = AuditPlan::
        with(['lecture' => function ($query) {
                $query->select('id','name');
            }])
            ->with(['auditor' => function ($query) {
                $query->select('id', 'name');
            }])->
        select('*')->orderBy("id");
            return DataTables::of($data)
                    ->filter(function ($instance) use ($request) {
                        if (!empty($request->get('user_id'))) {
                            $instance->where("user_id", $request->get('user_id'));
                        }
                        if (!empty($request->get('search'))) {
                            $search = $request->get('search');
                            $instance->where('user_id', 'LIKE', "%$search%");
                        }
                    })->make(true);
    }

//Json
    public function getData(){
        $data = AuditPlan::with('users')->with('audit_plan_status')->with('locations')->get()->map(function ($data) {
            return [
                'date' => $data->date,
                'audit_plan_status_id' => $data->audit_plan_status_id->user_id,
                'location_id' => $data->location_id,
                'lecture_id' => $data->lecture_id,
                'auditor_id' => $data->auditor_id,
                'departement_id' => $data->departement_id,
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
