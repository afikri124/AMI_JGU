@extends('layouts.master')
@section('content')
@section('title', 'Notification Audit Plan')

<div class="container">

    <table class="table" id="datatable">
        <thead>
            <tr>
                <th>No</th>
                <th>Date</th>
                <th>Program</th>
                <th>Auditor</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
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
                url: "{{ route('notification.data') }}",
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
                        return row.date;
                    },
                },
                {
                    render: function (data, type, row, meta) {

                            return row.program;
                    },
                },
                {
                    render: function (data, type, row, meta) {

                            return row.auditor;
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
