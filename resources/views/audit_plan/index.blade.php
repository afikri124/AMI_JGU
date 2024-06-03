@extends('layouts.master')
@section('content')
@section('title', 'Data Audit Plan')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/sweetalert2.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
@endsection

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
                <th>Lecture</th>
                <th>Date</th>
                <th>Status</th>
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
                    aria-label="Close">
                </button>
            </div>
            <div class="offcanvas-body my-auto mx-0 flex-grow-1">
                <form method="POST" action="">
                @csrf
                <div class="col-sm-12 fv-plugins-icon-container">
                            <label for="lecture_id" class="form-label" >Lecture</label>
                            <select name="lecture_id" id="lecture_id" class="form-select" required>
                                <option value="">Select Lecture</option>
                                @foreach($users as $role)
                                    <option value="{{$role->id}}"
                                        {{ (in_array($role->id, old('users') ?? []) ? "selected": "") }}>
                                        {{$role->name}} (
                                            @foreach ($role->roles as $x)
                                                {{ $x->name}}
                                            @endforeach
                                        )</option>
                                    @endforeach
                            </select>
                        </div>
                    <div class="col-sm-12 fv-plugins-icon-container">
                        <label class="form-label" for="basicDate">Date</label>
                            <div class="input-group input-group-merge has-validation">
                                <input type="date" class="form-control @error('date') is-invalid @enderror" name="date"
                                    placeholder="Masukkan Date" value="{{ old('date') }}">
                                        @error('date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong></span>
                                @enderror
                                    </div>
                                        </div>
                                <div class="col-sm-12 fv-plugins-icon-container">
                            <label for="location" class="form-label" >Location</label>
                            <select name="location" id="location" class="form-select" required>
                            <option value="">Select Location</option>
                            @foreach($locations as $d)
                                <option value="{{$d->id}}"
                                    {{ (in_array($d->id, old('locations') ?? []) ? "selected": "") }}>
                                    {{$d->title}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12 fv-plugins-icon-container">
                            <label for="auditor_id" class="form-label">Auditor</label>
                            <select name="auditor_id" id="auditor_id" class="form-select" required>
                                <option value="">Select Auditor</option>
                                @foreach($users as $role)
                                    <option value="{{$role->id}}"
                                        {{ (in_array($role->id, old('users') ?? []) ? "selected": "") }}>
                                        {{$role->name}} (
                                            @foreach ($role->roles as $x)
                                                {{ $x->name}}
                                            @endforeach
                                        )</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12 fv-plugins-icon-container">
                            <label for="department_id" class="form-label" >Department</label>
                            <select name="department_id" id="department_id" class="form-select" required>
                                <option value="">Select Department</option>
                                @foreach($departments as $d)
                                    <option value="{{$d->id}}"
                                        {{ (in_array($d->id, old('departments') ?? []) ? "selected": "") }}>
                                        {{$d->name}}</option>
                                    @endforeach
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
<script src="{{asset('assets/vendor/libs/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/datatables-bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/datatables.responsive.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/responsive.bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/datatables.checkboxes.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/datatables-buttons.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/buttons.bootstrap5.js')}}"></script>
<script src="{{asset('assets/js/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>

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
                    d.select_user_id = $('#select_user_id').val()
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

                            return row.lecture.name;
                    },
                },
                {
                    render: function (data, type, row, meta) {
                        return row.date;
                    },
                },
                {
                    render: function (data, type, row, meta) {

                            return row.audit_status_id;
                    },
                },
                {
                    render: function (data, type, row, meta) {

                            return row.location;
                    },
                },
                {
                    render: function (data, type, row, meta) {

                            return row.auditor.name;
                    },
                },
                {
                    render: function (data, type, row, meta) {

                            return row.department_id
                    },
                },
                {
                    render: function (data, type, row, meta) {
                        var html =
                            `<a class="btn btn-warning btn-sm px-2" title="Edit" href="{{ url('edit_audit/') }}/${row.id}">
                            <i class="bx bx-pencil"></i></a>
                            <a class="btn btn-primary btn-sm px-2" title="Delete" onclick="DeleteId(\'` + row.id + `\',\'` + row.date + `\')" >
                            <i class="bx bx-trash"></i></a>`;
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
