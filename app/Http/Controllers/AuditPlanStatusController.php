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
            'file_path'    => [''],
            'link'    => [''],
            'description'    => [''],

        ]);
        $new = AuditPlanStatus::create([
            'file_path'=> $request->file_path,
            'link' => $request->link,
            'description' => $request->description
        ]);
        if($new){
            return redirect()->route('audit_status.index');
        }
    }
        $data = AuditPlan::all();
        $auditstatus = AuditPlanStatus::with('lecture')->get();;
        $locations = Location::all();
        $users = User::all();
        return view("audit_status.index",compact("data", "auditstatus", "locations", "users"));
    }

    public function edit($id){
        $data = AuditPlan::findOrFail($id);
        $auditstatus = AuditPlan::all();
        $locations = Location::all();
        $users = User::all();
        return view('audit_status.edit_status', compact('data', 'auditstatus', 'locations', 'users'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'file_path' => '',
            'link'  => '',
            'description'  => '',
        ]);

        $data = AuditPlan::findOrFail($id);
        $data->update([
            'file_path'=> $request->file_path,
            'link'=> $request->link,
            'description'=> $request->description,
        ]);
        return redirect()->route('audit_status.index')->with('Success', 'Audit Plan berhasil diperbarui.');
    }

    public function data(Request $request){
        $data = AuditPlan::
        with(['lecture' => function ($query) {
                $query->select('id','name');
            }])
            ->select('*')->orderBy("id");
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
                'lecture_id' => $audit_status->lecture_id,
                'auditor_id ' => $audit_status->auditor_id ,
                'date' => $audit_status->date,
                'location_id' => $audit_status->location_id,
                'file_path' => $audit_status->file_path,
                'link' => $audit_status->link,
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
