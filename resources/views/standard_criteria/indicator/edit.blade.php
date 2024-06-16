@extends('layouts.master')
@section('content')
@section('title', ' Edit Data Indicator')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
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
                <form action="{{ route('update.indicator', $criteria->id) }}" method="POST">
                    <div class="row">
                        @csrf
                        @method('PUT')
                        <div class="form-group col-md-4">
                        <label for="standard_criterias_id" class="form-label">Select Standard Criteria</label>
                        <select class="form-select digits select2 @error('standard_criterias_id') is-invalid @enderror"
                                name="standard_criterias_id" id="standard_criterias_id" data-placeholder="Select">
                            <option value="" selected disabled>Select Standard Criteria</option>
                            @foreach ($allCriteria as $criteriaItem)
                                <option value="{{ $criteriaItem->id }}" {{ $criteriaItem->id == $criteria->id ? 'selected' : '' }}>
                                    {{ $criteriaItem->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('standard_criterias_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="numForms">Number of Forms</label>
                        <input type="number" class="form-control" id="numForms" name="numForms" min="1"
                        value="{{$criteria->numForms}}">
                    </div>

                    <div id="dynamic-form-container"></div>
                        <br>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-2">Submit</button>
                        <a class="btn btn-outline-secondary" href="{{ route('standard_criteria.indicator') }}">Back</a>
                    </div>
                </form>
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
@endsection
