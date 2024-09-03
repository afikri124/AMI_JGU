{{-- @extends('layouts.master')
@section('content')
@section('title', 'RTM')

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
                            <div class="col-md-3">
                                <select id="select_periode" class="form-control input-sm select2" data-placeholder="Periode">
                                    <option value="">Select Periode</option>
                                    @foreach($periode as $prd)
                                    <option value="{{ $prd }}">{{ $prd }}</option>
                                    @endforeach
                                </select>
                            </div>
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <table class="table table-hover table-sm" id="datatable" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" data-priority="1" width="50px">No</th>
                                    <th scope="col">Department</th>
                                    <th scope="col" data-priority="1" width="10px">Periode</th>
                                    <th scope="col" data-priority="3" width="65px">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
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
<script>
    "use strict";
    setTimeout(function () {
        (function ($) {
            "use strict";
            $(".select2").select2({
                allowClear: true,
                minimumResultsForSearch: 7
            });
        })(jQuery);
    }, 350);
</script>
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
            url: "{{ route('rtm.rtm_data') }}",
            data: function (d) {
                d.search = $('input[type="search"]').val();
                d.select_periode = $('#select_periode').val();
            },
        },
        columns: [
            { data: null, render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }, className: "text-center" },
            { data: 'name' },
            { data: 'periode' },
            { data: null, render: function(data, type, row, meta) {
                return `<a class="badge bg-primary" title="RTM Report" href="{{ url('rtm/rtm_edit/${row.id}') }}">
                            <i class="bx bx-printer"></i></a>`;
            }, "orderable": false, className: "text-md-center" }
        ]
    });
    $('#select_periode').change(function () {
            table.draw();
    });
});
</script>
@endsection --}}
