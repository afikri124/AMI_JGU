@extends('layouts.master')
@section('title', 'Edit Auditor Standard')

@section('css')
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
<div class="row">
    <div class="col-md-12">
      <form class="card" action="{{ route('update_auditor_std', $data->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
            <div class="card-header">
                <h3 class="card-header"><b>Edit Auditor Standard</b></h3>
                <hr class="my-0">
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <label for="auditor_id" class="form-label"><b>Auditor</b><i class="text-danger">*</i></label>
                        <select name="auditor_id" id="auditor_id" class="form-select select2">
                            <option value="">Select Auditor</option>
                            @foreach($auditor as $role)
                                <option value="{{$role->id}}" {{ $role->id == $data->auditor_id ? 'selected' : '' }}>
                                    {{$role->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <p></p>
                    <div class="col-lg-6 col-md-12">
                        <label for="standard_category_id" class="form-label"><b>Category</b><i class="text-danger">*</i></label>
                        <select name="standard_category_id[]" id="standard_category_id" class="form-select select2" multiple required>
                            <option value="">Select Category</option>
                            @foreach($category as $x)
                                <option value="{{ $x->id }}" {{ in_array($x->id, $selectedCategory) ? 'selected' : '' }}>
                                    {{ $x->description }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <label for="standard_criteria_id" class="form-label"><b>Criteria</b><i class="text-danger">*</i></label>
                        <select name="standard_criteria_id[]" id="standard_criteria_id" class="form-select select2" multiple required>
                            <option value="">Select Criteria</option>
                            @foreach($criteria as $x)
                                <option value="{{ $x->id }}" {{ in_array($x->id, $selectedCriteria) ? 'selected' : '' }}>
                                    {{ $x->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <button class="btn btn-primary" type="submit">Update</button>
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
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#standard_category_id').select2({
            placeholder: " Select Category",
            allowClear: true
        });
        $('#standard_criteria_id').select2({
            placeholder: " Select Criteria",
            allowClear: true
        });

        function disableSelectedOptions() {
            $('#standard_criteria_id option').each(function() {
                if ($(this).is(':selected')) {
                    $(this).attr('disabled', 'disabled');
                } else {
                    $(this).removeAttr('disabled');
                }
            });
        }

        disableSelectedOptions();

        $('#standard_criteria_id').on('change', function() {
            disableSelectedOptions();
            $(this).select2('close');
        });

        $('form').on('submit', function() {
            $('#standard_criteria_id option').removeAttr('disabled');
        });
    });
</script>
@endsection
