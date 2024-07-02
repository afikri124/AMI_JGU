@extends('layouts.master')
@section('content')
@section('title', 'Observations')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/sweetalert2.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />

@endsection

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
                        </div>
                    </div>
                </div>
                <div class="container">
                    <table class="table table-hover table-sm" id="datatable" width="100%">
                        <thead>
                            <tr>
                                <th><b>No</b></th>
                                <th><b>Lecture</b></th>
                                <th><b>Date Start</b></th>
                                <th><b>Date End</b></th>
                                <th><b>Status</b></th>
                                <th><b>Doc</b></th>
                                <th><b>Action</b></th>
                            </tr>
                        </thead>
                    </table>
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
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/locale/id.js"></script> <!-- Memuat lokal Indonesia untuk moment.js -->
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

<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ordering: false,
            language: {
                searchPlaceholder: 'Search data..'
            },
            ajax: {
                url: "{{ route('observations.data') }}",
                data: function (d) {
                    d.search = $('input[type="search"]').val()
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
                        var html = `<a class="text-primary" title="` + row.lecture.name +
                            `" href="">` + row.lecture.name + `</a>`;
                        return html;
                    },
                },
                {
                    render: function (data, type, row, meta) {
                        // Menggunakan moment.js untuk memformat tanggal
                        return moment(row.date_start).format('DD MMMM YYYY, HH:mm'); // Misalnya, "01 Januari 2024, 14:30"
                    },
                },
                {
                    render: function (data, type, row, meta) {
                        // Menggunakan moment.js untuk memformat tanggal
                        return moment(row.date_end).format('DD MMMM YYYY, HH:mm'); // Misalnya, "05 Januari 2024, 09:45"
                    },
                },
                {
                    render: function(data, type, row, meta) {
                        var html =
                            `<span class="badge bg-${row.auditstatus.color}">${row.auditstatus.title}</span>`;
                        return html;
                    }
                },
                {
                    render: function (data, type, row, meta) {
                        var x = "";
                        if (row.doc_path != null) {
                            x += `<a class="text-warning" title="Documents" target="_blank" href="{{ url('` + row.doc_path + `') }}"><i class="bx bx-file"></i></a> `;
                        }
                        if (row.link != null) {
                            x += `<a class="text-primary" title="Link Drive" target="_blank" href="` + row.link + `"><i class="bx bx-link"></i></a>`;
                        }
                        return x;
                    },
                },
                {
                        render: function(data, type, row, meta) {
                            var html =
                                `<a class="text-warning" title="Remark Doc" href="{{ url('observations/edit/${row.id}') }}">
                                <i class="bx bx-pencil"></i></a>
                                <a class="text-danger bx-sm px-1" title="Observation" style="cursor:pointer" href="{{ url('observations/make/') }}/${row.id}">
                                <i class="bx bx-plus"></i></a>`
                            return html;
                        },
                        "orderable": false,
                        className: "text-md-center"
                    }
            ]
        });
    });

    function approveId(id, data) {
        swal({
                title: "Cek kembali document!",
                text: "Apakah document ("+data+") sudah sesuai?!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willApprove) => {
                if (willApprove) {
                    $.ajax({
                        url: "{{ route('audit_plan.approve') }}",
                        type: "POST",
                        data: {
                            "id": id,
                            "_token": $("meta[name='csrf-token']").attr("content"),
                        },
                        success: function(response) {
                            if (response.success) {
                                swal({
                                    icon: 'success',
                                    title: 'Acc!',
                                    text: 'Document ('+data+') berhasil di Acc',
                                    customClass: {
                                        confirmButton: 'btn btn-success'
                                    }
                                });
                                $('#datatable').DataTable().ajax.reload();
                            } else {
                                swal({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: data.error,
                                    customClass: {
                                        confirmButton: 'btn btn-danger'
                                    }
                                });
                            }
                        }
                    })
                }
            })
    }

    function revisedId(id, data) {
        swal({
                title: "Apa kamu yakin?",
                text: "Periksa kembali, apakah data ("+data+") kurang sesuai?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willRevised) => {
                if (willRevised) {
                    $.ajax({
                        url: "{{ route('audit_plan.revised') }}",
                        type: "POST",
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
