@extends('layouts.master')
@section('content')
@section('title', 'Upload Document')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
@endsection

<style>
    .large-text {
        font-size: 15px; /* Anda bisa sesuaikan ukuran teks sesuai keinginan */
        font-weight: bold;
    }
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
        <div class="card mb-5">
            <h4 class="card-header"><b>Have you uploaded the following drive link?</b></h4>
            <hr class="my-0">
            <div class="card-body">
                <form id="form-add-new-record" method="POST" action="{{ route('my_audit.update', $data->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <td>
                        <label class="form-label large-text">Link Drive</label>
                        <br>
                            <a href="{{ $data->link }}" class="large-text" target="_blank">{{ $data->link }}</a>
                            @error('link')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </td>
                        <hr>
                        <div class="form-group">
                            <label class="form-label large-text">Upload Document</label>
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
                            <div class="text-end">
                                <button class="btn btn-primary" type="submit">Done</button>
                                <a href="{{ url()->previous() }}">
                                    <span class="btn btn-secondary">Back</span>
                                </a>
                            </div>
                        @endsection

@section('script')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
</script>
@endsection
