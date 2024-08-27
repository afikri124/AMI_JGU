@extends('layouts.master')

@section('content')
@section('title', 'Create Review Document')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
@endsection
<style>
    .checkbox label::before {
        border: 1px solid #333;
    }
</style>

<div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
    <div class="row">
    <div class="col-md-12">
            @if(session('msg'))
            <div class="alert alert-primary alert-dismissible" role="alert">
                {{ session('msg') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="card mb-4">
                <hr class="my-0">
                <div class="card-header">Review Document</div>
                <div class="card-body">
                <form id="form-add-new-record" method="POST" action="{{ route('store_docs.review_docs') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="standard_criteria_id" class="form-label">Select Criteria<i class="text-danger">*</i></label>
                                <div class="form-group">
                                    <select name="standard_criteria_id" id="standard_criteria_id" class="form-select input-sm select2" required>
                                        <option value="">Select Criteria</option>
                                        @foreach($criterias as $c)
                                            <option value="{{ $c->id }}" {{ old('standard_criteria_id') == $c->id ? 'selected' : '' }}>
                                                {{ $c->id }} - {{ $c->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="standard_statement_id" class="form-label">Select Standard Statement<i class="text-danger">*</i></label>
                                <div class="form-group">
                                    <select class="form-select input-sm select2" name="standard_statement_id" id="standard_statement_id">
                                        <option value="" selected disabled>Select Standard Statement</option>
                                        @foreach($statements as $c)
                                            <option value="{{ $c->id }}" {{ old('standard_statement_id') == $c->id ? 'selected' : '' }}>
                                                {{ $c->id }} - {{ $c->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('standard_statement_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="indicator_id" class="form-label">Indicator<i class="text-danger">*</i></label>
                                <div class="form-group">
                                    <select class="form-select input-sm select2" name="indicator_id" id="indicator_id">
                                        <option value="" selected disabled>Indicator</option>
                                        @foreach($indicators as $c)
                                            <option value="{{ $c->id }}" {{ old('indicator_id') == $c->id ? 'selected' : '' }}>
                                                {{ $c->id }} - {{ $c->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('indicator_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
<p></p>
                        <div class="form-group col-md-4">
                                <label for="numForms">Number of Forms</label>
                                <input type="number" class="form-control" id="numForms" name="numForms" min="1">
                            </div>
                            <div id="dynamic-form-container"></div>
                            <div class="col-sm-12 mt-4">
                                <button type="submit" class="btn btn-primary data-submit me-sm-1">Create</button>
                                <a href="{{ route('standard_criteria.review_docs')}}">
                                <span class="btn btn-outline-secondary">Back</span>
                                </a>
                            </div>
                    </form>
                    </div>
                </div>
        </div>
        </div>

@section('script')
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
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
document.addEventListener('DOMContentLoaded', function() {
document.getElementById('numForms').addEventListener('input', function() {
        var numForms = this.value;
        var container = document.getElementById('dynamic-form-container');
        container.innerHTML = ''; // Clear existing forms

        for (var i = 0; i < numForms; i++) {
            var row = `
            <p></p>
            <div class="row mb-3">
                <div class="form-group">
                    <label for="inputField${i + 1}_1">Review Document<i class="text-danger">*</i></label>
                    <input type="hidden"  class="form-control" id="inputField${i + 1}_1" name="review_docs[${i}][name]"></input>
                    <trix-editor input="inputField${i + 1}_1"></trix-editor>
                    </div>
                </div>`;
            container.insertAdjacentHTML('beforeend', row);
        }
});
});
</script>
<script>
$('#standard_criteria_id').change(function() {
    var categoryId = this.value;
    $("#standard_statement_id").html('');
    $.ajax({
        url: "{{ route('DOC.get_standard_statement_id_by_id') }}",
        type: "GET",
        data: { id: categoryId, _token: '{{ csrf_token() }}'},
        dataType: 'json',
        success: function(result) {
        $('#standard_statement_id').html('<option value="">Select Standard Statement</option>');
            $.each(result, function(key, value) {
                $("#standard_statement_id").append('<option value="' + value.id +'">' + value.name + '</option>');
            });
        }
    });
});
$('#standard_statement_id').change(function() {
    var statementId = this.value;
    $("#indicator_id").html('');
    $.ajax({
        url: "{{ route('DOC.get_indicator_id_by_id') }}", // Sesuaikan dengan rute Anda
        type: "GET",
        data: { id: statementId, _token: '{{ csrf_token() }}'},
        dataType: 'json',
        success: function(result) {
            $('#indicator_id').html('<option value="">Select Indicator</option>');
            $.each(result, function(key, value) {
                $("#indicator_id").append('<option value="' + value.id +'">' + value.name + '</option>');
            });
        }
    });
});
</script>
@endsection
@endsection
