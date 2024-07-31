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
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <table class="table table-hover table-sm" id="datatable" width="100%">
                        <thead>
                            <tr>
                                <th width="5%"><b>No</b></th>
                                <th width="15%"><b>Auditee</b></th>
                                <th width="25%"><b>Schedule</b></th>
                                <th width="10%"><b>Location</b></th>
                                <th width="5%"><b>Auditor</b></th>
                                <th width="10%"><b>Status</b></th>
                                <th width="5%"><b>Doc</b></th>
                                <th width="10%"><b>Action</b></th>
                            </tr>
                        </thead>
                    </table>
                </div>

<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel"><b>Have you uploaded the following drive link?</b></h4>
                <a href="" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="link"><b>Link Drive</b></label>
                    <br>
                    <a id="modal-link" href="#" target="_blank"></a>
                </div>
                <form id="upload-form" method="POST" action="" enctype="multipart/form-data" style="display: inline;">
                    @csrf
                    @method('PUT')
                    <!-- <div class="form-group mb-3">
                        <label for="doc_path" class="form-label large-text"></b><b>Upload Document</label>
                        <input type="file" class="form-control" id="doc_path" name="doc_path" accept=".pdf">
                    </div> -->
                    <div class="form-group mb-3">
                        <label for="remark_docs" class="form-label large-text"><b>Remark By Auditor</b></label>
                        <textarea class="form-control" id="modal-remark_docs" name="remark_docs" rows="3" readonly></textarea>
                    </div>
                    <div class="text-end" id="button-container">
                        <button class="btn btn-primary me-1" type="submit">Done</button>
                    </form>
                        <!-- <form id="reupload-form" action="" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="audit_status_id">
                            <button class="btn btn-primary" type="submit">Reupload</button>
                        </form> -->

                        <a href="">
                            <span class="btn btn-outline-secondary">Back</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
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
                {
                    render: function (data, type, row, meta) {
                        var x = "";
                        if (row.doc_path != null && row.doc_path != "") {
                            x += `<a class="text-dark" title="Documents" target="_blank" href="{{ url('` + row.doc_path + `') }}"><i class="bx bx-file"></i></a> `;
                        }
                        if (row.link != null) {
                            x += `<a class="text-primary" title="Link Drive" target="_blank" href="` + row.link + `"><i class="bx bx-link"></i></a>`;
                        }
                        return x;
                    },
                },
                {
                    render: function(data, type, row, meta) {
                        var x = '';

                        // Check if auditstatus is '1' or '2'
                        if (row.auditstatus.id === 1 || row.auditstatus.id === 2) {
                            x = `<a class="badge bg-warning badge-icon" title="Remark Document" data-id="${row.id}"
                            data-link="${row.link}" data-remark_docs="${row.remark_docs}" onclick="showModal(this)" style="cursor:pointer">
                            <i class="bx bx-pencil icon-white"></i></a>`;
                        }
                        // Check if auditstatus is '10'
                        else if (row.auditstatus.id === 3 || row.auditstatus.id === 10 ) {
                            x = `<a class="badge bg-dark" title="Observations" href="{{ url('my_audit/obs/${row.id}') }}">
                                    <i class="bx bx-search-alt"></i></a>
                                <a class="badge bg-warning badge-icon" title="Remark Document" data-id="${row.id}"
                                    data-link="${row.link}" data-remark_docs="${row.remark_docs}" onclick="showModal(this)" style="cursor:pointer">
                                    <i class="bx bx-pencil icon-white"></i></a`;
                        }
                        else if (row.auditstatus.id === 4 ) {
                            x = `<a class="badge bg-primary" title="Print Make Report" href="{{ url('my_audit/obs/${row.id}') }}">
                                    <i class="bx bx-printer"></i></a>`;
                        }
                        return x;
                    },
                    "orderable": false,
                    className: "text-md-center"
                }
            ]
        });
    });

    function showModal(element) {
        var id = $(element).data('id');
        var link = $(element).data('link');
        var remark_docs = $(element).data('remark_docs');
        $('#modal-link').text(link).attr('href', link);
        $('#modal-remark_docs').text(remark_docs).attr('href', remark_docs);
        $('#upload-form').attr('action', '/my_audit/update/' + id);
        $('#uploadModal').modal('show');
    }

    // document.addEventListener('DOMContentLoaded', function() {
    //     const auditStatusId = document.getElementById('audit_status_id').value;
    //     const doneButton = document.getElementById('done-button');
    //     const reuploadButton = document.getElementById('reupload-button');

    //     if (auditStatusId == '1') {
    //         doneButton.style.display = 'inline-block';
    //     } else if (auditStatusId == '3') {
    //         reuploadButton.style.display = 'inline-block';
    //     }
    // });

</script>
@endsection

<!-- Modal Lihat Link -->
