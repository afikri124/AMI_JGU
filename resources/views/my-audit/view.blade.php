@extends('layouts.master')

@section('title', 'Upload Document Audit')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}">
@endsection

@section('style')
    <style>
        /* Your existing styles here */
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(session('msg'))
                <div class="alert alert-primary alert-dismissible" role="alert">
                    {{ session('msg') }}

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card mb-5">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Category Standard</strong>
                            <ol>
                                @foreach ($standardCategories as $readCategory)
                                    <li>
                                        <h6 class="mb-0" name="standard_category_id" id="standard_category_id">
                                            {{ $readCategory->description }}
                                        </h6>
                                    </li>
                                @endforeach
                            </ol>
                        </div>

                        <div class="col-md-6">
                            <strong>Criteria Standard</strong>
                            <ol>
                                @foreach ($standardCriterias as $readCriteria)
                                    <li>
                                        <h6 class="mb-0" name="standard_criteria_id" id="standard_criteria_id">
                                            {{ $readCriteria->title }}
                                        </h6>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="readMyStandard" class="table table-striped w-100">
                            <thead>
                                <tr>
                                    <th class="text-center">{{ __('No') }}</th>
                                    <th class="text-center">{{ __('Statement') }}</th>
                                    <th class="text-center">{{ __('Indicator') }}</th>
                                    <th class="text-center">{{ __('Review Document') }}</th>
                                    <th class="text-center">{{ __('Related Files') }}</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/vendor/libs/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables/datatables.responsive.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables/buttons.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>

    @foreach ($standardCriterias as $readCriteria)
    <script>
        var datatable = $('#readMyStandard').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('my_audit.my_standard.ajax', $readCriteria->audit_plan_id) }}",
            columns: [
                { data: 'no', name: 'no', render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                }, width: '5%', class: 'text-center' },
                { data: 'statement_name', name: 'statement_name', class: 'text-center' },
                { data: 'indicator_name', name: 'indicator_name', class: 'text-center' },
                { data: 'review_doc_name', name: 'review_doc_name' },
                { data: 'action', name: 'action', orderable: true, searchable: true, width: '5%' }
            ]
        })
    </script>
    @endforeach
@endsection
