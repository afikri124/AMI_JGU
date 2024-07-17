@extends('layouts.master')
@section('title', 'Profile')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection

@section('style')

@endsection


@section('content')
<div class="container-fluid">
    <div class="row edit-profile">
        <div class="col-xl-6">
            <div class="card">
                
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
                                <span class="d-none d-sm-block ">Upload new photo</span>
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
                    <div class="mb-1 row">
                    <li class="d-flex align-items-center mb-3"><i class="bx bx-user"></i>
                        <span class="fw-semibold mx-2">Nama:</span>
                        <div class="col-sm-6">
                            <b>
                                {{ Auth::user()->front_title }}
                                {{ Auth::user()->name }}
                                {{ Auth::user()->back_title }}
                            </b>
                        </div>
                    </div>
                    <div class="mb-1 row">
                    <li class="d-flex align-items-center mb-3"><i class="bx bx-user-check"></i>
                        <span class="fw-semibold mx-2">Username:</span>
                        <div class="col-sm-6">
                            <span>{{ Auth::user()->username }}</span>
                        </div>
                    </div>
                    <div class="mb-1 row">
                    <li class="d-flex align-items-center mb-3"><i class="bx bx-envelope"></i>
                        <span class="fw-semibold mx-2">Email:</span>
                        <div class="col-sm-6">
                            <span class="text-primary">{{ Auth::user()->email }}</span>
                        </div>
                    </div>
                    <div class="mb-1 row">
                    <li class="d-flex align-items-center mb-3"><i class="bx bx-mobile-alt"></i>
                        <span class="fw-semibold mx-2">Phone:</span>
                        <div class="col-sm-6">
                            <span>{{ Auth::user()->no_phone }}</span>
                        </div>
                    </div>
                    <div class="mb-1 row">
                    <li class="d-flex align-items-center mb-3"><i class="bx bx-briefcase"></i>
                        <span class="fw-semibold mx-2">NIDN:</span>
                        <div class="col-sm-6">
                            <span>{{ Auth::user()->nidn }}</span>
                        </div>
                    </div>
                    <div class="mb-1 row">
                    <li class="d-flex align-items-center mb-3"><i class="bx bx-buildings"></i>
                        <span class="fw-semibold mx-2">Department:</span>
                        <div class="col-sm-6">
                        <span>{{ Auth::user()->departments ? Auth::user()->departments->name : 'No Department' }}</span>
                        </div>
                    </div>
                    <div class="mb-1 row">
                    <li class="d-flex align-items-center mb-3"><i class="bx bx-user"></i>
                        <span class="fw-semibold mx-2">Job:</span>
                        <div class="col-sm-6">
                            <span>{{ Auth::user()->job }}</span>
                        </div>
                    </div>
                    <div class="mb-1 row">
                    <li class="d-flex align-items-center mb-3"><i class="bx bx-male-sign"></i>
                        <span class="fw-semibold mx-2">Gender:</span>
                        <div class="col-sm-6">
                            <span>{{ Auth::user()->gender }}</span>
                        </div>
                    </div>
                    <div class="mb-1 row">
                    <li class="d-flex align-items-center mb-3"><i class="bx bx-face"></i>
                        <span class="fw-semibold mx-2">Role Access:</span>
                        <div class="col-sm-6">
                            <span>
                                @if(Auth::user()->roles->count() == 0)
                                <p class="p-0 mb-0 text-danger">You don't have access rights, please contact the
                                    administrator!</p>
                                @else
                                @foreach(Auth::user()->roles as $x)
                                <b>{{ $x->name }}</b>
                                @endforeach
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <form class="card" method="POST" action="{{ route('profile.update') }}">
                @csrf
                <div class="card-header">
                    <h4 class="card-title mb-0">Update Profile</h4>
                    <div class="card-options"><a class="card-options-collapse" href="#"
                            data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                            class="card-options-remove" href="#" data-bs-toggle="card-remove"><i
                                class="fe fe-x"></i></a>
                    </div>
                    
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input class="form-control" type="text" name="name" value="{{ Auth::user()->name }}" >
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Front title</label>
                                <input class="form-control" type="text" name="front_title" value="{{ Auth::user()->front_title }}" >
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Back title</label>
                                <input class="form-control" type="text" name="back_title" value="{{ Auth::user()->back_title }}" >
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input class="form-control" type="text" name="username" value="{{ Auth::user()->username }}" >
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input class="form-control" type="email" name="email" value="{{ Auth::user()->email }}"
                                    required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <label class="form-label">Phone <i>(ex. 62xxxxxxxxx)</i></label>
                                <input class="form-control" type="number" name="no_phone" id="phone" value="{{ Auth::user()->no_phone }}"  placeholder="62xxxxxxxxxx">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <label class="form-label">NIDN</label>
                                <input class="form-control" type="number" name="nidn" id="nidn" value="{{ Auth::user()->nidn }}"  >
                            </div>
                        </div>
                        <div class="col-sm-12">
                        <div class="col-sm-12">
                        <div class="mb-3">
                            <label class="form-label">Department</label>
                            <select name="department_id" id="department_id" class="form-select select2">
                                <option value="">Select Department</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}" {{ Auth::user()->department_id == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <label class="form-label">Job</label>
                                <input class="form-control" type="text" name="job" value="{{ Auth::user()->job }}" >
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select @error('gender') is-invalid @enderror select2" 
                                    name="gender" data-placeholder="-- Select --">
                                    <option value="{{ Auth::user()->gender }}">-- Select --</option>
                                    <option value="M" {{ ("M"==$user->gender ? "selected": "") }}>Male</option>
                                    <option value="F" {{ ("F"==$user->gender ? "selected": "") }}>Female</option>
                            </select>
                        </div>
                        @foreach ($errors->all() as $error)
                        <p class="text-danger m-0">{{ $error }}</p>
                        @endforeach
                    </div>
                    
                </div>
                @method('PUT')
                <div class="card-footer text-end">
                    <button class="btn btn-primary" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>

<script>
    "use strict";
    setTimeout(function () {
        (function ($) {
            "use strict";
            $(".select2").select2({
                allowClear: true,
                minimumResultsForSearch: 7
            });
        })(jQuery);
    }, 350);

    function remove_zero(){
    var x = document.getElementById("phone").value;
    let number = Number(x);
    if(number == 0){
        document.getElementById("phone").value = null;
    } else {
        document.getElementById("phone").value = number;
    }
}
</script>
@endsection
