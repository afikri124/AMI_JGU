@extends('layouts.master')
@section('title', 'Add Audit Plan')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endsection

@section('style')
<style>
    .input-validation-error~.select2 .select2-selection {
        border: 1px solid red;
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
                            <label class="form-label"><b>Email</b><i class="text-danger">*</i></label>
                            <input class="form-control @error('email') is-invalid @enderror" type="text" id="email" placeholder="Input email" name="email" value="{{ old('email') }}">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label class="form-label"><b>No Telepon</b><i class="text-danger">*</i></label>
                            <input class="form-control @error('no_phone') is-invalid @enderror" id="no_phone" name="no_phone" type="text" placeholder="Input No Telepon">
                            @error('no_phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <p></p>
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
                            <select name="auditee_id" id="auditee_id" class="form-select" required>
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
                            <select name="auditor_id[]" id="auditor_id" class="form-select select2" multiple required>
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
                            <select name="location_id" id="location_id" class="form-select" required>
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
                            <select name="department_id" id="department_id" class="form-select" required>
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
                            <label for="standard_category_id" class="form-label"><b>Category</b><i class="text-danger">*</i></label>
                            <select name="standard_category_id[]" id="standard_category_id" class="form-select select2" multiple required>
                                @foreach($category as $c)
                                <option value="{{ $c->id }}" {{ in_array($c->id, old('standard_category_id', [])) ? 'selected' : '' }}>
                                    {{ $c->id }} - {{ $c->description }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="standard_criteria_id" class="form-label"><b>Criteria</b><i class="text-danger">*</i></label>
                            <select name="standard_criteria_id[]" id="standard_criteria_id" class="form-select select2" multiple required>
                                @foreach($criterias as $c)
                                <option value="{{ $c->id }}" {{ in_array($c->id, old('standard_criteria_id', [])) ? 'selected' : '' }}>
                                    {{ $c->id }} - {{ $c->title }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <p></p>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="periode" class="form-label"><b>Periode</b><i class="text-danger">*</i></label>
                            <select id="periode" name="periode" class="form-select" required>
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
                            <label for="link" class="form-label"><b>Link Document</b><i class="text-danger">*</i></label>
                            <input type="text" class="form-control" id="link" name="link" placeholder="Input Link Document">
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
<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
<script>
    $(document).ready(function() {
        $('#standard_category_id').select2({
            placeholder: " Select Categories",
            allowClear: true
        });

        $('#standard_criteria_id').select2({
            placeholder: "  Select Criterias",
            allowClear: true
        });

        $('#auditor_id').select2({
            placeholder: "  Select Auditor",
            allowClear: true
        });
    });
</script>
@endsection
