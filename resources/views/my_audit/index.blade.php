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
<link rel="stylesheet" href="assets/vendor/libs/flatpickr/flatpickr.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
@endsection

<style>
    .badge-icon {
        display: inline-block;
        font-size: 1em;
        padding: 0.4em;
        margin-right: 0.1em;
    }
</style>


        <!-- <div class=" col-md-3">
            <select id="select_lecture" class="select2 form-select" data-placeholder="lecture">
                <option value="">Select Lecture</option>
                @foreach($data as $d)
                    <option value="{{ $d->id }}">{{ $d->lecture_id }}</option>
                @endforeach
            </select>
        </div> -->

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
                                <th><b>Auditee</b></th>
                                <th><b>Schedule</b></th>
                                <th><b>Location</b></th>
                                <th><b>Auditor</b></th>
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
<script src="assets/vendor/libs/flatpickr/flatpickr.js"></script>
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

<script src="assets/vendor/libs/flatpickr/flatpickr.js"></script>
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
                        var html = `<a class="text-primary" title="` + row.lecture.name +
                            `" href="{{ url('setting/manage_account/users/edit/` +
                            row.idd + `') }}">` + row.lecture.name + `</a>`;

                        if (row.no_phone) {
                            html += `<br><a href="tel:` + row.no_phone + `" class="text-muted" style="font-size: 0.8em;">` +
                                    `<i class="fas fa-phone-alt"></i> ` + row.no_phone + `</a>`;
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

                        if (row.auditors && row.auditors.length > 0) {
                            // Ambil dua auditor pertama
                            var firstAuditor = row.auditors[0];
                            var secondAuditor = row.auditors.length > 1 ? row.auditors[1] : null;

                            // Tampilkan nama auditor pertama
                            html += `<code><span title="` + firstAuditor.name + `" href="{{ url('setting/manage_account/users/edit/`
                                    + row.idd + `') }}">` + firstAuditor.name +
                                    `</span></code><br>`;

                            // Jika ada auditor kedua, tampilkan juga
                            if (secondAuditor) {
                                html += `<code><span title="` + secondAuditor.name + `" href="{{ url('setting/manage_account/users/edit/`
                                        + row.idd + `') }}">` + secondAuditor.name +
                                        `</span></code><br>`;
                            }
                        }

                        if (row.no_phone) {
                            html += `<a href="tel:` + row.no_phone + `" class="text-muted" style="font-size: 0.8em;">` +
                                    `<i class="fas fa-phone-alt"></i> ` + row.no_phone + `</a>`;
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
                        var html =
                            `<a class="badge bg-success badge-icon" title="Upload" href="{{ url('my_audit/add/') }}/${row.id}"><i class="bx bx-upload"></i></a>
                            <a class="badge bg-warning badge-icon" title="Edit" href="{{ url('my_audit/edit/') }}/${row.id}"><i class="bx bx-pencil"></i></a>
                            <a class="badge bg-dark badge-icon"title="show" href="{{ url('my_audit/show/') }}/${row.id}"><i class="bx bx-low-vision"></i></a>`;
                        return html;
                    },
                    "orderable": false,
                    className: "text-md-center"
                }
            ]
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
                        url: "{{ route('audit_plan.delete') }}",
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
