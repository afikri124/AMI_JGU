@extends('layouts.master')
@section('breadcrumb-items')
<span class="text-muted fw-light">Setting /</span>
<span class="text-muted fw-light">Manage Standard /</span>
@endsection
@section('title', 'Standard')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/select2.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/date-picker.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/datatables.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/datatable-extension.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/sweetalert2.css')}}">
@endsection

@section('style')

@endsection


@section('breadcrumb-items')
<li class="breadcrumb-item">Settings</li>
<li class="breadcrumb-item active">@yield('title')</li>
@endsection

@section('content')
<div class="card">
    <div class="card-datatable table-responsive">
        <div class="card-header flex-column flex-md-row pb-0">
            <div class="row">
                <div class="col-12 pt-3 pt-md-0">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-3">
                                <select id="select_gender" class="select2 form-select" data-placeholder="Gender">
                                    <option value="">Status</option>
                                    <option value="ON">ON</option>
                                    <option value="OFF">OFF</option>
                                </select>
                            </div>
                            <div class="offset-m-2 text-md-end text-center ">
                                <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
                                    data-bs-target="#newrecord" aria-controls="offcanvasEnd" tabindex="0"
                                    aria-controls="DataTables_Table_0" type="button" title="Add new" href="{{ route('standar.add_standar')}}"><span><i
                                            class="bx bx-plus me-sm-2"></i>
                                        <span>Add</span></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="col-sm-12">
                <div class="card-body">
                    <div class="row">
                        <table class="table table-hover table-sm" id="datatable" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" width="60px" class="text-center">Code ID</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Description</th>
                                    <th scope="col" width="50px">Status</th>
                                    <th scope="col" width="50px">Required</th>
                                    <th scope="col" width="65px">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{asset('assets/js/datepicker/date-picker/datepicker.js')}}"></script>
<script src="{{asset('assets/js/datepicker/date-picker/datepicker.en.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable-extension/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/js/select2/select2.full.min.js')}}"></script>
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
    $(document).ready(function () {
        var table = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ordering: false,
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '_INPUT_ &nbsp;',
                lengthMenu: '<span>Show:</span> _MENU_',
            },
            ajax: {
                url: "",
                data: function (d) {
                    d.status = $('#Select_2').val(),
                    d.search = $('input[type="search"]').val()
                },
            },
            columns: [{
                    render: function (data, type, row, meta) {
                        var x = '<code>' + row.id + '</code>';
                        return x;
                    },
                    className: "text-center"
                },
                {
                    render: function (data, type, row, meta) {
                        return row.title;
                    },
                },
                {
                    render: function (data, type, row, meta) {
                        return row.description;
                    },
                },
                {
                    render: function (data, type, row, meta) {
                        if(row.status == 1){
                            var x = '<span class="badge rounded-pill badge-success">ON</span>';
                        } else {
                            var x = '<span class="badge rounded-pill badge-danger">OFF</span>';
                        }
                        return x;
                    },
                    className: "text-center"
                },
                {
                    render: function (data, type, row, meta) {
                        var x = "";
                        if (row.is_required == true) {
                            x = '<i class="fa fa-check"></i>';
                        }
                        return x;
                    },
                    className: "text-center"
                },
                {
                    render: function (data, type, row, meta) {
                        var x = row.id;
                        var html =
                            `<a class="btn btn-success btn-sm px-2" title="Edit" href="{{ url('settings/category/edit/` +
                            x +
                            `') }}"><i class="fa fa-pencil-square-o"></i></a> <a class="btn btn-danger btn-sm px-2" title="Delete" onclick="DeleteId('` +
                            x + `')" ><i class="fa fa-trash"></i></a>`;
                        return html;
                    },
                    orderable: false,
                    className: "text-end"
                }
            ]
        });
        $('#Select_2').change(function () {
            table.draw();
        });
    });


    function DeleteId(id) {
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this!",
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
