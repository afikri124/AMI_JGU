<?php

namespace App\Http\Controllers;

use App\Models\AuditPlanStatus;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AuditPlanStatusController extends Controller{
    //
    public function index(Request $request){
        if ($request->isMethod('POST')){ $this->validate($request, [
            'name'    => ['required'],
            'title'    => ['required'],
            'remark_by_lpm'    => ['required'],
            'remark_by_approver'    => ['required'],
        ]);
        $new = AuditPlanStatus::create([
            'name'=> $request->name,
            'title'=> $request->title,
            'remark_by_lpm'=> $request->remark_by_lpm,
            'remark_by_approver'=> $request->remark_by_approver,
        ]);
        if($new){
            return redirect()->route('audit_status.index');
        }
    }
        $data = AuditPlanStatus::all();
        return view("audit_status.index",compact("data"));
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
                'name' => $audit_status->name,
                'title' => $audit_status->title,
                'remark_by_lpm' => $audit_status->remark_by_lpm,
                'remark_by_approver' => $audit_status->remark_by_approver,
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
