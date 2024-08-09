@extends('layouts.master')
@section('content')
@section('title', 'Edit Audit Plan')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endsection

<!-- <div class="container-fluid flex-grow-1 container-p-y"> -->
<div class="row">
    <div class="col-md-12">
        @if(session('msg'))
        <div class="alert alert-primary alert-dismissible" role="alert">
            {{session('msg')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <div class="card mb-4">
            <!-- <div class="card-header">
                <h4 class="card-header"><b>Update Audit Plan</b></h4>
                <hr class="my-0">
            </div> -->
            <div class="card-body">
                <form action="{{ route('update_audit', $data->id) }}" method="POST">
                    <div class="row">
                        @csrf
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
                                <select name="auditor_id[]" id="auditor_id" class="form-select select2" multiple required>
                                    <option value="">Select Auditor</option>
                                    @foreach($auditors as $auditor)
                                        <option value="{{ $auditor->id }}" {{ in_array($auditor->id, $selectedAuditors) ? 'selected' : '' }}>
                                            {{ $auditor->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <p></p>
                            <div class="col-sm-12 fv-plugins-icon-container">
                                <label for="location_id" class="form-label"><b>Location</b><i class="text-danger">*</i></label>
                                <select name="location_id" id="location_id" class="form-select select2" required>
                                    <option value="">Select Location</option>
                                    @foreach($locations as $d)
                                        <option value="{{ $d->id }}" {{ old('location_id', $data->location_id) == $d->id ? 'selected' : '' }}>
                                            {{ $d->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                    <p></p>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary me-1">Update</button>
                        <a class="btn btn-outline-secondary" href="{{ route('audit_plan.index') }}">Back</a>
                    </div>
                </form>
                </div>
            @endsection

@section('script')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('#auditor_id').select2({
        placeholder: "Select Auditor",
        allowClear: true
    });
    $('#location_id').select2({
        placeholder: "Select Location",
        allowClear: true
    });

    $('#auditor_id').change(function() {
        let selected = $(this).val();
        console.log('Selected Auditors: ', selected); // Tampilkan auditor yang terpilih di console
    });
});
</script>
@endsection
