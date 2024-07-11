@extends('layouts.master')
@section('title', 'Remark Documents')

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
    @if (session('Audit Mutu Internal'))
        <div class="alert alert-primary alert-dismissible" role="alert">
            {{ session('Audit Mutu Internal') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
    <div class="col-md-12">
            <div class="card h-100">
                <form id="form-add-new-record" method="POST" action="{{ route('observations.update', $data->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                <div class="card-body row g-3">
                <h3><b>REMARK BY AUDITOR</b></h3>
                <div class="card-body">
                    <div class="col-sm-12 fv-plugins-icon-container">
                            <label class="form-label" for="basicDate">Remark Document Review<i class="text-danger">*</i></label></label>
                            <div class="input-group input-group-merge has-validation">
                                <textarea type="text" class="form-control @error('remark_docs') is-invalid @enderror" name="remark_docs"></textarea>
                                @error('remark_docs')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <i class="text-danger">* <b>Tambahkan note, jika Document Auditee belum lengkap!</b></i>
            <div class="card-footer text-end">
                <button class="btn btn-success" type="submit">Update</button>
                <a href="{{ url()->previous() }}">
                    <span class="btn btn-secondary">Back</span>
                </a>
            </div>
@endsection

