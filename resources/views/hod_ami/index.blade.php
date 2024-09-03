@extends('layouts.master')
@section('title', 'HoD Ami')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>@yield('title')</h3>
@endsection

@section('breadcrumb-items')
<span class="text-muted fw-light">Setting /</span>
<span class="text-muted fw-light">Manage Unit /</span>
@endsection

@section('content')
<div class="row">
        <div class="card-datatable table-responsive">
            <div class="card-header flex-column flex-md-row pb-0">
            <div class="row">
            <form class="card" method="POST" action="">
                @csrf
                <div class="card-header">
                    <h4 class="card-title mb-0">Ketua LPM</h4>
                    <div class="card-options"><a class="card-options-collapse" href="#"
                            data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                            class="card-options-remove" href="#" data-bs-toggle="card-remove"><i
                                class="fe fe-x"></i></a></div>
                </div>
                <div class="card-body">
                    <div class="row">
                    @php
                        $id = null;
                        $title = null;
                        $content = null;
                        foreach($data as $d){
                        if($d->id == 'HODLPM'){
                        $id = $d->id;
                        $title = $d->title;
                        $content = $d->content;
                        }
                        }
                        @endphp
                        <input class="form-control" type="hidden" name="id" value="{{ $id }}" required>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Full name with title</label>
                                <input class="form-control" type="text" name="title" value="{{ $title }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">NIK</label>
                                <input class="form-control" type="text" name="content" value="{{ $content }}" required>
                            </div>
                        </div>
                        @foreach ($errors->all() as $error)
                        <p class="text-danger m-0">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
<br>
<div class="row">
    <div class="card-datatable table-responsive">
        <div class="card-header flex-column flex-md-row pb-0">
            <div class="row">
            <form class="card" method="POST" action="">
                @csrf
                <div class="card-header">
                    <h4 class="card-title mb-0">Ketua BPMI</h4>
                    <div class="card-options"><a class="card-options-collapse" href="#"
                            data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                            class="card-options-remove" href="#" data-bs-toggle="card-remove"><i
                                class="fe fe-x"></i></a></div>
                </div>
                <div class="card-body">
                    <div class="row">
                    @php
                        $id = null;
                        $title = null;
                        $content = null;
                        foreach($data as $d){
                        if($d->id == 'HODBPMI'){
                        $id = $d->id;
                        $title = $d->title;
                        $content = $d->content;
                        }
                        }
                        @endphp
                        <input class="form-control" type="hidden" name="id" value="{{ $id }}" required>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Full name with title</label>
                                <input class="form-control" type="text" name="title" value="{{ $title }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">NIK</label>
                                <input class="form-control" type="text" name="content" value="{{ $content }}" required>
                            </div>
                        </div>
                        @foreach ($errors->all() as $error)
                        <p class="text-danger m-0">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
@endsection
