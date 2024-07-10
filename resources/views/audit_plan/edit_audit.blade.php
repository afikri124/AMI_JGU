@extends('layouts.master')
@section('content')
@section('title', ' Edit Data Audit Plan')

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
            <div class="card-header">
                <h4 class="card-header"><b>Update Audit Plan</b></h4>
                <hr class="my-0">
            </div>
            <div class="card-body">
                <form action="{{ route('update_audit', $data->id) }}" method="POST">
                    <div class="row">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <label class="form-label" for="basicDate"><b>Date Start</b><i class="text-danger">*</i></label>
                            <div class="input-group input-group-merge has-validation">
                                <input type="datetime-local" class="form-control @error('date_start') is-invalid @enderror" name="date_start"
                                    placeholder="Masukkan Date " value="{{ $data->date_start }}">
                                        @error('date_start')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong></span>
                                @enderror
                                    </div>
                                        </div>
                                        <p></p>
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <label class="form-label" for="basicDate"><b>Date End</b><i class="text-danger">*</i></label>
                            <div class="input-group input-group-merge has-validation">
                                <input type="datetime-local" class="form-control @error('date_end') is-invalid @enderror" name="date_end"
                                    placeholder="Masukkan Date" value="{{ $data->date_end }}">
                                        @error('date_end')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong></span>
                                @enderror
                                    </div>
                                        </div>
                                        <p></p>
                            <div class="col-sm-12 fv-plugins-icon-container">
                            <label for="auditor_id" class="form-label"><b>Auditor</b><i class="text-danger">*</i></label>
                            <select name="auditor_id" id="auditor_id" class="form-select" required>
                            <option value="">Select Auditor</option>
                            @foreach($auditor as $role)
                                <option value="{{$role->id}}" {{ $data->auditor_id ? 'selected' : '' }}>
                                    {{$role->name}}</option>
                                @endforeach
                            </select>
                            </div>
                            <p></p>
                            <div class="col-sm-12 fv-plugins-icon-container">
                                <label for="location_id" class="form-label"><b>Location</b><i class="text-danger">*</i></label>
                                <select name="location_id" id="location_id" class="form-select" required>
                                    <option value="">Select Location</option>
                                    @foreach($locations as $d)
                                        <option value="{{ $d->id }}" {{ $d->id == $data->location_id ? 'selected' : '' }}>
                                            {{ $d->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>                            
                    <p></p>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-success me-2">Update</button>
                        <a class="btn btn-outline-secondary" href="{{ route('audit_plan.index') }}">Back</a>
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
