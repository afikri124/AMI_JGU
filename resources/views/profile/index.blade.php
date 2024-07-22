@extends('layouts.master')
@section('title', 'Profile')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection

@section('style')
<style>

.role-container {
    display: flex;
    flex-wrap: wrap;
    gap: 1px; /* Jarak antara elemen */
}

.role-name {
    background-color: #c72c2c; /* Warna background */
    color: #fff; /* Warna teks */
    padding: 1px 10px; /* Padding di dalam elemen */
    border-radius: 7px; /* Membuat sudut elemen menjadi melengkung */
    font-size: small; /* Mengubah ukuran huruf menjadi kecil */
    font-style: italic; /* Membuat huruf menjadi miring */
    display: inline-block; /* Memastikan elemen tetap inline-block */
    text-align: center; /* Pusatkan teks di dalam elemen */
}
.img {
            height: 100px;
            width: 100px;
            border-radius: 50%;
            object-fit: cover;
            background: #dfdfdf
        }
.btn-primary {
    background-color: #c72c2c;
    border-color: #dfdfdf;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}

.bx-user-check {
    font-size: 1.2em; /* Adjust icon size */
}

</style>
@endsection


@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
<div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
    <div class="card">
<div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-12">
                        <div class="user-profile-header-banner">
                        <h3 class="card-header">Profile Details</h3>
                        </div>
                        <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                            <div class="flex-shrink-3 mx-sm-4">
                                @if (Auth::user()->image)
                                <img src="{{ asset(Auth::user()->image) }}" alt="user-avatar" class="img" >
                                @else
                                <img src="{{ Auth::user()->image() }}" alt="user-avatar" class="img" >
                                @endif
                            </div>
                            <div class="flex-grow-1 mt-4">
                                <div
                                    class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                                    <div class="user-profile-info">
                                        <h5>{{ Auth::user()->name }}</h5>
                                        <ul
                                            class="list-inline mb-1 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                            <li class="list-inline-item fw-semibold">
                                                {{ Auth::user()->email }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('profile.edit') }}" class="btn btn-primary d-flex align-items-center me-2">
                                            <i class="bx bx-user-check me-2"></i>
                                            Edit Profile
                                        </a>
                                        <!-- <span>{{ Auth::user()->username }}</span> -->
                                    </div>
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
                                    <b>{{ Auth::user()->username }}</b>
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
                                <b>{{ Auth::user()->departments ? Auth::user()->departments->name : '' }}</b>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <li class="d-flex align-items-center mb-3"><i class="bx bx-user"></i>
                                <span class="fw-semibold mx-2">Job:</span>
                                <div class="col-sm-6">
                                    <b>{{ Auth::user()->job }}</b>
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
                                <div class="col-sm-9">
                                    <span class="background-span">
                                        @if(Auth::user()->roles->count() == 0)
                                        <p class="p-0 mb-0 text-danger">You don't have access rights, please contact the
                                            administrator!</p>
                                        @else
                                            @foreach(Auth::user()->roles as $x)
                                        <i class="text-white role-name">{{ $x->name }}</i>
                                            @endforeach
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Header -->
        </div>
        <!-- / Content -->
        </div>
    </div>
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
