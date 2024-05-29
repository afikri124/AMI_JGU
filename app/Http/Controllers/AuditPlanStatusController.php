<?php

namespace App\Http\Controllers;

use App\Models\AuditPlan;
use App\Models\AuditPlanStatus;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AuditPlanStatusController extends Controller{
    //
    public function index(Request $request){
        if ($request->isMethod('POST')){ $this->validate($request, [
            'user_id'    => ['required'],
            'date'    => ['required'],
            'location_id'    => ['required'],
            'file_path'    => ['required'],
        ]);
        $new = AuditPlanStatus::create([
            'user_id'=> $request->user_id,
            'audit_plan_status_id'=> "Pending",
            'date'=> $request->date,
            'location_id'=> $request->location_id,
            'file_path'=> $request->file_path,
        ]);
        if($new){
            return redirect()->route('audit_status.index');
        }
    }
        $data = AuditPlanStatus::all();
        $audit_plan = AuditPlan::all('*');
        $locations = Location::all();
        $users = User::all();
        return view("audit_status.index",compact("data", "audit_plan", "locations"));
    }

    public function edit($id){
        $data = AuditPlan::findOrFail($id);
        $auditstatus = AuditPlanStatus::all();
        $locations = Location::all();
        $users = User::all();
        return view('audit_status.edit_status', compact('data', 'auditstatus', 'locations', 'users'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'user_id'    => 'required',
            'date'    => 'required',
            'location_id'    => 'required',
        ]);

        $data = AuditPlanStatus::findOrFail($id);
        $data->update([
            'user_id'=> $request->user_id,
            'date'=> $request->date,
            'audit_plan_status_id'=> "Approver",
            'location_id'=> $request->location_id,
        ]);
        return redirect()->route('audit_status.index')->with('Success', 'Audit Plan berhasil diperbarui.');
    }

    public function data(Request $request){
        $data = AuditPlanStatus::select('*')->orderBy("id");
            return DataTables::of($data)
                    ->filter(function ($instance) use ($request) {
                        if (!empty($request->get('search'))) {
                            $search = $request->get('search');
                            $instance->where('auditor_id', 'LIKE', "%$search%");
                        }
                    })
                ->make(true);
    }

    public function getData(){
        $data = AuditPlanStatus::get()->map(function ($audit_status) {
            return [
                'user_id' => $audit_status->user_id,
                'date' => $audit_status->date,
                'location_id' => $audit_status->location_id,
                'created_at' => $audit_status->created_at,
                'updated_at' => $audit_status->updated_at,
            ];
        });

        return response()->json($data);
    }

    public function datatables(){
        $audit_status = AuditPlanStatus::select('*');
        return DataTables::of($audit_status)->make(true);
    }
}
