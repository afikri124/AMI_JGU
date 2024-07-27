@extends('layouts.master')

@section('content')
@section('title', 'Create Standard Statement')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css') }}" />
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
            <div class="card-body">
                <form id="form-add-new-record" method="POST" action="{{ route('standard_criteria.standard_statement.create') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group col-md-4">
                        <label for="standard-_criteria_id" >Select Criteria</label>
                        <div class="form-group">
                                <select name="standard_criteria_id" id="standard_criteria_id" class="form-select input-sm select2" required>
                                    <option value="">Select Criterias</option>
                                    @foreach($criterias as $c)
                                        <option value="{{ $c->id }}" {{ old('standard_criteria_id') == $c->id ? 'selected' : '' }}>
                                        {{ $c->id }} -  {{ $c->title }}
                                        </option>
                                        @endforeach
                                </select>
                            </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="numForms">Number of Forms</label>
                        <input type="number" class="form-control" id="numForms" name="numForms" min="1">
                    </div>

                    <div id="dynamic-form-container"></div>

                    <div class="col-sm-12 mt-4">
                        <button type="submit" class="btn btn-primary data-submit me-sm-1">Create</button>
                        <a href="{{ url()->previous() }}">
                        <span class="btn btn-outline-secondary">Back</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@section('script')
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
                            <label for="inputField${i + 1}_1">Standard Statement (Max. 250 char)<i class="text-danger">*</i></label>
                            <textarea type="text-danger" class="form-control" maxlength="250" id="inputField${i + 1}_1" name="standard_statements[${i}][name]">

            `;
            container.insertAdjacentHTML('beforeend', row);
        }
    });
});
</script>
<!-- <div class="col-md-4">
                        <div class="form-group">
                            <label for="inputField${i + 1}_2">Sub Indikator</label>
                            <textarea type="text-danger" class="form-control" id="inputField${i + 1}_2" name="indicators[${i}][sub_indicator]"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="inputField${i + 1}_3">Review Document</label>
                            <textarea type="text-danger" class="form-control" id="inputField${i + 1}_3" name="indicators[${i}][review_document]"></textarea>
                        </div>
                    </div> -->
@endsection
@endsection
