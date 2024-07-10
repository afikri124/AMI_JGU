@extends('layouts.master')
@section('title', 'Add Audit Plan')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
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
      <form class="card" method="POST" action="{{ route('audit_plan.standard.create', $data->id) }}">
            @csrf
            <div class="card-header">
                <h3 class="card-header"><b>Create Audit Plan</b></h3>
                <hr class="my-0">
            </div>
            <div class="card-body">
                <input type="hidden" name="audit_plan_id" value="{{ $data->id }}">
                <div class="row">
                    <div class="col-sm-6  col-md-12">
                            <label for="auditor_id" class="form-label"><b>Auditor</b><i class="text-danger">*</i></label>
                            <select name="auditor_id" id="auditor_id" class="form-select" required>
                            <option value="">Select Auditor</option>
                            @foreach($auditor as $role)
                                <option value="{{$role->id}}" {{ $data->auditor_id ? 'selected' : '' }}>
                                    {{$role->name}}</option>
                                @endforeach
                            </select>
                  <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="standard_category_id" class="form-label"><b>Category</b><i class="text-danger">*</i></label>
                            <select name="standard_category_id[]" id="standard_category_id" class="form-select select2" multiple required>
                                @foreach($category as $c)
                                <option value="{{ $c->id }}" {{ in_array($c->id, old('standard_category_id', [])) ? 'selected' : '' }}>
                                    {{ $c->id }} - {{ $c->description }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="standard_criteria_id" class="form-label"><b>Criteria</b><i class="text-danger">*</i></label>
                            <select name="standard_criteria_id[]" id="standard_criteria_id" class="form-select select2" multiple required>
                                @foreach($criterias as $c)
                                <option value="{{ $c->id }}" {{ in_array($c->id, old('standard_criteria_id', [])) ? 'selected' : '' }}>
                                    {{ $c->id }} - {{ $c->title }}
                                </option>
                                @endforeach
                            </select>
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
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select an option",
            allowClear: true
        });
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
<script>
    $(document).ready(function() {
        $('#standard_category_id').select2({
            placeholder: " Select Categories",
            allowClear: true
        });

        $('#standard_criteria_id').select2({
            placeholder: "  Select Criterias",
            allowClear: true
        });

        $('#auditor_id').select2({
            placeholder: "  Select Auditor",
            allowClear: true
        });
    });
</script>
@endsection
