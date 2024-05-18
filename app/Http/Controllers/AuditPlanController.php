<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuditPlan;

class AuditPlanController extends Controller
{
    /**
     * Display a listing of the audit plans.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = AuditPlan::all();
        return view('audit_plan.index', compact('data'));
    }


    public function form(Request $request) // Assuming form returns a view
    {
        // Code to prepare data for the form

        return view('audit_plans.form', [ // Replace with your view name
            // Data to be passed to the view
        ]);
    }

    /**
     * Show the form for creating a new audit plan.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('audit_plan.form');
    }

    /**
     * Store a newly created audit plan in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'audit_plan_status_id' => 'required|integer',
            'auditee_id' => 'required|integer',
            'location_id' => 'required|integer',
            'auditor_id' => 'required|integer',
            'departement_id' => 'required|integer',
        ]);

        $data = AuditPlan::create($validatedData);

        return response()->json($data, 201);
    }

    /**
     * Display the specified audit plan.
     *
     * @param  \App\Models\AuditPlan  $data
     * @return \Illuminate\Http\Response
     */
    public function show(AuditPlan $data)
    {
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified audit plan.
     *
     * @param  \App\Models\AuditPlan  $data
     * @return \Illuminate\Http\Response
     */
    public function edit(AuditPlan $data)
    {
        return view('audit_plan.edit', compact('data'));
    }

    /**
     * Update the specified audit plan in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AuditPlan  $data
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AuditPlan $data)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'audit_plan_status_id' => 'required|integer',
            'auditee_id' => 'required|integer',
            'location_id' => 'required|integer',
            'auditor_id' => 'required|integer',
            'departement_id' => 'required|integer',
        ]);

        $data->update($validatedData);

        return redirect()->route('audit-plan.index');
    }

    /**
     * Remove the specified audit plan from storage.
     *
     * @param  \App\Models\AuditPlan  $data
     * @return \Illuminate\Http\Response
     */
    public function destroy(AuditPlan $data)
    {
        $data->delete();

        return redirect()->route('audit-plan.index');
    }
}
