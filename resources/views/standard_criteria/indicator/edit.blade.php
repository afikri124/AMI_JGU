@extends('layouts.master')
@section('content')
@section('title', ' Edit Indicator')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/sweetalert2.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
@endsection

<div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
<div class="row">
    <div class="col-md-12">
        @if(session('msg'))
        <div class="alert alert-primary alert-dismissible" role="alert">
            {{session('msg')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <div class="card mb-4">
            <!-- Account -->
            <hr class="my-0">
            <div class="card-body">
                <form action="{{ route('update_indicator', $data->id) }}" method="POST">
                    <div class="row">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="standard_criteria_id" class="form-label"><b>Select Criteria</b><i class="text-danger">*</i></label>
                            <select class="form-select digits select2 @error('standard_criteria_id') is-invalid @enderror"
                                    name="standard_criteria_id" id="standard_criteria_id" data-placeholder="Select">
                                <option value="" selected disabled>Select Standard Criteria</option>
                                @foreach($criteria as $c)
                                    <option value="{{ $c->id }}" {{ $data->standard_criteria_id == $c->id ? 'selected' : '' }}>
                                        {{ $c->id }} - {{$c->title}}
                                    </option>
                                @endforeach
                            </select>
                            @error('standard_criteria_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="standard_statement_id" class="form-label"><b>Select Standard Statement</b></label>
                            <select class="form-select digits select2 @error('standard_statement_id') is-invalid @enderror"
                                    name="standard_statement_id" id="standard_statement_id" data-placeholder="Select">
                                <option value="" selected disabled>Select Standard Statement</option>
                                @foreach($statement as $ind)
                                    <option value="{{$ind->id}}" {{ $data->standard_statement_id == $ind->id ? 'selected' : '' }}>
                                        {{$ind->name}}</option>
                                @endforeach
                            </select>
                            @error('standard_statement_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="name" class="col-form-label"><b>Indicator</b></label>
                            <!-- <input type="hidden" class="form-control" name="name" id="name" value = "{!! $data->name !!}"> -->
                            <textarea class="form-control" maxlength="450" placeholder="Note: Maximum 250 char...." rows="2" name="name" id="name">{{ $data->name }}</textarea>
                        </div>

                        <div class="mt-2 text-end">
                            <button type="submit" class="btn btn-primary me-1">Update</button>
                            <a class="btn btn-outline-secondary" href="{{ route('standard_criteria.indicator.index') }}">Back</a>
                        </div>
                </form>
                </div>
            @endsection

@section('script')
<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>

<script>
    "use strict";
    setTimeout(function () {
        (function ($) {
            "use strict";
            $(".select2").select2({
                allowClear: true,
                minimumResultsForSearch: 7
            });
        })(jQuery);
    }, 350);
</script>

@endsection
