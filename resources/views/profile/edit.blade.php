@extends('layouts.master')
@section('title', 'Edit Profile')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection

@section('style')
<style>
    .img {
        height: 100px;
        width: 100px;
        border-radius: 50%;
        object-fit: cover;
        background: #dfdfdf
    }

</style>
@endsection


@section('content')

@if(session('msg'))
<div class="alert alert-primary alert-dismissible" role="alert">
    {{session('msg')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="card">
    <form action="" method="POST" enctype="multipart/form-data" id="form-add-new-record">
        <div class="card-header d-flex flex-column flex-sm-row text-sm-start">
            @csrf
            <div class="flex-shrink-3 mx-sm-4">
                @if ($user->image)
                <img src="{{ asset($user->image) }}" alt="user-avatar" class="img" id="uploadedAvatar">
                @else
                <img src="{{ Auth::user()->image() }}" alt="user-avatar" class="img" id="uploadedAvatar">
                @endif
                <br><br>
                <small class="text-muted mb-0">Allowed JPG, GIF or PNG.<br>Max size of 800K</small>
            </div>
            <div class="flex-grow-1 mt-4">
                <div
                    class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                    <div class="user-profile-info">
                        <p class="text-muted mb-0" id="fileInfo"></p>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="button-wrapper">
                            <label for="image" class="btn btn-secondary me-2 mb-4" tabindex="0">
                                <span class="d-none d-sm-block">Upload new photo</span>
                                <i class="bx bx-upload d-block d-sm-none"></i>
                                <input type="file" id="image" name="image" class="account-file-input" hidden=""
                                    accept="image/png, image/jpeg">
                            </label>
                            <button type="button" class="btn btn-label-secondary account-image-reset mb-4"
                                id="resetButton">
                                <i class="bx bx-reset d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Reset</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account -->
        <hr class="my-0">
        <div class="card-body">
            <div class="row">
                <div class="mb-3 col-md-6 fv-plugins-icon-container">
                    <label class="form-label">Name</label>
                    <input class="form-control" type="text" maxlength="40" name="name" value="{{ Auth::user()->name }}">
                </div>
                <div class="mb-3 col-md-6 fv-plugins-icon-container">
                    <label class="form-label">Front title</label>
                    <input class="form-control" type="text" maxlength="7" name="front_title"
                        value="{{ Auth::user()->front_title }}">
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Username</label>
                    <input class="form-control" type="text" maxlength="20" name="username"
                        value="{{ Auth::user()->username }}">
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Back title</label>
                    <input class="form-control" type="text" maxlength="7" name="back_title"
                        value="{{ Auth::user()->back_title }}">
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Email</label>
                    <input class="form-control" type="email" maxlength="40" name="email"
                        value="{{ Auth::user()->email }}">
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Phone <i>(ex. 62xxxxxxxxx)</i></label>
                    <input class="form-control" type="number" name="no_phone" id="phone"
                        value="{{ Auth::user()->no_phone }}" placeholder="62xxxxxxxxxx">
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">NIDN</label>
                    <input class="form-control" type="text" maxlength="20" name="nidn" id="nidn"
                        value="{{ Auth::user()->nidn }}">
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Job</label>
                    <input class="form-control" type="text" maxlength="35" name="job" value="{{ Auth::user()->job }}">
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Department</label>
                    <select name="department_id" id="department_id" class="form-select select2">
                        <option value="">Select Department</option>
                        @foreach ($departments as $department)
                        <option value="{{ $department->id }}"
                            {{ Auth::user()->department_id == $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-select @error('gender') is-invalid @enderror select2" name="gender"
                        data-placeholder="-- Select --">
                        <option value="{{ Auth::user()->gender }}">-- Select --</option>
                        <option value="M" {{ ("M"==$user->gender ? "selected": "") }}>Male</option>
                        <option value="F" {{ ("F"==$user->gender ? "selected": "") }}>Female</option>
                    </select>
                </div>
            </div>
            <div class="text-end mt-2">
                <button type="submit" class="btn btn-primary me-1" onclick="return confirmSubmit(event)">Update</button>
                <a class="btn btn-outline-secondary" href="{{ route('profile.index') }}">Back</a>
            </div>
            <input type="hidden">
        </div>
        <!-- /Account -->
    </form>
</div>
@endsection

@section('script')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>

@if(session('msg'))
<script type="text/javascript">
    //swall message notification
    $(document).ready(function () {
        swal(`{!! session('msg') !!}`, {
            icon: 'success',
            customClass: {
                confirmButton: 'btn btn-success'
            }
        });
    });

</script>
@endif

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

    function remove_zero() {
        var x = document.getElementById("phone").value;
        let number = Number(x);
        if (number == 0) {
            document.getElementById("phone").value = null;
        } else {
            document.getElementById("phone").value = number;
        }
    }

    document.getElementById('image').addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('uploadedAvatar').src = e.target.result;
            }
            reader.readAsDataURL(file);
            // Display file info
            const fileInfo = `Selected file: ${file.name} (${file.type})`;
            document.getElementById('fileInfo').textContent = fileInfo;
        }
    });

    // JavaScript to handle reset button
    document.getElementById('resetButton').addEventListener('click', function () {
        // Reset the input file
        document.getElementById('image').value = '';
        // Reset the image preview to the original image
        const originalImage = '{{ $user->image ? asset($user->image) : Auth::user()->image() }}';
        document.getElementById('uploadedAvatar').src = originalImage;
        document.getElementById('fileInfo').textContent = '';
    });

</script>
@endsection
