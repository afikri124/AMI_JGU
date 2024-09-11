@extends('layouts.master')
@section('title', 'HoD Ami')

@section('breadcrumb-title')
<h3>@yield('title')</h3>
@endsection

@section('breadcrumb-items')
<span class="text-muted fw-light">Setting /</span>
<span class="text-muted fw-light">Manage Unit /</span>
@endsection

@section('content')
<div class="card mb-4">
    <div class="row">
        <form method="POST" action="">
            @csrf
            <div class="card-header">
                <h4 class="card-title mb-0">Ketua LPM</h4>
                <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i
                            class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#"
                        data-bs-toggle="card-remove"><i class="fe fe-x"></i></a>
                </div>
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
                <div class="card-footer text-end">
                    <button class="btn btn-primary" type="submit">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
{{-- <hr style="color: black;"> --}}
<div class="card">
    <div class="row">
        <form method="POST" action="">
            @csrf
            <div class="card-header">
                <h4 class="card-title mb-0">Ketua BPMI</h4>
                <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i
                            class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#"
                        data-bs-toggle="card-remove"><i class="fe fe-x"></i></a>
                </div>
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
                <div class="card-footer text-end">
                    <button class="btn btn-primary" type="submit">Update</button>
                </div>
        </form>
    </div>
</div>
@endsection
