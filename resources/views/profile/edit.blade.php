@extends('layouts.master')

@section('title', 'Edit Profile')
@section('breadcrumb-items')
    <span class="text-muted fw-light"></span>
@endsection

@section('content')
    <div class="content-wrapper">

        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card mb-4">
                <h5 class="card-header">Profile Details</h5>
                <!-- Account -->
                <div class="card-body">
                    @if (session('msg'))
                        <div class="alert alert-primary alert-dismissible" role="alert">
                            {{ session('msg') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="../assets/img/avatars/user-f.png" alt="user-avatar" class="d-block rounded" height="100"
                            width="100" id="uploadedAvatar">
                        <div class="button-wrapper">
                            <label for="upload" class="btn btn-info me-2 mb-4" tabindex="0">
                                <span class="d-none d-sm-block">Upload new photo</span>
                                <i class="bx bx-upload d-block d-sm-none"></i>
                                <input type="file" id="upload" class="account-file-input" hidden=""
                                    accept="image/png, image/jpeg">
                            </label>
                            <button type="button" class="btn btn-label-secondary account-image-reset mb-4">
                                <i class="bx bx-reset d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Reset</span>
                            </button>

                            <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                        </div>
                    </div>
                </div>
                <hr class="my-0">
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="row">
                            @csrf
                            <div class="mb-3 col-md-6 fv-plugins-icon-container">
                                <label class="form-label"><b>Nama</b></label><i class="text-danger">*</i>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ Auth::user()->name }}" placeholder="Nama Lengkap" autofocus/>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                            <div class="mb-3 col-md-6 fv-plugins-icon-container">
                                <label class="form-label"><b>Username</b></label><i class="text-danger">*</i>
                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                    name="username" value="{{ Auth::user()->username }}" placeholder="NIK/NIM"
                                    @if (Auth::user()->username != null) readonly title="Silahkan hubungi Admin" @endif />
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @if (Auth::user()->username == null)
                                    <span class="text-danger">
                                        <strong>Isi Username/NIM Anda</strong>
                                    </span>
                                @endif
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label"><b>Email</b></label><i class="text-danger">*</i>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email"
                                    value="{{ old('email') == null ? Auth::user()->email : old('email') }}" />
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="nidn" class="form-label"><b>NIDN</b></label><i class="text-danger">*</i>
                                <input type="number" class="form-control @error('nidn') is-invalid @enderror"
                                    id="nidn" name="nidn" placeholder="Input your NIDN"
                                    value="{{ old('nidn') == null ? Auth::user()->nidn : old('nidn') }}" />
                                @error('nidn')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label"><b>Front Title</b></label><i class="text-danger">*</i>
                                <input type="text" class="form-control @error('front_title') is-invalid @enderror"
                                    name="front_title" placeholder="Input your Front Title" value="{{ Auth::user()->front_title }}" />
                                @error('front_title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label"><b>Back Title</b></label><i class="text-danger">*</i>
                                <input type="text" class="form-control @error('back_title') is-invalid @enderror"
                                    name="back_title" placeholder="Input your Back Title" value="{{ Auth::user()->back_title }}" />
                                @error('back_title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="no_phone" class="form-label"><b>Phone Number</b></label><i class="text-danger">*</i>
                                <input type="number" class="form-control @error('no_phone') is-invalid @enderror"
                                    id="no_phone" name="no_phone" placeholder="Input your Phone Number"
                                    value="{{ old('no_phone') == null ? Auth::user()->no_phone : old('no_phone') }}" />
                                @error('no_phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                            <label class="form-label" for="basicDate"><b>Gender</b></label><i class="text-danger">*</i>
                            <div class="input-group input-group-merge has-validation">
                                <select class="form-select @error('gender') is-invalid @enderror select2-modal"
                                    name="gender" data-placeholder="-- Select --">
                                    <option value="">-- Select --</option>
                                    <option value="M" {{ ("M"==old('gender') ? "selected": "") }}>Male</option>
                                    <option value="F" {{ ("F"==old('gender') ? "selected": "") }}>Female</option>
                                </select>
                                @error('gender')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                            <div class="mb-3 col-md-6">
                            <div class="form-group">
                            <label for="department_id" class="form-label"><b>Department</b><i class="text-danger">*</i></label>
                            <select name="department_id" id="department_id" class="form-select" required>
                                <option value="">Select Department</option>
                                @foreach($departments as $d)
                                    <option value="{{$d->id}}"
                                        {{ (in_array($d->id, old('departments') ?? []) ? "selected": "") }}>
                                        {{$d->name}}</option>
                                    @endforeach
                            </select>
                            </div>
                        </div>
                            <div class="card-footer text-end">
                            <button class="btn btn-danger" type="submit">Save</button>
                            <a class="btn btn-outline-secondary" href="{{ route('dashboard') }}">Back</a>
                        </div>
                        <input type="hidden">
                    </form>
                </div>
                <!-- /Account -->
            </div>
        </div>



    </div>
    <!-- / Content -->

    <div class="content-backdrop fade"></div>
    </div>
@endsection
