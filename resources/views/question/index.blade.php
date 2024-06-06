@extends('layouts.master')
@section('content')
@section('title', 'Question Standard')

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
    <table class="table" id="datatable">
        <div class="col-md-6 d-flex justify-content-center justify-content-md-end">
            <a class="btn btn-primary btn-block btn-mail" title="Add new"
                href="{{ route('question.add_qst')}}">
                <i data-feather="plus"></i>New
            </a>
        </div>
    

    <div class="container">
        <thead>
            <tr>
                <th scope="col" width="50px">No</th>
                <th scope="col" width="50px">Title</th>
                <th scope="col" width="50px">Weight</th>
                <th scope="col" width="50px">Status</th>
                <th scope="col" width="50px">Category</th>
                <th scope="col" width="50px">Action</th>
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
                url: "{{ route('question.add_qst') }}",
                data: function (d) {
                    d.search = $('input[type="search"]').val(),
                    d.select_lecture_id = $('#select_lecture_id').val()
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
                        return row.date_start;
                    },
                },
                {
                    render: function (data, type, row, meta) {
                        return row.date_end;
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

                            return row.auditor.name;
                    },
                },
                {
                    render: function (data, type, row, meta) {

                            return row.department.name;
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
