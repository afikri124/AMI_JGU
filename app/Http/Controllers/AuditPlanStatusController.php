<?php

namespace App\Http\Controllers;

use App\Models\AuditPlanStatus;
use Illuminate\Http\Request;

class AuditPlanStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auditPlanStatuses = AuditPlanStatus::all();
        return view('audit_status.index', compact('auditPlanStatuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'remark_by_lpm' => 'nullable|string',
            'remark_by_approver' => 'nullable|string',
        ]);

        $auditPlanStatus = AuditPlanStatus::create($validatedData);

        return response()->json($auditPlanStatus, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AuditPlanStatus  $auditPlanStatus
     * @return \Illuminate\Http\Response
     */
    public function show(AuditPlanStatus $auditPlanStatus)
    {
        return response()->json($auditPlanStatus);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AuditPlanStatus  $auditPlanStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AuditPlanStatus $auditPlanStatus)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'remark_by_lpm' => 'nullable|string',
            'remark_by_approver' => 'nullable|string',
        ]);

        $auditPlanStatus->update($validatedData);

        return response()->json($auditPlanStatus);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AuditPlanStatus  $auditPlanStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(AuditPlanStatus $auditPlanStatus)
    {
        $auditPlanStatus->delete();

        return response()->json(null, 204);
    }
}
