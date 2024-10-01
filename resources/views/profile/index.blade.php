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
        gap: 1px;
    }

    .img {
        height: 100px;
        width: 100px;
        border-radius: 50%;
        object-fit: cover;
        background: #dfdfdf
    }

    .bx-user-check {
        font-size: 1.2em;
    }

</style>
@endsection


@section('content')
<div class="card">
    <div class="card-header d-flex flex-column flex-sm-row text-sm-start">
        <div class="flex-shrink-3 mx-sm-4">
            @if (Auth::user()->image)
            <img src="{{ asset(Auth::user()->image) }}" alt="user-avatar" class="img">
            @else
            <img src="{{ Auth::user()->image() }}" alt="user-avatar" class="img">
            @endif
        </div>
        <div class="flex-grow-1 mt-4">
            <div
                class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                <div class="user-profile-info">
                    <h5>
                        {{ Auth::user()->front_title }}
                        {{ Auth::user()->name }}
                        {{ Auth::user()->back_title }}
                    </h5>
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
                </div>
            </div>
        </div>
    </div>
    <hr class="my-0">
    <div class="card-body">
        <div class="mb-1 row">
            <div class="col-md-6 px-3">
                <i class="bx bx-user"></i>
                <span class="fw-semibold mx-2">Name:</span>
                <b>
                    {{ Auth::user()->front_title }}
                    {{ Auth::user()->name }}
                    {{ Auth::user()->back_title }}
                </b>
            </div>
            <div class="col-md-6 px-3">
                <i class="bx bx-user-check"></i>
                <span class="fw-semibold mx-2">Username:</span>
                <b>
                    <b>{{ Auth::user()->username }}</b>
                </b>
            </div>
            <div class="col-md-6 px-3">
                <i class="bx bx-envelope"></i>
                <span class="fw-semibold mx-2">Email:</span>
                <b>
                    <b>{{ Auth::user()->email }}</b>
                </b>
            </div>
            <div class="col-md-6 px-3">
                <i class="bx bx-mobile-alt"></i>
                <span class="fw-semibold mx-2">Phone:</span>
                <b>
                    <b>{{ Auth::user()->no_phone }}</b>
                </b>
            </div>
            <div class="col-md-6 px-3">
                <i class="bx bx-briefcase"></i>
                <span class="fw-semibold mx-2">NIDN:</span>
                <b>
                    <b>{{ Auth::user()->nidn }}</b>
                </b>
            </div>
            <div class="col-md-6 px-3">
                <i class="bx bx-buildings"></i>
                <span class="fw-semibold mx-2">Department:</span>
                <b>
                    <b>{{ Auth::user()->departments ? Auth::user()->departments->name : '' }}</b>
                </b>
            </div>
            <div class="col-md-6 px-3">
                <i class="bx bx-user"></i>
                <span class="fw-semibold mx-2">Job:</span>
                <b>
                    <b>{{ Auth::user()->job }}</b>
                </b>
            </div>
            <div class="col-md-6 px-3">
                <i class="bx bx-male-sign"></i>
                <span class="fw-semibold mx-2">Gender:</span>
                <b>
                    <b>{{ Auth::user()->gender }}</b>
                </b>
            </div>
            <div class="col-md-6 px-3">
                <i class="bx bx-face"></i>
                <span class="fw-semibold mx-2">Roles:</span>
                <b>
                    @if(Auth::user()->roles->count() == 0)
                    <p class="p-0 mb-0 text-danger">You don't have access rights, please contact
                        the
                        administrator!</p>
                    @else
                    @foreach(Auth::user()->roles as $x)
                    <span class="badge rounded-pill bg-label-primary">{{ $x->name }}</span>
                    @endforeach
                    @endif
                </b>
            </div>

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

    function remove_zero() {
        var x = document.getElementById("phone").value;
        let number = Number(x);
        if (number == 0) {
            document.getElementById("phone").value = null;
        } else {
            document.getElementById("phone").value = number;
        }
    }

</script>
@endsection
