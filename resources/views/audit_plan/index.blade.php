@extends('layouts.master')
@section('content')
@section('title', 'Audit Plan')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/sweetalert2.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
    .container,.container-fluid,.container-sm,.container-md,.container-lg,.container-xl,.container-xxl {
    padding-right: unset;
    padding-left: unset;
    }
    .container-p-y:not([class^=pt-]):not([class*=" pt-"]) {
    padding-top: 0.9em !important;
}
</style>
@endsection

<div class="container-xxl flex-grow-1 container-p-y">
<div class="card">
    <div class="card-datatable table-responsive">
        <div class="card-header flex-column flex-md-row pb-0">
            <div class="row">
                <div class="col-12 pt-3 pt-md-0">
                    <div class="col-12">
                        <div class="row">
                <div class="row">
                <div class="col-md-3">
                    <select id="select_auditee" name="select2" class="select form-select" data-placeholder="Date Start">
                        <option value="">Select Auditee</option>
                        @foreach($auditee as $d)
                        <option value="{{ $d->id }}">{{ $d->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="container">
                    <table class="table" id="datatable">
                        <div class="col-md d-flex justify-content-center justify-content-md-end">
                            <a class="btn btn-primary btn-block btn-mail" title="Add Audit Plan"
                                href="{{ route('audit_plan.add')}}">
                                <i data-feather="plus"></i>+ Add
                            </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                    <thead>
                        <tr>
                            <th width="5%"><b>No</b></th>
                            <th width="15%"><b>Auditee</b></th>
                            <th width="35%"><b>Schedule</b></th>
                            <th width="10%"><b>Status</b></th>
                            <th width="20%"><b>Location</b></th>
                            <th width="15%"><b>Action</b></th>
                        </tr>
                    </thead>
                </table>
            </div>

@endsection

@section('script')
<script src="{{asset('assets/vendor/libs/datatables/jquery.dataTables.js')}}"></script>
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
                url: "{{ route('audit_plan.data') }}",
                data: function (d) {
                    d.search = $('input[type="search"]').val(),
                    d.select_auditee = $('#select_auditee').val()
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
                            row.idd + `') }}">` + row.auditee.name + `</a>`;

                        if (row.auditee.no_phone) {
                            html += `<br><a href="tel:` + row.auditee.no_phone + `" class="text-muted" style="font-size: 0.8em;">` +
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
                    render: function(data, type, row, meta) {
                        var html =
                            `<span class="badge bg-${row.auditstatus.color}">${row.auditstatus.title}</span>`;
                        return html;
                    }
                },
                {
                    render: function (data, type, row, meta) {
                            return row.location;
                    },
                },
                {
                    render: function (data, type, row, meta) {
                        var html =
                            `
                            <a class="badge bg-dark badge-icon" title="Show Auditor" style="cursor:pointer" href="{{ url('audit_plan/standard/') }}/${row.id}">
                            <i class="bx bx-show-alt icon-white"></i></a>
                            <a class="badge bg-warning badge-icon" title="Edit Audit Plan" href="{{ url('edit_audit/') }}/${row.id}">
                            <i class="bx bx-pencil"></i></a>
                            <a class="badge bg-danger badge-icon" title="Delete Audit Plan" style="cursor:pointer" onclick="DeleteId(\'` + row.id + `\',\'` + row.auditee.name + `\')" >
                            <i class="bx bx-trash icon-white"></i></a>
                            `;
                        return html;
                    },
                    "orderable": false,
                    className: "text-md-center"
                }
            ]
        });
        $('#select_auditee').change(function () {
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
