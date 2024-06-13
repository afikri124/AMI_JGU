@extends('layouts.master')
@section('title', 'New Criteria')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/sweetalert2.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
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
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <form class="card" method="POST" action="">
                @csrf
                <div class="card-header">
                    <h4 class="card-title mb-0">Add @yield('title')</h4>
                    <div class="card-options"><a class="card-options-collapse" href="#"
                            data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                            class="card-options-remove" href="#" data-bs-toggle="card-remove"><i
                                class="fe fe-x"></i></a></div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                                <label class="col-form-label">Category<i class="text-danger">*</i></label>
                                <select
                                    class="form-select digits select2 @error('standard_category_id') is-invalid @enderror"
                                    name="standard_category_id" id="standard_category_id" data-placeholder="Select">
                                    <option value="" selected disabled>Select </option>
                                    @foreach($category as $p)
                                    <option value="{{ $p->id }}"
                                        {{ ($p->id==old('standard_category_id') ? "selected": "") }}>
                                        {{ $p->id }} - {{ $p->description }}</option>
                                    @endforeach
                                </select>
                                @error('standard_category_id')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label class="col-form-label">Standard<i class="text-danger">*</i></label>
                                <select
                                    class="form-select digits select2 @error('standard_id') is-invalid @enderror"
                                    name="standard_id" id="standard_id" data-placeholder="Select">
                                    <option value="" selected disabled>Select </option>
                                    @foreach($standard as $p)
                                    <option value="{{ $p->id }}"
                                        {{ ($p->id==old('standard_id') ? "selected": "") }}>
                                        {{ $p->id }} - {{ $p->name }}</option>
                                    @endforeach
                                </select>
                                @error('standard_id')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label class="col-form-label">Indicator<i class="text-danger">*</i></label>
                                <select
                                    class="form-select digits select2 @error('indicator_id') is-invalid @enderror"
                                    name="indicator_id" id="indicator_id" data-placeholder="Select">
                                    <option value="" selected disabled>Select</option>
                                    @foreach($indicator as $p)
                                    <option value="{{ $p->id }}"
                                        {{ ($p->id==old('indicator_id') ? "selected": "") }}>
                                        {{ $p->id }} - {{ $p->name }}</option>
                                    @endforeach
                                </select>
                                @error('indicator_id')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
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
<script>
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
