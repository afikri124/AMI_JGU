@extends('layouts.master')
@section('breadcrumb-items')
@endsection
@section('title', 'Notification Audit Plan')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-icons-1.11.3/font/bootstrap-icons.css') }}">
@endsection

@section('style')
    <style>
        table.dataTable tbody td {
            vertical-align: middle;
        }

        table.dataTable td:nth-child(2) {
            max-width: 150px;
        }

        table.dataTable td {
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
            word-wrap: break-word;
        }

        .content-wrapper {
            display: flex;
            align-items: stretch;
            flex: 1 1 auto;
            flex-direction: column;
            justify-content: space-between;
        }

        .teks {
            width: 500px;
            /* Lebar maksimum */
            word-wrap: break-word;
        }
    </style>
@endsection

@section('content')
    @if (session('msg'))
        <div class="alert alert-primary alert-dismissible" role="alert">
            {{ session('msg') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-lg-12 mb-2 order-0">
                    <div class="card">
                        <div class="d-flex align-items-end row">
                            <div class="col-sm-1">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Total Revenue -->
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
                                <div class="offcanvas offcanvas-end @if ($errors->all()) show @endif"
                                    tabindex="-1" id="newrecord" aria-labelledby="offcanvasEndLabel">
                                    <div class="offcanvas-header">
                                        <h6 id="offcanvasEndLabel" class="offcanvas-title">Upload Document</h6>
                                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="offcanvas-body my-auto mx-0 flex-grow-1">
                                        <form class="add-new-record pt-0 row g-2 fv-plugins-bootstrap5 fv-plugins-framework"
                                            id="form-add-new-record" method="POST" action=""
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="col-sm-12 fv-plugins-icon-container">
                                                <label class="form-label" for="title">Title</label>
                                                <div class="input-group input-group-merge has-validation">
                                                    <input type="text"
                                                        class="form-control @error('title') is-invalid @enderror"
                                                        name="title" placeholder="Input your title"
                                                        value="{{ old('title') }}">
                                                    @error('title')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-12 fv-plugins-icon-container">
                                                <label class="form-label" for="basicDate">Date</label>
                                                <div class="input-group input-group-merge has-validation">
                                                    <input type="date"
                                                        class="form-control @error('date') is-invalid @enderror"
                                                        name="date" placeholder="yyyy-mm-dd"
                                                        value="{{ old('date') }}">
                                                    @error('date')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <label class="form-label">Upload Images<i class="text-danger">*</i></label>
                                                <div class="input-group mb-3">
                                                    <input class="form-control @error('file_path') is-invalid @enderror"
                                                        name="file_path" type="file" accept=".jpg, .jpeg, .png"
                                                        title="JPG/PNG">
                                                    @error('file_path')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-12 fv-plugins-icon-container">
                                                <label class="form-label" for="basicDate">Description</label>
                                                <div class="input-group input-group-merge has-validation">
                                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"
                                                        placeholder="Input your description">{{ old('description') }}</textarea>
                                                    @error('description')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-12 mt-4">
                                                <button type="submit"
                                                    class="btn btn-primary data-submit me-sm-3 me-1">Submit</button>
                                                <button type="reset" class="btn btn-outline-secondary"
                                                    data-bs-dismiss="offcanvas">Batal</button>
                                            </div>
                                            <br>
                                            <span class="invalid-feedback" role="alert"><br>
                                                <strong>Rasio 1:1</strong> <br>
                                                <strong>Img Size Max 5mb</strong>
                                            </span>
                                            <div></div><input type="hidden">
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="container">
                            <table class="table table-hover table-sm" id="datatable" width="100%">
                                <thead>
                                    <tr>
                                        <th width="10px">No</th>
                                        <th width="60px">Date</th>
                                        <th width="60px">Status</th>
                                        <th width="60px">Auditor</th>
                                        <th width="60px">Doc</th>
                                        <th width="40px">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    @foreach ($notification_audits as $anc)
        <div class="modal fade" id="modalToggle" aria-labelledby="modalToggleLabel" tabindex="-1"
            style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalToggleLabel">{{ $anc->title }}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img src="{{ asset($anc->file_path) }}" class="img-fluid" alt="" width="500px"
                            height="500px">
                        <h5 class="text-truncate"></h5>
                        <p class="teks">{{ $anc->description }}</p>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
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
    @if (session('msg'))
        <script type="text/javascript">
            //swall message notification
            $(document).ready(function() {
                swal(`{!! session('msg') !!}`, {
                    icon: "info",
                });
            });
        </script>
    @endif
    <script>
        "use strict";
        setTimeout(function() {
            (function($) {
                "use strict";
                $(".select2").select2({
                    allowClear: true,
                    minimumResultsForSearch: 7
                });
            })(jQuery);
        }, 350);
        setTimeout(function() {
            (function($) {
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
        $(document).ready(function() {
            var table = $('#datatable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ordering: false,
                searching: true,
                language: {
                    searchPlaceholder: 'Search..',
                    // url: "{{ asset('assets/vendor/libs/datatables/id.json') }}"
                },
                ajax: {
                    url: "{{ route('notification.data') }}",
                    data: function(d) {
                        d.search = $('#datatable_filter input[type="search"]').val()
                    },
                },
                columnDefs: [{
                    "defaultContent": "-",
                    "targets": "_all"
                }],
                columns: [{
                        render: function(data, type, row, meta) {
                            var no = (meta.row + meta.settings._iDisplayStart + 1);
                            return no;
                        },
                        className: "text-center"
                    },
                    {
                        render: function(data, type, row, meta) {
                            var html = row.title;
                            return html;
                        }
                    },
                    {
                        render: function(data, type, row, meta) {
                            var html = row.date;
                            return html;
                        }
                    },
                    {
                        render: function(data, type, row, meta) {
                            var html = row.file_path;
                            return html;
                        }
                    },
                    {
                        render: function(data, type, row, meta) {
                            var html =
                                `<a href="#modalToggle" data-bs-toggle="modal" data-bs-target="#modalToggle" class="bx bx-show-alt badge-dark"></a>
                                <a class=" text-success" title="Edit" href="{{ url('announcements/edit/` + row.id + `') }}"><i class="bx bxs-edit"></i></a>
                            <a class=" text-danger" title="Hapus" style="cursor:pointer" onclick="DeleteId(\'` + row
                                .id + `\',\'` + row.name + `\')" ><i class="bx bx-trash"></i></a>`;
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
                            url: "{{ route('notification.delete') }}",
                            type: "DELETE",
                            data: {
                                "id": id,
                                "_token": $("meta[name='csrf-token']").attr("content"),
                            },
                            success: function(data) {
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
