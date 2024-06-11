@extends('layouts.master')
@section('title', 'New Criteria')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/select2.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/select2-bootstrap.css')}}">
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
                                    class="form-select digits select2 @error('criteria_category_id') is-invalid @enderror"
                                    name="criteria_category_id" id="criteria_category_id" data-placeholder="Select">
                                    <option value="" selected disabled>Select</option>
                                    @foreach($category as $p)
                                    <option value="{{ $p->id }}"
                                        {{ ($p->id==old('criteria_category_id') ? "selected": "") }}>
                                        {{ $p->id }} - {{ $p->title }}</option>
                                    @endforeach
                                </select>
                                @error('criteria_category_id')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label class="col-form-label">Weight<i class="text-danger">*</i></label>
                                <input class="form-control @error('weight') is-invalid @enderror" id="weight"
                                    name="weight" value="{{ old('weight') }}" type=number min=0 step=0.10>
                                @error('weight')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12">
                            <div class="form-group mb-2">
                                <label class="col-form-label">Criteria Title<i class="text-danger">*</i></label>
                                <textarea class="form-control @error('title') is-invalid @enderror" rows="2"
                                    name="title" placeholder="Note: Maximum 191 char.">{{ old('title') }}</textarea>
                                @error('title')
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
<script src="{{asset('assets/js/select2/select2.full.min.js')}}"></script>
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
