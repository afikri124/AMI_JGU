@extends('layouts.master')
@section('content')
@section('title', 'Upload Document')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/sweetalert2.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
@endsection

<div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">Upload Document Audit</div>
                <div class="card-body">
                    <form action="{{ route('update_doc', $data->id) }}" method="POST"
                    enctype="multipart/form-data"></form>
                        @csrf
                        @method('PUT')
                        <div class="col-sm-12">
                                <label class="form-label">Upload Images<i class="text-danger">*</i></label>
                                <div class="input-group mb-3">
                                    <input class="form-control @error('doc_path') is-invalid @enderror"
                                        name="doc_path" type="file" accept=".jpg, .jpeg, .png, .pdf"
                                        title="JPG/PNG/PDF">
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
<script src="{{asset('assets/vendor/libs/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/datatables-bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/datatables.responsive.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/responsive.bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/datatables.checkboxes.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/datatables-buttons.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/buttons.bootstrap5.js')}}"></script>
<script src="{{asset('assets/js/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
@endsection
