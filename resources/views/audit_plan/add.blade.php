@extends('layouts.master')
@section('title', 'Create Audit Plan')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endsection

@section('style')
<style>
    .input-validation-error~.select2 .select2-selection {
        border: 1px solid red;
    }
    .container, .container-fluid, .container-sm, .container-md, .container-lg, .container-xl, .container-xxl {
    padding-right: 0.5em;
    padding-left: 0.5em;
}
</style>
@endsection

@section('breadcrumb-title')
<!-- <h3>User Profile</h3> -->
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <form class="card" method="POST" action="">
            @csrf
            <div class="card-header">
                <h3 class="card-header"><b>Create Audit Plan</b></h3>
                <hr class="my-0">
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label class="form-label" for="basicDate"><b>Date Start</b><i class="text-danger">*</i></label>
                            <div class="input-group input-group-merge has-validation">
                                <input type="datetime-local" class="form-control @error('date_start') is-invalid @enderror" name="date_start" placeholder="YYYY-MM-DD HH:MM" id="flatpickr-datetime" value="{{ old('date_start') }}">
                                @error('date_start')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label class="form-label" for="basicDate"><b>Date End</b><i class="text-danger">*</i></label>
                            <div class="input-group input-group-merge has-validation">
                                <input type="datetime-local" class="form-control @error('date_end') is-invalid @enderror" name="date_end" placeholder="YYYY-MM-DD HH:MM" id="flatpickr-datetime" value="{{ old('date_end') }}">
                                @error('date_end')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <p></p>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="auditee_id" class="form-label"><b>Auditee</b><i class="text-danger">*</i></label>
                            <select name="auditee_id" id="auditee_id" class="form-select select2" value="{{ old('auditee_id') }}" required>
                                <option value="">Select Auditee</option>
                                @foreach($auditee as $role)
                                <option value="{{$role->id}}" {{ (in_array($role->id, old('auditee') ?? []) ? "selected": "") }}>
                                    {{$role->name}} (
                                    @foreach ($role->roles as $x)
                                    {{ $x->name}}
                                    @endforeach
                                    )
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="auditor_id" class="form-label"><b>Auditor</b><i class="text-danger">*</i></label>
                            <select name="auditor_id[]" id="auditor_id" class="form-select select2"  multiple required>
                                <option value="">Select Auditor</option>
                                @foreach($auditor as $role)
                                <option value="{{$role->id}}" {{ (in_array($role->id, old('auditor') ?? []) ? "selected": "") }}>
                                    {{$role->name}} (
                                    @foreach ($role->roles as $x)
                                    {{ $x->name}}
                                    @endforeach
                                    )
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <p></p>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="location_id" class="form-label"><b>Location</b></label>
                            <select name="location_id" id="location_id" class="form-select select2" required>
                                <option value="">Select Location</option>
                                @foreach($locations as $d)
                                <option value="{{$d->id}}" {{ (in_array($d->id, old('locations') ?? []) ? "selected": "") }}>
                                    {{$d->title}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="department_id" class="form-label"><b>Department</b><i class="text-danger">*</i></label>
                            <select name="department_id" id="department_id" class="form-select select2" required>
                                <option value="">Select Department</option>
                                @foreach($departments as $d)
                                <option value="{{$d->id}}" {{ (in_array($d->id, old('departments') ?? []) ? "selected": "") }}>
                                    {{$d->name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <p></p>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="periode" class="form-label"><b>Periode</b><i class="text-danger">*</i></label>
                            <select id="periode" name="periode" class="form-select select2" value="{{ old('periode') }}" required>
                            <option value="">Select Periode</option>
                            <?php
                            $startYear = 2019;
                            $endYear = $startYear + 100;
                            for ($year = $startYear; $year <= $endYear; $year++) {
                                $nextYear = $year + 1;
                                echo "<option value='$year/$nextYear'>$year/$nextYear</option>";
                            }
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="type_audit" class="form-label"><b>Type Audit</b><i class="text-danger">*</i></label>
                            <select name="type_audit" id="type_audit" class="form-select select2" required>
                                <option value="">Select Type Audit</option>
                                <option value="reguler">Reguler</option>
                                <option value="permintaan">Permintaan</option>
                            </select>
                        </div>
                    </div>
                    <p></p>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="link" class="form-label"><b>Link Document</b><i class="text-danger">*</i></label>
                            <input type="text" class="form-control" id="link" name="link" placeholder="Input Link Document" value="{{ old('link') }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <button class="btn btn-primary" type="submit">Create</button>
                <a href="{{ url()->previous() }}">
                    <span class="btn btn-secondary">Back</span>
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select an option",
            allowClear: true
        });
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#auditor_id').select2({
            placeholder: "  Select Auditor",
            allowClear: true
        });
        $('#location_id').select2({
            placeholder: "  Select Location",
            allowClear: true
        });
        $('#department_id').select2({
            placeholder: "  Select Department",
            allowClear: true
        });
        $('#auditee_id').select2({
            placeholder: "  Select Auditee",
            allowClear: true
        });
        $('#periode').select2({
            placeholder: "  Select Periode",
            allowClear: true
        });
        $('#type_audit').select2({
            placeholder: "  Select Type Audit",
            allowClear: true
        });
    });
</script>
@endsection
