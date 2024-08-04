@extends('layouts.master')
@section('content')
@section('title', 'Make Report')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
@endsection

@section('style')
<style>
    .badge-icon {
        display: inline-block;
        font-size: 1em;
        padding: 0.4em;
        margin-right: 0.1em;
    }

    .icon-white {
        color: white;
    }
</style>
@endsection

<div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
    <div class="card">
        <div class="card-datatable table-responsive">
            <div class="card-header flex-column flex-md-row pb-0">
                <div class="row">
                    <div class="col-12 pt-3 pt-md-0">
                        <div class="col-12">
                            <div class="row">
                                <div class="offset-md-0 col-md-0 text-md-end text-center pt-3 pt-md-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid flex-grow-1 container-p-y">
                    <table class="table table-hover table-sm" id="datatable" width="100%">
                        <thead>
                            <tr>
                                <th><b>No</b></th>
                                <th width="15%"><b>Type</b></th>
                                <th><b>Action</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Absensi</td>
                                <td><a href="{{ route('observations.make_report.att', ['id' => 1, 'type' => 'Absensi']) }}" class="btn btn-primary btn-sm">Print</a></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Berita Acara</td>
                                <td><a href="{{ route('observations.make_report.att', ['id' => 2, 'type' => 'Berita Acara']) }}" class="btn btn-primary btn-sm">Print</a></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Check List</td>
                                <td><a href="{{ route('observations.make_report.att', ['id' => 3, 'type' => 'Check List']) }}" class="btn btn-primary btn-sm">Print</a></td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>PTK</td>
                                <td><a href="{{ route('observations.make_report.att', ['id' => 4, 'type' => 'PTK']) }}" class="btn btn-primary btn-sm">Print</a></td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>PTP</td>
                                <td><a href="{{ route('observations.make_report.att', ['id' => 5, 'type' => 'PTP']) }}" class="btn btn-primary btn-sm">Print</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/vendor/libs/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/datatables/datatables-bootstrap5.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/datatables/datatables.responsive.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/datatables/responsive.bootstrap5.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/datatables/datatables.checkboxes.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/datatables/datatables-buttons.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/datatables/buttons.bootstrap5.js') }}"></script>
@endsection
