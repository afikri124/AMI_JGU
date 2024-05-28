<?php

namespace App\Http\Controllers;

use App\Models\AuditPlan;
use App\Models\AuditPlanStatus;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AuditPlanStatusController extends Controller{
    //
    public function index(Request $request){
        if ($request->isMethod('POST')){ $this->validate($request, [
            'user_id'    => ['required'],
            'date'    => ['required'],
            'user_id'    => ['required'],
        ]);
        $new = AuditPlanStatus::create([
            'user_id'=> $request->user_id,
            'audit_plan_status_id'=> "Pending",
            'date'=> $request->date,
            'user_id'=> $request->user_id,
        ]);
        if($new){
            return redirect()->route('audit_status.index');
        }
    }
        $data = AuditPlanStatus::all();
        $audit_plan = AuditPlan::all('*');
        return view("audit_status.index",compact("audit_plan", "audit_plan"));
    }

    public function update(Request $request, $id){
        $request->validate([
            'date'    => 'required',
            'audit_plan_status_id' => 'required',
            'location_id'    => 'required',
            'user_id'    => 'required',
            'departement_id'   => 'required',
        ]);

        $data = AuditPlanStatus::findOrFail($id);
        $data->update([
            'date'=> $request->date,
            'audit_plan_status_id'=> "Approver",
            'location_id'=> $request->location_id,
            'user_id'=> $request->user_id,
            'departement_id'=> $request->departement_id,
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
                'user_id' => $audit_status->user_id,
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
