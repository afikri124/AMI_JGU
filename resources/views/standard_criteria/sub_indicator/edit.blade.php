@extends('layouts.master')
@section('content')
@section('title', ' Edit Sub Indicator')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/sweetalert2.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">

@endsection

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
                <form action="{{ route('update_sub.sub_indicator', $data->id) }}" method="POST">
                    <div class="row">
                        @csrf
                        @method('PUT')
                        <div class="form-group col-md-4">
                        <label for="indicator_id" class="form-label">Select Indicator</label>
                        <select class="form-select digits select2 @error('indicator_id') is-invalid @enderror"
                                name="indicator_id" id="indicator_id" data-placeholder="Select">
                            <option value="" selected disabled>Select Indicator</option>
                            @foreach($criteria as $d)
                                <option value="{{$d->id}}" {{ $data->indicator_id ? 'selected' : '' }}>
                                {{$d->id}} - {{$d->title}}</option>
                                @endforeach
                        </select>
                        @error('indicator_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <label for="name" class="col-form-label">Sub Indicator</label>
                            <input type="hidden" class="form-control"  name="name" id="name" value = "{!! $data->name !!}"></input>
                            <trix-editor input="name"></trix-editor>
                        </div>
                    </div>
                    <br>
                    <div id="dynamic-form-container"></div>
                        <br>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-success me-2">Update</button>
                        <a class="btn btn-outline-secondary" href="{{ route('standard_criteria.sub_indicator') }}">Back</a>
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
