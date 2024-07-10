@extends('layouts.master')
@section('content')
@section('title', ' Edit Data Indicator')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/sweetalert2.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
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
                <form action="{{ route('update_indicator.indicator', $data->id) }}" method="POST">
                    <div class="row">
                        @csrf
                        @method('PUT')
                        <div class="form-group col-md-4">
                        <label for="standard_criteria_id" class="form-label">Select Criteria<i class="text-danger">*</i></label>
                        <select class="form-select digits select2 @error('standard_criteria_id') is-invalid @enderror"
                                name="standard_criteria_id" id="standard_criteria_id" data-placeholder="Select">
                            <option value="" selected disabled>Select Standard Criteria</option>
                            @foreach($criteria as $f)
                                <option value="{{$f->id}}" {{ $data->standard_criteria_id ? 'selected' : '' }}>
                                {{ $f->id }} - {{$f->title}}</option>
                                @endforeach
                        </select>
                        @error('standard_criteria_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <label for="name" class="col-form-label">Indicator<i class="text-danger">*</i></label>
                            <textarea class="form-control" maxlength="250" placeholder="Note: Maximum 250 char...." rows="2" name="name" id="name">{{ $data->name }}</textarea>
                        </div>
                    </div>
                    <br>
                    <div id="dynamic-form-container"></div>
                        <br>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-success me-2">Update</button>
                        <a class="btn btn-outline-secondary" href="{{ route('standard_criteria.indicator') }}">Back</a>
                    </div>
                </form>
                </div>
            @endsection

@section('script')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
@endsection
