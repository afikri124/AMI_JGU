@extends('layouts.master')
@section('breadcrumb-items')
<span class="text-muted fw-light">Audit Plan /</span>
@endsection
@section('title', 'Add')

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
</style>
@endsection

@section('content')
<div class="card">
    <form class="" method="POST" action="">
        @csrf
        <div class="card-header">
            <h4><b>Add Audit Plan</b></h4>
            <hr class="my-0">
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-3">
                    <div class="form-group">
                        <label for="type_audit" class="form-label"><b>Type Audit</b><i class="text-danger">*</i></label>
                        <select name="type_audit" id="type_audit"
                            class="form-select @error('type_audit') is-invalid @enderror select2">
                            <option {{ (old('type_audit') == "" ? "Selected" : "") }} value="">Select Type Audit
                            </option>
                            <option {{ (old('type_audit') == "Reguler" ? "Selected" : "") }} value="Reguler">Reguler
                            </option>
                            <option {{ (old('type_audit') == "Permintaan" ? "Selected" : "") }} value="Permintaan">
                                Permintaan</option>
                        </select>
                        @error('type_audit')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 mb-3">
                    <div class="form-group">
                        <label for="periode" class="form-label"><b>Periode</b><i class="text-danger">*</i></label>
                        <select id="periode" name="periode"
                            class="form-select @error('periode') is-invalid @enderror select2">
                            @php
                            $startYear = $prd;
                            $endYear = now()->year + 5;
                            for ($year = $startYear; $year <= $endYear; $year++) { $nextYear=$year + 1;
                                $selected=($year==now()->year ? "selected" : "");
                                echo "<option $selected value='$year/$nextYear'>$year/$nextYear</option>";
                                }
                                @endphp
                        </select>
                        @error('periode')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 mb-3">
                    <div class="form-group">
                        <label class="form-label" for="basicDate"><b>Date Start</b><i class="text-danger">*</i></label>
                        <div class="input-group input-group-merge has-validation">
                            <input type="datetime-local" class="form-control @error('date_start') is-invalid @enderror"
                                name="date_start" placeholder="YYYY-MM-DD HH:MM" id="flatpickr-datetime"
                                value="{{ old('date_start') }}">
                            @error('date_start')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 mb-3">
                    <div class="form-group">
                        <label class="form-label" for="basicDate"><b>date End</b><i class="text-danger">*</i></label>
                        <div class="input-group input-group-merge has-validation">
                            <input type="datetime-local" class="form-control @error('date_end') is-invalid @enderror"
                                name="date_end" placeholder="YYYY-MM-DD HH:MM" id="flatpickr-datetime"
                                value="{{ old('date_end') }}">
                            @error('date_end')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 mb-3">
                    <div class="form-group">
                        <label for="department_id" class="form-label"><b>Department</b>
                            <i class="text-danger">*</i></label>
                        <select name="department" id="department_id"
                            class="form-select @error('department') is-invalid @enderror select2"
                            value="{{ old('department') }}">
                            <option value="">Select Department</option>
                            @foreach($departments as $d)
                            <option value="{{$d->id}}" {{ ($d->id == old('department') ? "selected": "") }}>
                                {{$d->name}}
                            </option>
                            @endforeach
                        </select>
                        @error('department')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 mb-3">
                    <div class="form-group">
                        <label for="auditee_id" class="form-label"><b>Auditee</b><i class="text-danger">*</i></label>
                        <select name="auditee" id="auditee_id"
                            class="form-select @error('auditee') is-invalid @enderror select2"
                            value="{{ old('auditee') }}">
                            <option value="">Select Auditee</option>
                            @foreach($auditee as $x)
                            <option value="{{$x->id}}" {{ ($x->id == old('auditee') ? "selected": "") }}>
                                {{$x->name}}
                            </option>
                            @endforeach
                        </select>
                        @error('auditee')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 mb-3">
                    <div class="form-group">
                        <label for="head_major" class="form-label"><b>Head Of Study Program</b>
                            <i class="text-danger">*</i></label>
                        <input type="text" id="head_major"
                            class="form-control @error('head_major') is-invalid @enderror" name="head_major"
                            placeholder="Example: Ariep Jaenul, S.pd., M.Sc.Eng" value="{{ old('head_major') }}">
                        @error('head_major')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 mb-3">
                    <div class="form-group">
                        <label for="upm_major" class="form-label"><b>UPM Of Study Program</b><i
                                class="text-danger">*</i></label>
                        <input type="text" id="upm_major" class="form-control @error('upm_major') is-invalid @enderror"
                            name="upm_major" placeholder="Example: Ariep Jaenul, S.pd., M.Sc.Eng"
                            value="{{ old('upm_major') }}">
                        @error('upm_major')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 mb-3">
                    <div class="form-group">
                        <label for="auditor_1_id" class="form-label"><b>Auditor 1</b><i
                                class="text-danger">*</i></label>
                        <select name="auditor_1" id="auditor_1_id"
                            class="form-select @error('auditor_1') is-invalid @enderror select2">
                            <option value="">Select Auditor 1</option>
                            @foreach($auditor as $x)
                            <option value="{{$x->id}}" {{ ($x->id == old('auditor_1') ? "selected": "") }}>
                                {{$x->name}}
                            </option>
                            @endforeach
                        </select>
                        @error('auditor_1')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 mb-3">
                    <div class="form-group">
                        <label for="auditor_2_id" class="form-label"><b>Auditor 2</b><i
                                class="text-danger">*</i></label>
                        <select name="auditor_2" id="auditor_2_id"
                            class="form-select @error('auditor_2') is-invalid @enderror select2">
                            <option value="">Select Auditor 2</option>
                            @foreach($auditor as $x)
                            <option value="{{$x->id}}" {{ ($x->id == old('auditor_2') ? "selected": "") }}>
                                {{$x->name}}
                            </option>
                            @endforeach
                        </select>
                        @error('auditor_2')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary me-1" type="submit">Create</button>
                    <a href="{{ url()->previous() }}">
                        <span class="btn btn-outline-secondary">Back</span>
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
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
    $(document).ready(function () {
        $('#auditor_1_id').select2({
            placeholder: "Select Auditor 1",
            allowClear: true
        });

        $('#auditor_2_id').select2({
            placeholder: "Select Auditor 2",
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
