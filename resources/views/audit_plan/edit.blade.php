@extends('layouts.master')
@section('title', 'From Audit Plan Edit')
@section('content')
    <h1>{{ isset($auditPlan) ? 'Edit' :  }} Audit Plan</h1>

    <form action="" method="POST">
        @csrf
        @if(isset($auditPlan))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ isset($auditPlan) ? $auditPlan->date : '' }}" required>
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
            <label for="auditor_id">Auditor</label>
            <textarea class="form-control" id="auditor_id" name="auditor_id">{{ isset($auditPlan) ? $auditPlan->auditor_id : '' }}</textarea>
        </div>

        <div class="form-group">
            <label for="departement_id">Departement ID</label>
            <input type="number" class="form-control" id="departement_id" name="departement_id" value="{{ isset($auditPlan) ? $auditPlan->departement_id : '' }}" required>
        </div>

        <button type="submit" class="btn btn-success">{{ isset($auditPlan) ? 'Update' : }}</button>
    </form>
@endsection
