@extends('layouts.master')

@section('content')
@section('title', 'Add Indicator')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection

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
            <div class="card-header">Indicator</div>
            <div class="card-body">
                <form id="form-add-new-record" method="POST" action="{{ route('store.indicator') }}" enctype="multipart/form-data">
                    @csrf
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
                        <input type="number" class="form-control" id="numForms" name="numForms" min="1">
                    </div>

                    <div id="dynamic-form-container"></div>

                    <div class="col-sm-12 mt-4">
                        <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@section('script')
<script src="{{ asset('assets/vendor/libs/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/datatables/datatables-bootstrap5.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/datatables/datatables.responsive.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/datatables/responsive.bootstrap5.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/datatables/datatables.checkboxes.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/datatables/datatables-buttons.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/datatables/buttons.bootstrap5.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
<script>
   document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('numForms').addEventListener('input', function() {
        var numForms = this.value;
        var container = document.getElementById('dynamic-form-container');
        container.innerHTML = ''; // Clear existing forms

        for (var i = 0; i < numForms; i++) {
            var row = `
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="inputField${i + 1}_1">Indikator</label>
                            <input type="text" class="form-control" id="inputField${i + 1}_1" name="indicators[${i}][name]">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="inputField${i + 1}_2">Sub Indikator</label>
                            <input type="text" class="form-control" id="inputField${i + 1}_2" name="indicators[${i}][sub_indicator]">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="inputField${i + 1}_3">Review Document</label>
                            <input type="text" class="form-control" id="inputField${i + 1}_3" name="indicators[${i}][review_document]">
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', row);
        }
    });
});
</script>
@endsection
@endsection
