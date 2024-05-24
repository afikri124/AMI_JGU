@extends('layouts.master')
@section('content')
@section('title', 'Progress Status Plan')

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
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Title</th>
                <th>Remark By LPM</th>
                <th>Remark By Approver</th>
                <th>Action</th>
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
                url: "{{ route('audit_status.data') }}",
                data: function (d) {
                    d.search = $('input[type="search"]').val(),
                    d.select_fakultas = $('#select_fakultas').val()
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
                        return row.name;
                    },
                },
                {
                    render: function (data, type, row, meta) {

                            return row.title;
                    },
                },
                {
                    render: function (data, type, row, meta) {

                            return row.remark_by_lpm;
                    },
                },
                {
                    render: function (data, type, row, meta) {

                            return row.remark_by_approver;
                    },
                },
                {
                    render: function (data, type, row, meta) {
                        var html =
                            `
                            <a class="btn btn-dark" btn-sm px-2" (\'` + row.id + `\',\'` + row.nama_prodi + `\')" >
                            <i class="bx bx-upload"></i></a>`;
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
