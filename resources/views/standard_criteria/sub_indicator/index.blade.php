@extends('layouts.master')
@section('title', 'Sub Indicator')

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
        <li class="nav-item"><a class="nav-link" href="{{ route('standard_criteria.criteria') }}"><i
                        class="bx bx-add-to-queue me-1"></i>
                    Data Standard</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('standard_criteria.indicator') }}"><i
                        class="bx bx-chart me-1"></i>
                    Indicator</a></li>
        <li class="nav-item"><a class="nav-link active" href="{{ route('standard_criteria.sub_indicator') }}"><i
                        class="bx bx-bar-chart-alt-2 me-1"></i>
                    Sub Indicator</a></li>
        </ul>
    </div>

<div class="card">
    <div class="card-datatable table-responsive">
        <div class="card-header flex-column flex-md-row pb-0">
            <!-- <div class="row">
                <div class="col-12 pt-3 pt-md-0">
                    <div class="col-12"> -->
                        <div class="row">
                        <div class="col-md-4">
                            <select id="select_indicator" class="form-control input-sm select2" data-placeholder="Indicator">
                                <option value="">Select Indicator</option>
                                @foreach($indicator as $d)
                                <option value="{{ $d->id }}">{{ $d->id }} {{ $d->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md d-flex justify-content-center justify-content-md-end">
                            <a class="btn btn-primary btn-block btn-mail" title="Add Sub Indicator"
                                href="{{ route('standard_criteria.sub_indicator.create')}}">
                                <i data-feather="plus"></i>+ Add
                            </a>
                        </div>

        <table class="table table-hover table-sm" id="datatable" width="100%">
            <thead>
                <tr>
                    <th width="20px">No</th>
                    <th>Sub Indicator</th>
                    <th>Indicator</th>
                    <th width="40px">Action</th>
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
                url: "{{ route('standard_criteria.data_sub') }}",
                data: function (d) {
                    d.search = $('input[type="search"]').val(),
                    d.select_indicator = $('#select_indicator').val()
                },
            },
            columns: [{
                    render: function (data, type, row, meta) {
                        var no = (meta.row + meta.settings._iDisplayStart + 1);
                        return no;
                    },
                    orderable: false,

                },
                {
                    render: function (data, type, row, meta) {
                        data = "";
                        // if (row.name != null) {
                        //     data = "<span class='badge bg-label-danger'>" + row.data.date + "</span> <strong title='" + row.data.title + "'>" + row.data.title +
                        //         "</strong><br>";
                        // }
                        return data + $("<textarea/>").html(row.name).text();
                    },
                    // render: function (data, type, row, meta) {
                    //     return $('<code>' + row.name + '</code>');
                    // },
                },
                {
                    render: function (data, type, row, meta) {
                        var x = row.indicator.name;
                        return x;
                    },
                },
                {
                    render: function (data, type, row, meta) {
                        var x = row.id;
                        var html =
                            `<a class="text-warning" title="Edit Sub Indicator" style="cursor:pointer"
                            href="{{ url('setting/manage_standard/criteria/edit_sub/sub_indicator/') }}/${row.id}">
                            <i class="bx bx-pencil"></i></a>

                            <a class="text-primary" title="Delete Sub Indicator" style="cursor:pointer"
                            onclick="DeleteId(\'` + row.id + `\',\'` + row.name + `\')" >
                            <i class='bx bxs-trash'></i></a>`;
                        return html;
                    },
                    orderable: false,
                    className: "text-end"
                }
            ]
        });
        $('#select_indicator').change(function () {
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
                        url: "{{ route('delete_sub.sub_indicator') }}",
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
