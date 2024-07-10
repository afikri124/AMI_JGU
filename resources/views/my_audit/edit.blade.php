@extends('layouts.master')
@section('title', 'Edit Document Audit')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection

@section('style')
<style>
    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    .timeline .timeline-item .timeline-indicator i,
    .timeline .timeline-item .timeline-indicator-advanced i {
        color: #696cff;
    }

    .timeline .timeline-indicator-primary i {
        color: #696cff !important;
    }

    .bx {
        vertical-align: middle;
        font-size: 1.15rem;
        line-height: 1;
    }

    .bx {
        font-family: "boxicons" !important;
        font-weight: normal;
        font-style: normal;
        font-variant: normal;
        line-height: 1;
        text-rendering: auto;
        display: inline-block;
        text-transform: none;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    user agent stylesheet i {
        font-style: italic;
    }

    .timeline .timeline-item .timeline-indicator,
    .timeline .timeline-item .timeline-indicator-advanced {
        position: absolute;
        left: -0.75rem;
        top: 0;
        z-index: 2;
        height: 1.5rem;
        width: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        border-radius: 50%;
    }

    user agent stylesheet li {
        text-align: -webkit-match-parent;
    }

    .timeline {
        position: relative;
        height: 100%;
        width: 100%;
        padding: 0;
        list-style: none;
    }

    .mb-4 {
        margin-bottom: 1.5rem !important;
    }
</style>
@endsection

@section('content')
@if (session('msg'))
<div class="alert alert-primary alert-dismissible" role="alert">
    {{ session('msg') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row">
    <div class="card mb-4">
            <h3 class="card-header"><b>Update Document Audit</b></h3>
            <hr class="my-0">
        <div class="card-body">
            <form id="form-add-new-record" method="POST" action="{{ route('my_audit.update_doc', $data->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label"><b>Edit Document</b><i class="text-danger">*</i></label>
                    <div class="input-group mb-3">
                        <input class="form-control @error('doc_path') is-invalid @enderror" name="doc_path" type="file" accept=".pdf" title="PDF">
                        <input type="hidden" name="doc_path_existing" value="{{ $data->doc_path }}">
                        @error('doc_path')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-12 fv-plugins-icon-container">
                    <label class="form-label" for="basicDate"><b>Link Drive</b><i class="text-danger">*</i></label>
                    <div class="input-group input-group-merge has-validation">
                        <input class="form-control @error('link') is-invalid @enderror" name="link" id="link" placeholder="Input your link drive" value="{{ $data->link }}">
                        @error('link')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-success" type="submit">Update</button>
                    <a href="{{ url()->previous() }}">
                        <span class="btn btn-secondary">Back</span>
                    </a>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endsection
