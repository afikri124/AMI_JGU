@extends('layouts.master')
@section('title', 'Add Audit Plan')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/sweetalert2.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="assets/vendor/libs/flatpickr/flatpickr.css" />
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
                    <div class="card-options"><a class="card-options-collapse" href="#"
                            data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                            class="card-options-remove" href="#" data-bs-toggle="card-remove"><i
                                class="fe fe-x"></i></a></div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                            <label class="form-label" for="basicDate"><b>Date Start</b></label>
                            <div class="input-group input-group-merge has-validation">
                                <input type="datetime-local" class="form-control @error('date_start') is-invalid @enderror" name="date_start"
                                    placeholder="YYYY-MM-DD HH:MM" id="flatpickr-datetime" value="{{ old('date_start') }}">
                                        @error('date_start')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong></span>
                                @enderror
                                    </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                            <label class="form-label" for="basicDate"><b>Date End</b></label>
                            <div class="input-group input-group-merge has-validation">
                                <input type="datetime-local" class="form-control @error('date_end') is-invalid @enderror" name="date_end"
                                    placeholder="YYYY-MM-DD HH:MM" id="flatpickr-datetime" value="{{ old('date_end') }}">
                                        @error('date_end')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong></span>
                                @enderror
                                    </div>
                            </div>
                        </div>
                        <p></p>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                            <label for="lecture_id" class="form-label"><b>Lecture</b></label>
                            <select name="lecture_id" id="lecture_id" class="form-select" required>
                                <option value="">Select Lecture</option>
                                @foreach($lecture as $role)
                                    <option value="{{$role->id}}"
                                        {{ (in_array($role->id, old('lecture') ?? []) ? "selected": "") }}>
                                        {{$role->name}} (
                                            @foreach ($role->roles as $x)
                                                {{ $x->name}}
                                            @endforeach
                                        )</option>
                                    @endforeach
                            </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                            <label for="auditor_id" class="form-label"><b>Auditor</b></label>
                            <select name="auditor_id" id="auditor_id" class="form-select" required>
                                <option value="">Select Auditor</option>
                                @foreach($auditor as $role)
                                    <option value="{{$role->id}}"
                                        {{ (in_array($role->id, old('auditor') ?? []) ? "selected": "") }}>
                                        {{$role->name}} (
                                            @foreach ($role->roles as $x)
                                                {{ $x->name}}
                                            @endforeach
                                        )</option>
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
                                <option value="{{$d->id}}"
                                    {{ (in_array($d->id, old('locations') ?? []) ? "selected": "") }}>
                                    {{$d->title}}</option>
                            @endforeach
                            </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                            <label for="department_id" class="form-label"><b>Department</b></label>
                            <select name="department_id" id="department_id" class="form-select" required>
                                <option value="">Select Department</option>
                                @foreach($departments as $d)
                                    <option value="{{$d->id}}"
                                        {{ (in_array($d->id, old('departments') ?? []) ? "selected": "") }}>
                                        {{$d->name}}</option>
                                    @endforeach
                            </select>
                            </div>
                        </div>
                        <p></p>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="standard_categories_id" class="form-label"><b>Category</b></label>
                                <select name="standard_categories_id" id="standard_categories_id" class="form-select" required>
                                    <option value="">Select Category</option>
                                    @foreach($category as $c)
                                        <option value="{{ $c->id }}" {{ old('standard_categories_id') == $c->id ? 'selected' : '' }}>
                                            {{ $c->description }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label class="col-form-label">Link<i class="text-danger">*</i></label>
                                <input class="form-control @error('link') is-invalid @enderror" type="text" id="link"
                                    name="link" placeholder="Input link to review document" value="{{ old('link') }}">
                                @error('link')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
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
</div>
@endsection

@section('script')
<script src="{{asset('assets/vendor/libs/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/datatables-bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/datatables.responsive.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/responsive.bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/datatables.checkboxes.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/datatables-buttons.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/buttons.bootstrap5.js')}}"></script>
<script src="{{asset('assets/js/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="assets/vendor/libs/flatpickr/flatpickr.js"></script>
<script type="text/javascript">

    "use strict";
    setTimeout(function () {
        (function ($) {
            "use strict";
            $(".select2").select2({
                allowClear: true,
                minimumResultsForSearch: 7,
            });
        })(jQuery);
    }, 350);

</script>
@endsection
