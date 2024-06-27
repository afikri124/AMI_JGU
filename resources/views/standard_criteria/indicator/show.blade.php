@extends('layouts.master')
@section('title', 'Indicator')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/sweetalert2.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
@endsection

@section('style')
<style>
    table.dataTable tbody td {
        vertical-align: middle;
    }

    table.dataTable td:nth-child(2) {
        max-width: 120px;
    }

    table.dataTable td:nth-child(3) {
        max-width: 100px;
    }

    table.dataTable td {
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

</style>
@endsection

@section('breadcrumb-title')
<h3>@yield('title')</h3>
@endsection

@section('breadcrumb-items')
@endsection


@section('content')
    <div class="col-md-12">
        <ul class="nav nav-pills flex-column flex-sm-row mb-4">
        <li class="nav-item"><a class="nav-link " href="{{ route('standard_criteria.criteria') }}"><i
                        class="bx bx-add-to-queue me-1"></i>
                    Data Standard</a></li>    
        <li class="nav-item"><a class="nav-link active" href="{{ route('standard_criteria.indicator') }}"><i
                        class="bx bx-chart me-1"></i>
                    Indicator</a></li>
        </ul>
    </div>

<div class="card">
    <div class="card-datatable table-responsive">
        <div class="card-header flex-column flex-md-row pb-0">
            <div class="row">
                <div class="col-12 pt-3 pt-md-0">
                    <div class="col-12">
                        <div class="row">
                {{-- <div class="col-md d-flex justify-content-center justify-content-md-end">
                    <a class="btn btn-primary btn-block btn-mail" title="Add new"
                        href="">
                        <i data-feather="plus"></i>+ Add
                    </a>
                </div> --}}
        <table class="table table-hover table-sm" id="indicator-table" width="100%">
            <thead>
                <tr>
                    <th width="10px">Indicator</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@section('script')
<script src="{{asset('assets/vendor/libs/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/datatables-buttons.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/buttons.bootstrap5.js')}}"></script>
<script src="{{asset('assets/js/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/js/sweet-alert/sweetalert.min.js')}}"></script>
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
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#indicator-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("data.indicator", $criteria->id) }}',
                type: 'GET'
            },
            columns: [
                { data: 'name', name: 'name' },
                
            ]
        });
    });
</script>

   
@endsection
