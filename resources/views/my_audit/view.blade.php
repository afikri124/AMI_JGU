@extends('layouts.master')
@section('title', 'Upload Document Audit')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
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
                <form action="{{ route('my_audit.my_standard', $data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                <strong style="color: black;">CATEGORY STANDARD</strong>
                @foreach ($standardCategories as $category)
                    <h6 class="mb-0" name="standard_category_id" id="standard_category_id">
                        {{ $category->description }}
                    </h6>
                @endforeach
                <p></p>

                <strong style="color: black;">CRITERIA STANDARD</strong>
                @foreach ($standardCriterias as $criteria)
                    <h6 class="mb-0" name="standard_criteria_id" id="standard_criteria_id">
                        {{ $criteria->title }}
                    </h6>
                @endforeach
                <p></p>

                <!-- Loop through criteria and statements -->
                @foreach ($standardCriterias as $criteria)
                    <h6 style="color: black;"><b>{{ $loop->iteration }}. {{ $criteria->title }}</b></h6>

                    @foreach ($criteria->statements as $no => $statement)
                        @foreach ($statement->indicators as $indicator)
                            @php
                                $checklist = $obsChecklist->where('indicator_id', $indicator->id)->first();
                            @endphp

                            <table class="table table-bordered">
                                <tr>
                                    <td style="width: 65%">
                                        <ul style="color: black;">{{ $loop->parent->iteration }}. {{ $statement->name }}</ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 60%">
                                        <strong>Indicator</strong>
                                        <ul>{!! $indicator->name !!}</ul>
                                    </td>
                                    <td>
                                        <!-- Form for File Upload -->
                                        <form action="{{ route('my_audit.save_file', $data->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group mb-3">
                                                <label for="doc_path" class="form-label large-text"><b>Upload Document | </b><i style="color: black;">MAX. 50mb</i></label>
                                                <input type="file" class="form-control @error('doc_path') is-invalid @enderror" name="doc_path" accept=".png,.jpg,.jpeg,.pdf,.xls,.xlsx">
                                                <input type="hidden" name="indicator_id" value="{{ $indicator->id }}">
                                                
                                                {{-- Custom error message --}}
                                                @error('doc_path')
                                                    <div class="text-danger-custom">Please upload a valid document. The file size should not exceed 50MB.</div>
                                                @enderror

                                                @if($checklist && $checklist->doc_path)
                                                    @php
                                                        $fileName = basename($checklist->doc_path);
                                                        $fileNameWithoutId = preg_replace('/^\d+_/', '', $fileName); // Remove ID from the file name
                                                    @endphp
                                                    <div class="mt-2">
                                                        <a href="{{ asset($checklist->doc_path) }}" target="_blank" style="word-wrap: break-word; display: inline-block; max-width: 450px;">
                                                            {{ $fileNameWithoutId }}
                                                        </a>
                                                        <button formaction="{{ route('my_audit.delete_file', ['id' => $checklist->id]) }}" 
                                                            class="btn btn-danger btn-sm" type="submit" 
                                                            onclick="return confirm('Are you sure you want to delete this file?');">
                                                            Delete File
                                                        </button>
                                                    </div>
                                                @endif
                                                <button class="btn btn-success btn-sm mt-2" type="submit">Save</button>
                                            </div>
                                        </form>
                                        
                                        <!-- Form for Link Upload -->
                                        <form action="{{ route('my_audit.save_link', $data->id) }}" method="POST">
                                            @csrf
                                            <div class="form-group mb-3">
                                                <label for="link" class="form-label large-text"><b>Link Document</b></label>
                                                <input type="text" class="form-control @error('link') is-invalid @enderror" name="link" placeholder="Link Drive/Document Audit" value="{{ $checklist->link ?? '' }}">
                                                <input type="hidden" name="indicator_id" value="{{ $indicator->id }}">

                                                {{-- Custom error message --}}
                                                @error('link')
                                                    <div class="text-danger-custom">Please provide a valid document link.</div>
                                                @enderror
                                            
                                                @if($checklist && $checklist->link)
                                                    @php
                                                        $fileName = basename($checklist->link);
                                                        $fileNameWithoutId = preg_replace('/^\d+_/', '', $fileName); // Remove ID from the link
                                                    @endphp
                                                    <div class="mt-2">
                                                        <a href="{{ $checklist->link }}" target="_blank" style="word-wrap: break-word; display: inline-block; max-width: 450px;">
                                                            {{ $fileNameWithoutId }}
                                                        </a>
                                                        {{-- Button delete link --}}
                                                        <button formaction="{{ route('my_audit.delete_link', ['id' => $checklist->id]) }}" 
                                                                class="btn btn-danger btn-sm" type="submit" 
                                                                onclick="return confirm('Are you sure you want to delete this link?');">
                                                            Delete Link
                                                        </button>
                                                    </div>
                                                @endif
                                                <button class="btn btn-success btn-sm mt-2" type="submit">Save</button>
                                            </div>
                                        </form>
                                    </td>                        
                                </tr>
                                <tr>
                                    <td style="width: 60%">
                                        <strong>Review Document</strong>
                                        @foreach ($statement->reviewDocs as $reviewDoc)
                                            <ul>{!! $reviewDoc->name !!}</ul>
                                        @endforeach
                                    </td>
                                    <td>
                                        <form action="{{ route('my_audit.save_remark', $data->id) }}" method="POST">
                                            @csrf
                                            <div>
                                                <label class="form-label" for="remark_path_auditee"><b>Remark Document By Auditee</b></label>
                                                <div class="input-group input-group-merge has-validation">
                                                    <textarea type="text" class="form-control @error('remark_path_auditee') is-invalid @enderror"
                                                    name="remark_path_auditee" placeholder="MAX 250 characters...">{{ $checklist->remark_path_auditee ?? '' }}</textarea>
                                                    @error('remark_path_auditee')
                                                        <div class="text-danger-custom">Please provide a remark. Maximum 250 characters allowed.</div>
                                                    @enderror
                                                </div>
                                                <input type="hidden" name="indicator_id" value="{{ $indicator->id }}">
                                                <button class="btn btn-success btn-sm mt-2" type="submit">Save</button>
                                            </div>
                                        </form>
                                    </td>        
                                </tr>
                            </table>
                            <hr>
                        @endforeach
                    @endforeach
                @endforeach

                <div class="text-end">
                    <form action="{{ route('my_audit.my_standard', $data->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-primary me-1" type="submit" name="final_submit">Submit</button>
                        <a class="btn btn-outline-primary" href="{{ route('my_audit.index') }}">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('assets/js/forms-selects.js') }}"></script>
<script>
$(document).ready(function() {
    $('#basicDate').flatpickr();
});
</script>
@endsection
