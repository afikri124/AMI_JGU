@extends('layouts.app')
@section('title', 'From Audit Plan')
@section('content')
    <h1>{{ isset($auditPlan) ? 'Edit' : 'Create' }} Audit Plan</h1>

    <form action="{{ isset($auditPlan) ? route('audit-plans.update', $auditPlan->id) : route('audit-plans.store') }}" method="POST">
        @csrf
        @if(isset($auditPlan))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ isset($auditPlan) ? $auditPlan->date : '' }}" required>
        </div>

        <div class="form-group">
            <label for="audit_plan_status_id">Audit Plan Status ID</label>
            <input type="number" class="form-control" id="audit_plan_status_id" name="audit_plan_status_id" value="{{ isset($auditPlan) ? $auditPlan->audit_plan_status_id : '' }}" required>
        </div>

        <div class="form-group">
            <label for="auditee_id">Auditee ID</label>
            <input type="number" class="form-control" id="auditee_id" name="auditee_id" value="{{ isset($auditPlan) ? $auditPlan->auditee_id : '' }}" required>
        </div>

        <div class="form-group">
            <label for="location_id">Location ID</label>
            <input type="number" class="form-control" id="location_id" name="location_id" value="{{ isset($auditPlan) ? $auditPlan->location_id : '' }}" required>
        </div>

        <div class="form-group">
            <label for="remark_by_lpm">Remark by LPM</label>
            <textarea class="form-control" id="remark_by_lpm" name="remark_by_lpm">{{ isset($auditPlan) ? $auditPlan->remark_by_lpm : '' }}</textarea>
        </div>

        <div class="form-group">
            <label for="remark_by_approver">Remark by Approver</label>
            <textarea class="form-control" id="remark_by_approver" name="remark_by_approver">{{ isset($auditPlan) ? $auditPlan->remark_by_approver : '' }}</textarea>
        </div>

        <div class="form-group">
            <label for="departement_id">Departement ID</label>
            <input type="number" class="form-control" id="departement_id" name="departement_id" value="{{ isset($auditPlan) ? $auditPlan->departement_id : '' }}" required>
        </div>

        <button type="submit" class="btn btn-success">{{ isset($auditPlan) ? 'Update' : 'Create' }}</button>
    </form>
@endsection
