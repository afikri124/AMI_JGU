@extends('layouts.master')
@section('title', 'Standard Category')

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
.badge-icon {
    display: inline-block;
    font-size: 1em;
    padding: 0.3em;
    margin-right: 0.1em;
}

.icon-white {
        color: #ffffff; /* Warna putih */
    }
</style>
@endsection

@section('breadcrumb-title')
<h3>@yield('title')</h3>
@endsection

@section('breadcrumb-items')
@endsection

@section('content')
<div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
        <div class="card">
            <div class="card-datatable table-responsive">
                <div class="card-header flex-column flaex-md-row pb-0">
                    <div class="row">
                        <div class="col-12 pt-3 pt-md-0">
                            <div class="col-12">
                                <div class="row">
                                    <div class="offset-md-0 col-md-0 text-md-end text-center pt-3 pt-md-0">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select id="Select_2" class="form-control input-sm select2" data-placeholder="Status">
                                    <option value="">Status</option>
                                    <option value='true'>ON</option>
                                    <option value='false'>OFF</option>
                                </select>
                            </div>
                        </div>
                    </div>
            <div class="container-fluid flex-grow-1 container-p-y">
                <table class="table" id="datatable">
                    <div class="col-md d-flex justify-content-center justify-content-md-end">
                        <a class="btn btn-primary btn-block btn-mail" title="Add new"
                            href="{{ route('standard_category.category_add')}}">
                            <i data-feather="plus"></i>+ Add
                        </a>
                    </div>
                            <thead>
                                <tr>
                                    <th scope="col" width="60px" class="text-center"><b>Code ID</b></th>
                                    <th scope="col"><b>Title</b></th>
                                    <th scope="col"><b>Description</b></th>
                                    <th scope="col"><b>Status</b></th>
                                    <th scope="col"><b>Required</b></th>
                                    <th scope="col"><b>Action</b></th>
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
<script src="{{asset('assets/vendor/libs/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/datatables-buttons.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/buttons.bootstrap5.js')}}"></script>
<script src="{{asset('assets/js/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/js/sweet-alert/sweetalert.min.js')}}"></script>
@if(session('msg'))
<script type="text/javascript">
    //swall message notification
    $(document).ready(function () {
        swal(`{!! session('msg') !!}`, {
            icon: 'success',
            customClass: {
                confirmButton: 'btn btn-success'
            }
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
                url: "{{ route('standard_category.data') }}",
                data: function (d) {
                    d.search = $('input[type="search"]').val(),
                    d.status = $('#Select_2').val()
                },
            },
                columns: [{
                    render: function (data, type, row, meta) {
                        console.log(row);
                        var x = row.id.toString();
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
                            var x = '<span class="badge rounded-pill bg-success">ON</span>';
                        } else {
                            var x = '<span class="badge rounded-pill bg-danger">OFF</span>';
                        }
                        return x;
                    },
                    className: "text-center"
                },
                {
                    render: function (data, type, row, meta) {
                        var x = "";
                        if (row.is_required) {
                            x = '<i class="bx bx-check text-warning"></i>';
                        }
                        else{
                            x = '<i class="bx bx-x text-danger"></i>';
                        }
                        return x;
                    },
                    className: "text-center"
                },
                {
                    render: function(data, type, row, meta) {
                        var html =
                            `<a class="badge bg-warning badge-icon" title="Edit" style="cursor:pointer" href="{{ url('setting/manage_standard/category/category_edit/') }}/${row.id}">
                            <i class="bx bx-pencil"></i></a>
                            <a class="badge bg-danger badge-icon" title="Hapus" style="cursor:pointer"
                            onclick="DeleteId(\'` + row.id + `\',\'` + row.description + `\')" >
                            <i class="bx bx-trash icon-white"></i></a>`;
                        return html;
                    },
                    "orderable": false,
                    className: "text-end"
                }
            ]
        });
        $('#Select_2').change(function () {
            table.draw();
        });
    });


    function DeleteId(id, data) {
        swal({
                title: "Apa kamu yakin?",
                text: "Setelah dihapus, data ("+data+") tidak dapat dipulihkan!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "{{ route('standard_category.delete') }}",
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
