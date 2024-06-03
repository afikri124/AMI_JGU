@extends('layouts.master')
@section('content')
@section('title', ' Edit Data Audit Plan')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/sweetalert2.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
@endsection

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">EDIT AUDIT PLAN</div>
                <div class="card-body">
                    <form action="{{ route('update_audit', $data->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                        <div class="col-sm-12 fv-plugins-icon-container">
                        <label for="lecture_id" class="form-label" >Lecture</label>
                        <select name="lecture_id" id="lecture_id" class="form-select" required>
                            <option value="">Select Lecture</option>
                            @foreach($users as $role)
                                <option value="{{$role->id}}"
                                    {{ (in_array($role->id, old('users') ?? []) ? "selected": "") }}>
                                    {{$role->name}}
                                    (
                                        @foreach ($role->roles as $x)
                                            {{ $x->name}}
                                        @endforeach
                                        )</option>
                                @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <label class="form-label" for="basicDate">Date</label>
                            <div class="input-group input-group-merge has-validation">
                                <input type="date" class="form-control @error('date') is-invalid @enderror" name="date"
                                    placeholder="Masukkan Date" value="{{ $data->date }}">
                                        @error('date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong></span>
                                @enderror
                                    </div>
                                        </div>
                        <div class="col-sm-12 fv-plugins-icon-container">
                            <label for="location_id" class="form-label" >Location</label>
                            <select name="location_id" id="location_id" class="form-select" required>
                                <option value="Online" {{ (isset($data->location_id) && "Online" == $data->location_id ? "selected" : "") }}
                                    {{ ("Online" == old('location_id') ? "selected" : "") }}>Select Location
                                </option>
                                @foreach($locations as $d)
                                <option value="{{ $d->title }}"
                                    {{ (isset($data->location_id) && $d->title == $data->location_id ? "selected" : "") }}
                                    {{ ($d->title == old('location_id') ? "selected" : "") }}>
                                    {{ $d->title }}
                                </option>
                                @endforeach
                                <option value="Others" {{ (isset($data->location_id) && "Others" == $data->location_id ? "selected" : "") }}
                                    {{ ("Others" == old('location_id') ? "selected" : "") }}>Others
                                </option>
                            </select>
                        </div>
                        <div class="col-sm-12 fv-plugins-icon-container">
                            <label for="auditor_id" class="form-label">Auditor</label>
                            <select name="auditor_id" id="auditor_id" class="form-select" required>
                                <option value="">Select Auditor</option>
                                @foreach($users as $role)
                                    <option value="{{$role->id}}"
                                        {{ (in_array($role->id, old('users') ?? []) ? "selected": "") }}>
                                        {{$role->name}}
                                        (
                                            @foreach ($role->roles as $x)
                                                {{ $x->name}}
                                            @endforeach
                                        )</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12 fv-plugins-icon-container">
                            <label for="department_id" class="form-label" >Department</label>
                            <select name="department_id" id="department_id" class="form-select" required>
                                <option value="">Select Department</option>
                                @foreach($departments as $role)
                                    <option value="{{$role->id}}"
                                        {{ (in_array($role->id, old('departments') ?? []) ? "selected": "") }}>
                                        {{$role->title}}</option>
                                    @endforeach
                            </select>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Update</button>
                        </form>
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
