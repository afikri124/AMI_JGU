@extends('layouts.master')
@section('title', 'Standard Criteria')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/sweetalert2.css')}}">
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

    .badge-icon {
        display: inline-block;
        font-size: 1em;
        padding: 0.4em;
        margin-right: 0.1em;
    }

    .icon-white
    {
        color: white;
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
        <li class="nav-item"><a class="nav-link active" href="{{ route('standard_criteria.criteria') }}"><i
                        class="bx bx-add-to-queue me-1"></i>
                    Data Standard</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('standard_criteria.standard_statement') }}"><i
                        class="bx bx-chart me-1"></i>
                    Standard Statement</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('standard_criteria.indicator.index') }}"><i
                        class="bx bx-bar-chart-alt-2 me-1"></i>
                    Indicator</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route ('standard_criteria.review_docs')}}"><i
                        class="bx bx-folder-open me-1"></i>
                    Review Document</a></li>
        </ul>
    </div>

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
                        <div class="row">
                        <div class="col-md-4">
                            <select id="select_category" class="form-control input-sm select2" data-placeholder="Category">
                                <option value="">Select Category</option>
                                @foreach($category as $d)
                                <option value="{{ $d->id }}">{{$d->id}} - {{ $d->description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select id="select2" class="form-control input-sm select2" data-placeholder="Status">
                                <option value="">Status</option>
                                <option value='true'>ON</option>
                                <option value='false'>OFF</option>
                            </select>
                        </div>
                        </div>
                        <div class="container-fluid">
                            <div class="col-md d-flex justify-content-center justify-content-md-end">
                                <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
                                    data-bs-target="#newrecord" aria-controls="offcanvasEnd" tabindex="0"
                                    aria-controls="DataTables_Table_0" title="Add Standard Criteria" type="button"><span><i
                                            class="bx bx-plus me-sm-2"></i>
                                        <span>Add</span></span>
                                </button>
                            </div>

            <div class="offcanvas offcanvas-end @if($errors->all()) show @endif" tabindex="-1" id="newrecord"
                aria-labelledby="offcanvasEndLabel">
                <div class="offcanvas-header">
                    <h5 id="offcanvasEndLabel" class="offcanvas-title">Add Criteria</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body my-auto mx-0 flex-grow-1">
                    <form class="add-new-record pt-0 row g-2 fv-plugins-bootstrap5 fv-plugins-framework"
                        id="form-add-new-record" method="POST" action="">
                        @csrf
                        <div class="col-sm-12 fv-plugins-icon-container">
                            <label class="form-label" for="basicDate">Title<i class="text-danger">*</i></label>
                            <div class="input-group input-group-merge has-validation">
                                <input type="text" class="form-control @error('title')  is-invalid @enderror" maxlength="120"
                                    name="title" placeholder="Input The New Criteria" value="{{ old('title') }}">
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 fv-plugins-icon-container">
                            <label class="form-label" for="basicDate">Category<i class="text-danger">*</i></label>
                            <div class="input-group input-group-merge has-validation">
                                <select class="form-select @error('standard_category_id') is-invalid @enderror  input-sm select2-modal"
                                    name="standard_category_id" id="standard_category_id">
                                    @foreach($category as $p)
                                    <option value="{{ $p->id }}"
                                        {{ ($p->id==old('standard_category_id') ? "selected": "") }}>
                                        {{ $p->id }} - {{ $p->description }}</option>
                                    @endforeach
                                </select>
                                @error('standard_category_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mt-4">
                            <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">Create</button>
                            <button type="reset" class="btn btn-outline-secondary"
                                data-bs-dismiss="offcanvas">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <table class="table table-hover table-sm" id="datatable" width="100%">
            <thead>
                <tr>
                    <th width="5%"><b>No</b></th>
                    <th><b>Criteria</b></th>
                    <th width="30%"><b>Category</b></th>
                    <th width="2%"><b>Status</b></th>
                    <th width="15%"><b>Action</b></th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@section('script')
<script src="{{asset('assets/vendor/libs/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/datatables-buttons.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/buttons.bootstrap5.js')}}"></script>
<script src="{{asset('assets/js/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
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
    // setTimeout(function () {
    //     (function ($) {
    //         "use strict";
    //         $(".select2-modal").select2({
    //             dropdownParent: $('#newrecord'),
    //             allowClear: true,
    //             minimumResultsForSearch: 5
    //         });
    //     })(jQuery);
    // }, 350);
</script>
<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ordering: true,
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '_INPUT_ &nbsp;',
                lengthMenu: '<span>Show:</span> _MENU_',
            },
            ajax: {
                url: "{{ route('standard_criteria.data') }}",
                data: function (d) {
                    d.search = $('input[type="search"]').val(),
                    d.status = $('#select2').val(),
                    d.select_category = $('#select_category').val()
                },
            },
            columns: [{
                render: function (data, type, row, meta) {
                        var no = row.id;
                        return no;
                    },
                },
                {
                    render: function (data, type, row, meta) {
                        var x = row.title;
                        return x;
                    },
                },
                {
                    render: function (data, type, row, meta) {
                    // Check if row.category exists and has an id
                    if (row.category && row.category.id) {
                        var html = `<a class="text-info" title="${row.category.description}" href="">${row.category.description}</a>`;
                        return html;
                    } else {
                        return ''; // Return empty string or handle the case where category.title is missing
                    }
                },
                className: "text-center"
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
                        var x = row.id;
                        var html =
                            `<a class="badge bg-warning badge-icon" title="Edit Criteria" style="cursor:pointer" href="{{ url('setting/manage_standard/criteria/criteria_edit/') }}/${row.id}"><i class='bx bx-pencil'></i></href=>
                            <a class="badge bg-danger badge-icon" title="Delete" style="cursor:pointer" onclick="DeleteId(\'` + row.id + `\',\'` + row.title + `\')" ><i class="bx bx-trash icon-white"></i></a>`;
                        return html;
                    },
                    orderable: true,
                    className: "text-end"
                }
            ]
        });
        $('#select_category').change(function () {
            table.draw();
        });
        $('#select2').change(function () {
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
                        url: "{{ route('standard_criteria.delete') }}",
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
