@extends('layouts.master')
@section('content')
@section('title', 'My Audit')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/sweetalert2.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
@endsection

<style>
    .modal-header .modal-title {
            font-weight: normal; /* Ensure the modal title is not bold */
    }
    .modal-body {
        font-weight: normal; /* Ensure modal body text is not bold */
    }
    .modal-footer {
        font-weight: normal; /* Ensure modal footer text is not bold */
    }
    body, h1, h2, h3, h4, h5, h6, p, span, a, div {
        font-weight: normal; /* Ensure these elements are not bold */
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
    table.dataTable tbody tr {
        height: 50px; /* Adjust the height as needed */
    }
    /* Increase padding for table cells */
    table.dataTable tbody td {
        padding: 0.6rem; /* Adjust padding for more space within cells */
        vertical-align: middle; /* Vertically align text */
    }
    /* Optional: Adjust font size if necessary */
    table.dataTable tbody td, table.dataTable tbody th {
        font-size: 0.97rem; /* Increase font size if the text appears too small */
    }
    table.dataTable td {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    }

    .close {
            font-size: 1.5rem; /* Adjust font size as needed */
            padding: 0.5rem;  /* Adjust padding to increase button size */
        }
</style>

<div class="row">
    <div class="card">
        <div class="card-datatable table-responsive">
            <div class="card-header flex-column flaex-md-row pb-0">
                    <div class="col-12 pt-3 pt-md-0">
                        <div class="col-12">
                        <div class="row">
                            <div class="offset-md-0 col-md-0 text-md-end text-center pt-3 pt-md-0">
                            </div>
                        <div class="container-xxl flex-grow-1 container-p-y">
                        <table class="table table-hover table-sm" id="datatable" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" data-priority="1" width="20px">No</th>
                                    <th scope="col" data-priority="2">Auditee</th>
                                    <th scope="col">Schedule</th>
                                    <th scope="col" data-priority="4">Location</th>
                                    <th scope="col">Auditor</th>
                                    <th scope="col">Status</th>
                                    <!-- <th scope="col">Doc.</th> -->
                                    <th scope="col" data-priority="3" width="65px">Action</th>
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
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/locale/id.js"></script>
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
                url: "{{ route('my_audit.data') }}",
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
                        var html = `<a class="text-primary" title="` + row.auditee.name +
                            `" href="{{ url('setting/manage_account/users/edit/` +
                            row.idd + `') }}" style="display: block; margin-bottom: 0.1em;">` + row.auditee.name + `</a>`;

                        if (row.auditee.no_phone) {
                            html += `<a href="tel:` + row.auditee.no_phone + `" class="text-muted" style="font-size: 0.8em;">` +
                                    `<i class="fas fa-phone-alt"></i> ` + row.auditee.no_phone + `</a>`;
                        }
                        return html;
                    },
                },
                {
                    data: null,  // Kita akan menggabungkan date_start dan date_end, jadi tidak ada sumber data spesifik
                    render: function (data, type, row, meta) {
                        // Menggunakan moment.js untuk memformat tanggal
                        var formattedStartDate = moment(row.date_start).format('DD MMMM YYYY, HH:mm');
                        var formattedEndDate = moment(row.date_end).format('DD MMMM YYYY, HH:mm');
                        return formattedStartDate + ' - ' + formattedEndDate;
                    }
                },
                {
                    render: function (data, type, row, meta) {

                            return row.location;
                    },
                },
                {
                    render: function (data, type, row, meta) {
                        var html = '';
                        if (row.auditor) {
                            row.auditor.forEach(function (auditor) {
                                if (auditor.auditor) {
                                    html += `<code><span title="` + auditor.auditor.name +
                                        `" style="font-size: 1.2em;">` + auditor.auditor.name + `</span></code><br>`;

                                    if (auditor.auditor.no_phone) {
                                        html += `<a href="tel:` + auditor.auditor.no_phone + `" class="text-muted" style="font-size: 0.8em;">` +
                                                `<i class="fas fa-phone-alt"></i> ` + auditor.auditor.no_phone + `</a><br>`;
                                    }
                                }
                            });
                        }
                        return html;
                    },
                },
                {
                    render: function(data, type, row, meta) {
                        var html =
                            `<span class="badge bg-${row.auditstatus.color}">${row.auditstatus.title}</span>`;
                        return html;
                    }
                },
                // {
                //     render: function (data, type, row, meta) {
                //         var x = "";
                //         if (row.doc_path != null && row.doc_path != "") {
                //             x += `<a class="text-dark" title="Documents" target="_blank" href="{{ url('` + row.doc_path + `') }}"><i class="bx bx-file"></i></a> `;
                //         }
                //         if (row.link != null) {
                //             x += `<a class="text-primary" title="Link Drive" target="_blank" href="` + row.link + `"><i class="bx bx-link"></i></a>`;
                //         }
                //         return x;
                //     },
                // },
                {
                    render: function(data, type, row, meta) {
                        var x = '';

                        // Check if auditstatus is '1' or '2'
                        if (row.auditstatus.id === 4) {
                            x = `<a class="badge bg-warning" title="My Determine Standard" href="{{ url('my_audit/my_standard/${row.id}') }}">
                            <i class="bx bx-pencil"></i></a>`;
                        }
                        // Check if auditstatus is '10'
                        else if (row.auditstatus.id === 3) {
                            x = `<a class="badge bg-primary" title="Auditing" href="{{ url('my_audit/show/${row.id}') }}">
                                    <i class="bx bx-search-alt"></i></a>
                                <a class="badge bg-dark" title="My Audit Remark" href="{{ url('my_audit/my_standard/${row.id}') }}">
                                    <i class="bx bx-show"></i></a>`;
                        }
                        else if (row.auditstatus.id === 6 || row.auditstatus.id === 14 ) {
                            x = `<a class="badge bg-primary" title="Print Make Report" href="{{ url('/view/${row.id}') }}">
                                    <i class="bx bx-printer"></i></a>`;
                        }
                        else if (row.auditstatus.id === 10 || row.auditstatus.id === 9) {
                            x = `<a class="badge bg-primary" title="Print Make Report" href="{{ url('my_audit/obs/${row.id}') }}">
                                    <i class="bx bx-printer"></i></a>
                                <a class="badge bg-warning" title="Edit RTM Report" href="{{ url('my_audit/edit_rtm/${row.id}') }}">
                                    <i class="bx bx-pencil"></i></a>`;
                        }
                        return x;
                    },
                    "orderable": false,
                    className: "text-md-center"
                }
            ]
        });
    });
</script>
@endsection
