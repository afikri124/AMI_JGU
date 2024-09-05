@extends('layouts.master')
@section('title', 'Auditor Standard')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
@endsection

@section('style')
<style>
    .input-validation-error~.select2 .select2-selection {
        border: 1px solid red;
    }
    .bg-user {
        background-color: #F5F7F8;
    }
</style>
@endsection

@section('breadcrumb-title')
<!-- <h3>User Profile</h3> -->
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
    <form class="card" action="{{ route('create_auditor_std', $data->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card-header">
        <h3 class="card-header"><b>Create Auditor Standard</b></h3>
        <hr class="my-0">
    </div>
    <div class="card-body">
        <div class="row">
            @foreach($auditors as $key => $auditor)
                <div class="col-lg-6 col-md-12 mb-3">
                    <label class="form-label"><b>Auditor {{ $key + 1 }}</b></label>
                    <input type="text" class="form-control bg-user" value="{{ $auditor->auditor->name }}" readonly>
                    <input type="hidden" name="auditor_id[]" value="{{ $auditor->id }}">
                    <p></p>
                <div class="form-group">
                    <label for="standard_category_id_{{ $auditor->id }}" class="form-label"><b>Category</b><i class="text-danger">*</i></label>
                    <select name="standard_category_id[{{ $auditor->id }}][]" id="standard_category_id_{{ $auditor->id }}" class="form-select select2 standard_category_id" multiple required>
                        @foreach($category as $c)
                            <option value="{{ $c->id }}" {{ in_array($c->id, $selectedCategories[$auditor->id] ?? []) ? 'selected' : '' }}>
                                {{ $c->id }} - {{ $c->description }}
                            </option>
                        @endforeach
                    </select>
                </div>
                    <p></p>
                <div class="form-group">
                    <label for="standard_criteria_id_{{ $auditor->id }}" class="form-label"><b>Criteria</b><i class="text-danger">*</i></label>
                    <select name="standard_criteria_id[{{ $auditor->id }}][]" id="standard_criteria_id_{{ $auditor->id }}" class="form-select select2" multiple required>
                        @foreach($criteria as $c)
                            <option value="{{ $c->id }}" {{ in_array($c->id, $selectedCriteria[$auditor->id] ?? []) ? 'selected' : '' }}>
                                {{ $c->id }} - {{ $c->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                </div>
            @endforeach
        </div>
        <div class="card-footer text-end">
            <button class="btn btn-primary me-1" type="submit">Create</button>
            <a href="{{ url()->previous() }}">
                <span class="btn btn-outline-secondary">Back</span>
            </a>
        </div>
    </div>
</form>
    </div>
</div>
@endsection

@section('script')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script>
    $(document).ready(function() {
    $('.select2').each(function() {
        let placeholderText = '';

        if ($(this).attr('id').includes('standard_category_id')) {
            placeholderText = "Select Standard Category";
        } else if ($(this).attr('id').includes('standard_criteria_id')) {
            placeholderText = "Select Standard Criteria";
        } else {
            placeholderText = "Select an option";
        }

        $(this).select2({
            placeholder: placeholderText,
            allowClear: true
        });
    });

    $(document).on('change', '.standard_category_id', function() {
    let auditorId = $(this).attr('id').split('_')[3];
    let selectedCategories = $(this).val();

    if (selectedCategories.length > 0) {
        $.ajax({
            url: "{{ route('DOC.get_standard_criteria_id_by_id') }}",
            type: "GET",
            data: {
                ids: selectedCategories,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(results) {
                let criteriaOptions = '<option value="">Select Standard Criteria</option>';

                // Filter and display only criteria that match the selected categories
                $.each(results, function(key, value) {
                    if (selectedCategories.includes(value.standard_category_id.toString())) {
                        criteriaOptions += '<option value="' + value.id + '">' + value.title + '</option>';
                    }
                });

                // Update the criteria dropdown for the specific auditor
                $('#standard_criteria_id_' + auditorId).html(criteriaOptions);

                // Restore previously selected criteria for the specific auditor
                $('#standard_criteria_id_' + auditorId).val(selectedCriteria[auditorId] || []).trigger('change');
            }
        });
    } else {
        $('#standard_criteria_id_' + auditorId).html('<option value="">Select Standard Criteria</option>').trigger('change');
    }
});

    // Handle criteria selection for each auditor
    $(document).on('change', '.standard_criteria_id', function() {
        let auditorId = $(this).attr('id').split('_')[3];
        selectedCriteria[auditorId] = $(this).val();
    });
});
</script>
@endsection
