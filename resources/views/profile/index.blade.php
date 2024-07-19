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
</style>
@endsection


@section('content')

<div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Header -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="user-profile-header-banner">
                        <h3 class="card-header">Profile Details</h3>
                        </div>
                        <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                            <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                                @if (Auth::user()->image)
                                <img src="{{ asset(Auth::user()->image) }}" class="img" width="100px">
                                @else
                                <img src="{{ Auth::user()->image() }}" class="img" width="100px">
                                @endif
                            </div>
                            <div class="flex-grow-1 mt-4">
                                <div
                                    class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                                    <div class="user-profile-info">
                                        <h5>{{ Auth::user()->name }}</h5>
                                        <ul
                                            class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                            <li class="list-inline-item fw-semibold">
                                                {{ Auth::user()->email }}
                                            </li>
                                        </ul>
                                    </div>
                                    <a href="{{ route('profile.edit') }}"
                                        class="btn btn-primary text-nowrap">
                                        <i class='bx bx-user-check'></i> {{ Auth::user()->username }}
                                    </a>
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
                                <b>{{ Auth::user()->departments ? Auth::user()->departments->name : 'No Department' }}</b>
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
                                        <i class="text-white role-name"">{{ $x->name }}</i>
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
