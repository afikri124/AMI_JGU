<?php

namespace App\Http\Controllers;

use App\Models\AuditPlan;
use App\Models\AuditStatus;
use App\Models\Department;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;
use App\Models\Location;

class AuditPlanController extends Controller{
    public function index(Request $request){
        if ($request->isMethod('POST')) {
            $this->validate($request, [
            'lecture_id'    => ['required'],
            'date'    => ['required'],
            'location'    => ['required'],
            'department_id'   => ['required'],
            'auditor_id'    => ['required'],
            'doc_path'    => ['required'],
            'link'    => ['required'],
        ]);
        $data = AuditPlan::create([
            'lecture_id'=> $request->lecture_id,
            'date'=> $request->date,
            'audit_status_id'=> '1',
            'location'=> $request->location,
            'department_id'=> $request->department_id,
            'auditor_id'=> $request->auditor_id,
            'doc_path'=> $request->doc_path,
            'link'=> $request->link,
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

    public function edit($id){
        $data = AuditPlan::findOrFail($id);
        $auditStatus = AuditStatus::all();
        $locations = Location::all();
        $users = User::with(['roles' => function ($query) {
            $query->select( 'id','name' );
        }])->where('name',"!=",'admin')->orderBy('name')->get();
        $departments = Department::all();
        return view('audit_plan.edit_audit', compact('data', 'auditStatus', 'locations', 'users', 'departments'));
    }

        public function update(Request $request, $id){
        $request->validate([
            'lecture_id'    => 'required',
            'date'    => 'required',
            // 'audit_plan_status_id' => 'required',
            'location'    => 'required',
            'department_id'   => 'required',
            'auditor_id'    => 'required',
            'doc_path'    => 'required',
            'link'    => 'required',
        ]);

        $data = AuditPlan::findOrFail($id);
        $data->update([
            'lecture_id'=> $request->lecture_id,
            'date'=> $request->date,
            'audit_status_id'=> 'Pending',
            'location'=> $request->location,
            'department_id'=> $request->department_id,
            'auditor_id'=> $request->auditor_id,
            'doc_path'=> $request->doc_path,
            'link'=> $request->link,
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
            }])->with(['auditStatus' => function ($query) {
                $query->select('id','title','color');
            }])->with(['department' => function ($query) {
                $query->select('id','name');
            }])->with(['auditor' => function ($query) {
                $query->select('id','name');
            }])->select('*')->orderBy("id");
            return DataTables::of($data)
                    ->filter(function ($instance) use ($request) {
                        if (!empty($request->get('auditor_id'))) {
                            $instance->where("auditor_id", $request->get('auditor_id'));
                        }
                        if (!empty($request->get('search'))) {
                            $search = $request->get('search');
                            $instance->where('auditor_id', 'LIKE', "%$search%");
                        }
                    })->make(true);
    }

//Json
    public function getData(){
        $data = AuditPlan::with('users')->with('auditStatus')->with('locations')->get()->map(function ($data) {
            return [
                'user_id' => $data->user_id,
                'date' => $data->date,
                'audit_plan_status_id' => 'Pending',
                'location' => $data->location,
                'department_id' => $data->department_id,
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