<?php

namespace App\Http\Controllers;

use App\Models\AuditPlan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AuditPlanController extends Controller{

    //
    public function index(Request $request){
        if ($request->isMethod('POST')) { $this->validate($request, [
            'date'    => ['required'],
            'audit_plan_status_id' => ['required'],
            'auditee_id'   => ['required'],
            'location_id'    => ['required'],
            'auditor_id'    => ['required'],
            'departement_id'   => ['required'],
        ]);
        $new = AuditPlan::create([
            'date'=> $request->date,
            'audit_plan_status_id'=> $request->audit_plan_status_id,
            'auditee_id'=> $request->auditee_id,
            'location_id'=> $request->location_id,
            'auditor_id'=> $request->auditor_id,
            'departement_id'=> $request->departement_id,
        ]);
        if($new){
            return redirect()->route('audit_plan.index')->with('message','Data Auditee ('.$request->auditee_id.') pada tanggal '.$request->date.' BERHASIL ditambahkan!!');
            }
        }
            $data = AuditPlan::all();
            return view("audit_plan.index",compact("data"));
       }

    public function edit($id){
        $data = AuditPlan::findOrFail($id);
        $fakultas = AuditPlan::all();
        return view('prodi.edit_prodi', compact('data', 'fakultas'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'kode_prodi' => 'required',
            'nama_prodi' => 'required',
            'fakultas_id' => 'required',
        ]);

        $data = AuditPlan::findOrFail($id);
        $data->update([
            'kode_prodi' => $request->kode_prodi,
            'nama_prodi' => $request->nama_prodi,
            'fakultas_id' => $request->fakultas_id,
        ]);

        return redirect()->route('prodi.index')->with('success', 'prodi berhasil diperbarui.');
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
        $data = AuditPlan::select('*')->orderBy("id");
            return DataTables::of($data)
                    ->filter(function ($instance) use ($request) {
                        if (!empty($request->get('select_auditor_id'))) {
                            $instance->where("auditor_id", $request->get('select_auditor_id'));
                        }
                        if (!empty($request->get('search'))) {
                            $search = $request->get('search');
                            $instance->where('auditor_id', 'LIKE', "%$search%");
                        }
                    })->make(true);
    }

//Json
    public function getData(){
        $data = AuditPlan::with('audit_plan_status_id')->get()->map(function ($auditplan) {
            return [
                'date' => $auditplan->date,
                'audit_plan_status_id' => $auditplan->audit_plan_status_id->title,
                'auditee_id' => $auditplan->auditee_id,
                'location_id' => $auditplan->location_id,
                'auditor_id' => $auditplan->auditor_id,
                'departement_id' => $auditplan->departement_id,
                'created_at' => $auditplan->created_at,
                'updated_at' => $auditplan->updated_at,
            ];
        });

        return response()->json($data);
    }

    public function datatables(){
        $audit_plan = AuditPlan::select('*');
        return DataTables::of($audit_plan)->make(true);
    }
}
