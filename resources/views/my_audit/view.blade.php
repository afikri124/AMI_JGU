@extends('layouts.master')
@section('title', 'Upload Document Audit')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
<link rel="stylesheet" href="{{asset('assets/vendor/sweetalert2.css')}}">
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
            <div class="card-body">
                {{-- <form action="{{ route('my_audit.my_standard', $data->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <strong style="color: black;">CATEGORY STANDARD</strong>
                        <ol>
                            @foreach ($standardCategories as $category)
                            <li>
                                <h6 class="mb-0" name="standard_category_id" id="standard_category_id">
                                    {{ $category->description }}
                                </h6>
                            </li>
                            @endforeach
                        </ol>
                    </div>
                    <div class="col-md-6">
                        <strong style="color: black;">CRITERIA STANDARD</strong>
                        <ol>
                            @foreach ($standardCriterias as $criteria)
                            <li>
                                <h6 class="mb-0" name="standard_criteria_id" id="standard_criteria_id">
                                    {{ $criteria->title }}
                                </h6>
                            </li>
                            @endforeach
                        </ol>
                    </div>
                </div>
                <!-- Loop through criteria and statements -->
                @foreach ($standardCriterias as $criteria)
                <div class="row">
                    <h6 class="text-primary">
                        <button type="button" class="btn btn-primary">
                            <b>{{ $loop->iteration }}</b>
                        </button> <b>{{ $criteria->title }}</b>
                    </h6>
                </div>
                @foreach ($criteria->statements as $no => $statement)
                @foreach ($statement->indicators as $indicator)
                @php
                $total_indicator++;
                $checklist = $obsChecklist->where('indicator_id', $indicator->id)->first();
                @endphp
                <div class="row border py-3 mx-1">
                    <div class="col-md-7">
                        <button type="button" class="btn btn-outline-primary mb-2">
                            <strong>{{ $loop->iteration }}.{{ $loop->parent->iteration }}</strong>
                        </button>
                        <ul>
                            <strong>{{ $statement->name }}</strong>
                        </ul>
                    </div>
                    <div class="col-md-5">
                        <!-- Form untuk Upload Document -->
                        <form method="POST" action="{{ route('my_audit.my_standard', $data->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="doc_path" class="form-label large-text"><b>Upload Document | </b><i
                                        style="color: black;">MAX. 50mb</i>
                                </label>
                                <input type="file" class="form-control @error('doc_path') is-invalid @enderror"
                                    name="doc_path" accept=".png,.jpg,.jpeg,.pdf,.xls,.xlsx">
                                <input type="hidden" name="indicator_id" value="{{ $indicator->id }}">
                                @error('doc_path')
                                <div class="text-danger-custom">Please upload a valid document. The file size
                                    should not exceed 50MB.
                                </div>
                                @enderror
                                @if ($checklist && $checklist->doc_path)
                                @php
                                $fileName = basename($checklist->doc_path);
                                $fileNameWithoutId = preg_replace('/^\d+_/', '', $fileName);
                                @endphp
                                <strong class="form-label">File: </strong>
                                <a href="{{ asset($checklist->doc_path) }}" target="_blank"
                                    style="word-wrap: break-word; max-width: 500px;" class="text-secondary">
                                    {{ $fileNameWithoutId }}
                                </a>
                                <button formaction="{{ route('my_audit.delete_file', ['id' => $checklist->id]) }}"
                                    class="btn btn-text btn-sm p-0" type="submit" title="Delete document"
                                    onclick="return confirm('Are you sure you want to delete this file?');">
                                    <i class="menu-icon tf-icons bx bx-trash m-0 p-0 text-danger"></i>
                                </button>
                                @endif
                            </div>
                            <button class="btn 
                                    @if ( $checklist?->link != null || $checklist?->doc_path != null )
                                        btn-secondary
                                    @else
                                        btn-success
                                    @endif
                                    btn-sm mt-2" type="submit" name="save_file">Save
                            </button>
                        </form>
                    </div>
                </div>
                <div class="row border border-top-0 py-3 mx-1">
                    <div class="col-md-7">
                        <button type="button" class="btn btn-text-primary">
                            <strong>Indicator</strong>
                        </button>
                        <ul>{!! $indicator->name !!}</ul>
                    </div>
                    <div class="col-md-5">
                        <!-- Form untuk Link Document -->
                        <form method="POST" action="{{ route('my_audit.my_standard', $data->id) }}">
                            @csrf
                            <div class="form-group">
                                <label for="link" class="form-label large-text"><b>Link Document</b></label>
                                <input type="text" class="form-control @error('link') is-invalid @enderror" name="link"
                                    placeholder="Link Drive/Document Audit" value="{{ $checklist->link ?? '' }}">
                                <input type="hidden" name="indicator_id" value="{{ $indicator->id }}">
                                @error('link')
                                <div class="text-danger-custom">Please provide a valid document link.</div>
                                @enderror

                                @if ($checklist && $checklist->link)
                                <strong class="form-label">Link: </strong>
                                <a href="{{ asset($checklist->link) }}" target="_blank"
                                    style="word-wrap: break-word; max-width: 500px;" class="text-secondary">
                                    {{ $checklist->link }}
                                </a>
                                <button formaction="{{ route('my_audit.delete_link', ['id' => $checklist->id]) }}"
                                    class="btn btn-text btn-sm p-0" type="submit"
                                    onclick="return confirm('Are you sure you want to delete this link?');">
                                    <i class="menu-icon tf-icons bx bx-trash m-0 p-0 text-danger"
                                        title="Delete link"></i>
                                </button>
                                @endif
                            </div>
                            <button class="btn 
                                        @if ( $checklist?->link != null || $checklist?->doc_path != null )
                                            btn-secondary
                                        @else
                                            btn-success
                                        @endif
                                        btn-sm mt-2" type="submit" name="save_link">Save
                            </button>
                        </form>
                    </div>
                </div>
                <div class="row border border-top-0 py-3 mx-1">
                    <div class="col-md-7">
                        <button type="button" class="btn btn-text-primary">
                            <strong>Review Document</strong>
                        </button>
                        <ul>
                            @foreach ($statement->reviewDocs as $reviewDoc)
                            {!! $reviewDoc->name !!}
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-5">
                        <form method="POST" action="{{ route('my_audit.my_standard', $data->id) }}">
                            @csrf
                            <div>
                                <label class="form-label" for="remark_path_auditee"><b>Remark Document</b><i
                                        class="text-danger">*</i></label>
                                <div class="input-group input-group-merge has-validation">
                                    <textarea type="text"
                                        class="form-control @error('remark_path_auditee') is-invalid @enderror"
                                        name="remark_path_auditee"
                                        placeholder="MAX 250 characters...">{{ $checklist->remark_path_auditee ?? '' }}</textarea>
                                    @error('remark_path_auditee')
                                    <div class="text-danger-custom">Please provide a remark. Maximum 250
                                        characters allowed.
                                    </div>
                                    @enderror
                                </div>
                                <input type="hidden" name="indicator_id" value="{{ $indicator->id }}">
                                <button class="btn 
                                                @if ( $checklist?->remark_path_auditee == null )
                                                    btn-success
                                                @else
                                                    btn-secondary
                                                @endif btn-sm mt-2" type="submit" name="save_remark">Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <hr>
                @endforeach
                @endforeach
                @endforeach

                <div class="text-end">
                    <form id="audit-form" action="{{ route('my_audit.my_standard', $data->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-primary me-1" type="button" onclick="confirmSubmit()">Submit</button>
                        <a class="btn btn-outline-primary" href="{{ route('my_audit.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @section('script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#basicDate').flatpickr();
        });

        function confirmSubmit() {
            swal({
                    title: "Are you sure?",
                    text: "Please make sure all data is correct and complete before submitting.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willSubmit) => {
                    if (willSubmit) {
                        $.ajax({
                            url: "{{ route('my_audit.my_standard', $data->id) }}",
                            type: "POST",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "final_submit": true,
                                "total_indicator": "{{$total_indicator}}"
                            },
                            success: function (data) {
                                swal(data.message, {
                                    icon: data.success ? "success" : "error",
                                }).then(() => {
                                    if (data.success) {
                                        window.location.href = "{{ route('my_audit.index') }}";
                                    }
                                });
                            },
                            error: function (xhr, status, error) {
                                swal("An error occurred: " + error, {
                                    icon: "error",
                                });
                            }
                        });
                    }
                });
        }

    </script>
    @endsection
