@extends('layouts.master')
@section('content')
@section('title', 'Data Audit Plan')

<div class="container">
    <table class="table" id="datatable">

    <div class="offset-md-1 text-md-end text-center pt-3 pt-md-0">
        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#newrecord" aria-controls="offcanvasEnd" tabindex="0"
            aria-controls="DataTables_Table_0" type="button"><span><i class="bx bx-plus me-sm-2"></i>
                <span>Add</span></span>
        </button>
    </div>
        <thead>
            <tr>
                <th>No</th>
                <th>Date</th>
                <th>Status</th>
                <th>Auditee</th>
                <th>Location</th>
                <th>Auditor</th>
                <th>Department</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>

<div class="offcanvas offcanvas-end @if($errors->all()) show @endif" id="newrecord"
    aria-labelledby="offcanvasEndLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasEndLabel" class="offcanvas-title">Add Audit Plan</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
                </div>
                <div class="offcanvas-body my-auto mx-0 flex-grow-1">
                    <form method="POST" action="">
                    @csrf
                        <div class="col-sm-12 fv-plugins-icon-container">
                            <label class="form-label" for="basicDate">Date</label>
                                <div class="input-group input-group-merge has-validation">
                                    <input type="date" class="form-control @error('date') is-invalid @enderror" name="date"
                                        placeholder="Masukkan nama Date" value="{{ old('date') }}">
                                            @error('date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong></span>
                                    @enderror
                                        </div></div>
                                        <div class="col-sm-12 fv-plugins-icon-container">
                            <label for="auditee_id" class="form-label" >Select Auditee</label>
                            <select name="auditee_id" id="auditee_id" class="form-select" required>
                                <option value="">Select Auditee</option>
                            </select>
                        </div>
                        <div class="col-sm-12 fv-plugins-icon-container">
                            <label for="location_id" class="form-label" >Select Location</label>
                            <select name="location_id" id="location_id" class="form-select" required>
                                <option value="">Select Location</option>
                            </select>
                        </div>
                        <div class="col-sm-12 fv-plugins-icon-container">
                            <label for="auditor_id" class="form-label" >Select Auditor</label>
                            <select name="auditor_id" id="auditor_id" class="form-select" required>
                                <option value="">Select Auditor</option>
                            </select>
                        </div>
                        <div class="col-sm-12 fv-plugins-icon-container">
                            <label for="departement_id" class="form-label" >Select Department</label>
                            <select name="departement_id" id="departement_id" class="form-select" required>
                                <option value="">Select Department</option>
                            </select>
                        </div>
                        <div class="col-sm-12 mt-4">
                            <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">Submit</button>
                            <button type="reset" class="btn btn-outline-secondary"
                                data-bs-dismiss="offcanvas">Batal</button>
                        </div>
                    </div>
    @endsection
    
    @section('script')
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
                    d.select_auditor_id = $('#select_auditor_id').val()
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
                        return row.date;
                    },
                },
                {
                    render: function (data, type, row, meta) {

                            return row.audit_plan_status_id;
                    },
                },
                {
                    render: function (data, type, row, meta) {

                            return row.auditee_id;
                    },
                },
                {
                    render: function (data, type, row, meta) {

                            return row.location_id;
                    },
                },
                {
                    render: function (data, type, row, meta) {

                            return row.auditor_id;
                    },
                },
                {
                    render: function (data, type, row, meta) {

                            return row.departement_id;
                    },
                },
                {
                    render: function (data, type, row, meta) {
                        var html =
                            `<a class="btn btn-warning" style="cursor:pointer" href="{{ url('edit_prodi/') }}/${row.id}">
                            <i class="bx bx-pencil"></i></a>
                            <a class="btn btn-danger" style="cursor:pointer" onclick="DeleteId(\'` + row.id + `\',\'` + row.nama_prodi + `\')" >
                            <i class="bx bx-trash"></i></a>`;
                        return html;
                    },
                    "orderable": false,
                    className: "text-md-center"
                }

            ]
        });
    });

    // function DeleteId(id, data) {
    //     swal({
    //             title: "Apa kamu yakin?",
    //             text: "Setelah dihapus, data ("+data+") tidak dapat dipulihkan!",
    //             icon: "warning",
    //             buttons: true,
    //             dangerMode: true,
    //         })
    //         .then((willDelete) => {
    //             if (willDelete) {
    //                 $.ajax({
    //                     url: "",
    //                     type: "DELETE",
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

</script>

@endsection
