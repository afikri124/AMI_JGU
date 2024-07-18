@extends('layouts.master')
@section('content')
@section('title', 'Upload Document')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
@endsection

<style>
    .container, .container-fluid, .container-sm, .container-md, .container-lg, .container-xl, .container-xxl {
    padding-right: 0.5em;
    padding-left: 0.5em;
}
</style>

<div class="row">
    <div class="col-md-12">
        @if(session('msg'))
        <div class="alert alert-primary alert-dismissible" role="alert">
            {{session('msg')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <div class="card mb-4">
            <h4 class="card-header"><b>Upload Document Audit</b></h4>
            <hr class="my-0">
            <div class="card-body">
                <form id="form-add-new-record" method="POST" action="{{ route('my_audit.update', $data->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label class="form-label">Upload Images</label>
                            <div class="input-group mb-3">
                                <input class="form-control @error('doc_path') is-invalid @enderror"
                                    name="doc_path" type="file" accept=".pdf"
                                    title="PDF">
                                @error('doc_path')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            </div>
                            <div class="col-sm-12 fv-plugins-icon-container">
                                <label class="form-label" for="basicDate">Link Drive</label>
                                <div class="input-group input-group-merge has-validation">
                                    <input class="form-control @error('link') is-invalid @enderror" name="link" id="link"
                                        placeholder="Input your link drive">{{ old('link') }}
                                    @error('link')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4">
                                <button type="submit"
                                    class="btn btn-primary data-submit me-sm-3 me-1">Submit</button>
                            </div>
                        @endsection

@section('script')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
</script>
@endsection
