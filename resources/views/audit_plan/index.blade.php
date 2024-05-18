@extends('layouts.master')
@section('breadcrumb-items')
@endsection
@section('title', 'Audit Plan')

@section('css')
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
        max-width: 100px;
    }

    table.dataTable td:nth-child(3) {
        max-width: 80px;
    }

    table.dataTable td:nth-child(4) {
        max-width: 80px;
    }

    table.dataTable td {
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
        word-wrap: break-word;
    }

</style>
@endsection

@section('content')
<div class="card">
    <div class="card-datatable table-responsive">
        <div class="card-header flex-column flex-md-row pb-0">
            <div class="row">
                <div class="col-12 pt-3 pt-md-0">
                    <div class="col-12">
                        <div class="row">
                            <div class=" col-md-3">
                            <div class="offset-md-0 col-md-8 text-md-end text-center pt-3 pt-md-0">
                                @can('setting/manage_account/users.create')
                                <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
                                    data-bs-target="#newrecord" aria-controls="offcanvasEnd" tabindex="0"
                                    aria-controls="DataTables_Table_0" type="button"><span>
                                        <i class="bx bx-plus me-sm-2"></i>
                                            <span>Add</span></span>
                                </button>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="offcanvas offcanvas-end @if($errors->all()) show @endif" tabindex="-1" id="newrecord"
                aria-labelledby="offcanvasEndLabel">
                <div class="offcanvas-header">
                    <h5 id="offcanvasEndLabel" class="offcanvas-title">Add</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body my-auto mx-0 flex-grow-1">
                    <form class="add-new-record pt-0 row g-2 fv-plugins-bootstrap5 fv-plugins-framework"
                        id="form-add-new-record" method="POST" action="">
                        @csrf
                        <div class="col-sm-12 fv-plugins-icon-container">
                            <label class="form-label" for="basicDate">Date</label>
                            <div class="input-group input-group-merge has-validation">
                                <input type="date" class="form-control @error('date') is-invalid @enderror"
                                    name="date" placeholder="date" value="{{ old('date') }}" maxlength="24">
                                @error('date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 fv-plugins-icon-container">
                            <label class="form-label" for="basicDate">Auditee</label>
                            <div class="input-group input-group-merge has-validation">
                                <input type="auditee" class="form-control @error('auditee') is-invalid @enderror"
                                    name="auditee" placeholder="auditee" value="{{ old('auditee') }}" maxlength="24">
                                @error('auditee')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 fv-plugins-icon-container form-password-toggle">
                            <label class="form-label" for="basicDate">Location</label>
                            <div class="input-group input-group-merge has-validation">
                                <input type="text" class="form-control @error('location_id') is-invalid @enderror"
                                    name="location_id" id="location_id" placeholder="Location"
                                    value="{{ old('location_id') }}">
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                @error('location_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 fv-plugins-icon-container form-password-toggle">
                            <label class="form-label" for="basicDate">Auditor</label>
                            <div class="input-group input-group-merge has-validation">
                                <input type="text" class="form-control @error('auditor_id') is-invalid @enderror"
                                    name="auditor_id" id="auditor_id" placeholder="Auditor"
                                    value="{{ old('auditor_id') }}">
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                @error('auditor_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 fv-plugins-icon-container form-password-toggle">
                            <label class="form-label" for="basicDate">Department</label>
                            <div class="input-group input-group-merge has-validation">
                                <input type="tetx"
                                    class="form-control @error('departement_id') is-invalid @enderror"
                                    name="departement_id" id="departement_id" placeholder="Department"
                                    value="{{ old('departement_id') }}" aria-describedby="departement_id" />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                @error('departement_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mt-4">
                            <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">Submit</button>
                            <button type="reset" class="btn btn-outline-secondary"
                                data-bs-dismiss="offcanvas">Cancel</button>
                        </div>
                        <div></div><input type="hidden">
                    </form>

                </div>
            </div>
        </div>
        <table class="table table-hover table-sm" id="datatable" width="100%">
            <thead>
                <tr>
                    <th width="20px" data-priority="1">No</th>
                    <th width="40px">Date</th>
                    <th width="40px">Status</th>
                    <th width="40px">Auditee</th>
                    <th width="40px">Location</th>
                    <th width="40px">Auditor</th>
                    <th width="40px">Department</th>
                    <th width="40px" data-priority="3">Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
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
<script src="{{asset('assets/vendor/libs/sele`ct2/select2.js')}}"></script>
@if(session('msg'))
<script type="text/javascript">
    //swall message notification
    $(document).ready(function () {
        swal(`{!! session('msg') !!}`, {
            icon: "info",
        });
    });

</script>
@endif
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
    setTimeout(function () {
        (function ($) {
            "use strict";
            $(".select2-modal").select2({
                dropdownParent: $('#newrecord'),
                allowClear: true,
                minimumResultsForSearch: 5
            });
        })(jQuery);
    }, 350);

</script>
<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ordering: false,
            searching: true,
            language: {
                searchPlaceholder: 'Search..',
                // url: "{{asset('assets/vendor/libs/datatables/id.json')}}"
            },
            ajax: {
                url: "{{ route('audit_plan.data') }}",
                data: function (d) {
                    d.select_auditor_id = $('#select_auditor_id').val(),
                    d.search = $('#datatable_filter input[type="search"]').val()
                },
            },
            columnDefs: [{
                "defaultContent": "-",
                "targets": "_all"
            }],
            columns: [{
                    render: function (data, type, row, meta) {
                        var no = (meta.row + meta.settings._iDisplayStart + 1);
                        return no;
                    },
                    className: "text-center"
                },
                {
                    render: function (data, type, row, meta) {
                        return row.date;
                    },
                    className: "text-center"
                },
                {
                    render: function (data, type, row, meta) {

                            return row.audit_plan_status_id;
                    },
                    className: "text-center"
                },
                {
                    render: function (data, type, row, meta) {

                            return row.auditee_id;
                    },
                    className: "text-center"
                },
                {
                    render: function (data, type, row, meta) {

                            return row.location_id;
                    },
                    className: "text-center"
                },
                {
                    render: function (data, type, row, meta) {

                            return row.auditor_id;
                    },
                    className: "text-center"
                },
                {
                    render: function (data, type, row, meta) {

                            return row.departement_id;
                    },
                    className: "text-center"
                },
                {
                    render: function (data, type, row, meta) {
                        var html =
                            `<a class="btn btn-warning" style="cursor:pointer" href="{{ url('edit_prodi/') }}/${row.id}">
                            <i class="bx bx-pencil"></i></a>
                            <a class="btn btn-danger" style="cursor:pointer" onclick="DeleteId(\'` + row.id + `\',\'` + row.nama_prodi + `\')" >
                            <i class="bx bx-trash"></i></a>`;
                        return html;
                    },
                    "orderable": false,
                    className: "text-md-center"
                }

            ]
        });
    });

    function DeleteId(id) {
        swal({
                title: "Are you sure?",
                text: "Once deleted, data can't be recovered!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "",
                        type: "DELETE",
                        data: {
                            "id": id,
                            "_token": $("meta[name='csrf-token']").attr("content"),
                        },
                        success: function (data) {
                            if (data['success']) {
                                swal(data['message'], {
                                    icon: "success",
                                });
                                $('#datatable').DataTable().ajax.reload();
                            } else {
                                swal(data['message'], {
                                    icon: "error",
                                });
                            }
                        }
                    })
                }
            })
    }

</script>
@endsection
