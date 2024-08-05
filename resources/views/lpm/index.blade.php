@extends('layouts.master')
@section('content')
@section('title', 'LPM')

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
                                <!-- <th width="5%"><b>Doc</b></th> -->
                                <th width="10%"><b>Action</b></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel"><b>Remark Make Report By LPM </b></h4>
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
                <form id="upload-form" method="POST" action="" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="validate_by_lpm" class="form-label large-text"><b>Tanggal Approve</b></label>
                        <input type="date" class="form-control" id="modal-validate_by_lpm" name="validate_by_lpm"></input>
                    </div>
                    <div class="form-group mb-3">
                        <label for="remark_by_lpm" class="form-label large-text"><b>Remark By Auditor</b></label>
                        <textarea class="form-control" id="modal-remark_by_lpm" name="remark_by_lpm" rows="3" placeholder="MAX 250 characters..."></textarea>
                        <i class="text-danger"><b>* Please give comments and suggestions from the make report results</b></i>
                    </div>
                    <div class="text-end">
                        <button class="btn btn-primary me-1" type="submit">Submit</button>
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
                url: "{{ route('lpm.approve_data') }}",
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
                        if (row.auditstatus.id === 6) {
                            x = `<a class="badge bg-dark" title="Print Make Report By LPM" href="{{ url('lpm/lpm_edit/${row.id}') }}">
                                    <i class="bx bx-printer"></i></a>
                                <a class="badge bg-warning badge-icon" title="Approve Make Report By LPM" style="cursor:pointer" onclick="approveId(\'` + row.id + `\',\'` + row.auditee.name + `\')" >
                                    <i class="bx bx-check icon-white"></i></a>
                                <a class="badge bg-danger badge-icon" title="Remark Make Report By LPM" data-id="${row.id}"
                                     data-link="${row.link}" data-remark_by_lpm="${row.remark_by_lpm}" data-validate_by_lpm="${row.validate_by_lpm}" onclick="showModal(this)" style="cursor:pointer">
                                    <i class="bx bx-x icon-white"></i></a>`;
                        }
                        else if(row.auditstatus.id === 6){
                                x = `<a class="badge bg-danger" title="Print Make Report By LPM" href="{{ url('lpm/lpm_edit/${row.id}') }}">
                                    <i class="bx bx-printer"></i></a>`
                        }
                        else if(row.auditstatus.id === 1 || row.auditstatus.id === 2 || row.auditstatus.id === 13 || row.auditstatus.id === 5 ){
                                x = `<a class="badge bg-warning" title="Determine Standard" href="{{ url('lpm/lpm_standard/${row.id}') }}">
                                    <i class="bx bx-pencil"></i></a>`
                        }
                        return x;
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
                text: "Apakah Make Report ("+data+") sudah sesuai?!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willApprove) => {
                if (willApprove) {
                    $.ajax({
                        url: "{{route('approve')}}",
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

    // function revisedId(id, data) {
    //     swal({
    //             title: "Apa kamu yakin?",
    //             text: "Periksa kembali, apakah Make Report ("+data+") kurang sesuai?",
    //             icon: "warning",
    //             buttons: true,
    //             dangerMode: true,
    //         })
    //         .then((willRevised) => {
    //             if (willRevised) {
    //                 $.ajax({
    //                     url: "",
    //                     type: "POST",
    //                     data: {
    //                         "id": id,
    //                         "_token": $("meta[name='csrf-token']").attr("content"),
    //                     },
    //                     success: function (data) {
    //                         if (data['success']) {
    //                             swal(data['message'], {
    //                                 icon: "success",
    //                             });
    //                             $('#datatable').DataTable().ajax.reload();
    //                         } else {
    //                             swal(data['message'], {
    //                                 icon: "error",
    //                             });
    //                         }
    //                     }
    //                 })
    //             }
    //         })
    // }

    // <a class="badge bg-warning badge-icon" title="Remark Make Report By LPM" data-id="${row.id}"
    //                                 data-remark_by_lpm="${row.remark_by_lpm}" onclick="showModal(this)" style="cursor:pointer">
    //                                 <i class="bx bx-pencil icon-white"></i></a>

    function showModal(element) {
        var id = $(element).data('id');
        var link = $(element).data('link');
        var remark_by_lpm = $(element).data('remark_by_lpm');
        var validate_by_lpm = $(element).data('validate_by_lpm');
        $('#modal-link').text(link).attr('href', link);
        $('#modal-remark_by_lpm').text(remark_by_lpm).attr('href', remark_by_lpm);
        $('#modal-validate_by_lpm').text(validate_by_lpm).attr('href', validate_by_lpm);
        $('#upload-form').attr('action', '/lpm/lpm_update/' + id);
        $('#uploadModal').modal('show');
    }

    // function submitForm(status) {
    //     $('#status_type').val(status);
    //     $('#upload-form').submit();
    // }
</script>
@endsection
