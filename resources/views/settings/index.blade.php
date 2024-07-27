@extends('layouts.master')
@section('title', 'SETTING | PASSWORD')

<style>
        body, html {
            height: 100%;
            margin: 0;

        }

        .container-centered {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .form-container {
            width: 100%;
            max-width: 515px;
            padding: 33px;
            border: 3px solid #ccc;
            border-radius: 15px;
            background-color: #f9f9f9;
        }
        .text-right {
            text-align: right;
        }
    </style>

@section('content')
    <div class="container-centered">
        <div class="form-container">
        <div class="header-logo-wrapper col-auto p-0">
            <div class="logo-wrapper"><a href="{{ url('/') }}"><img class="img-fluid"
                        src="" alt=""></a></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="align-center"></i>
            </div>
        </div>
            <h2 class="text-center"><b>Change Password</b></h2>
            <br>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('settings.changePassword') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="current_password">Current Password:</label>
                    <input type="password" class="form-control" id="current_password" name="current_password" required placeholder="Masukkan Password Anda Saat Ini">
                    <div class="show-hide"><span class="show"> </span></div>
                </div><br>

                <div class="form-group">
                    <label for="new_password">New Password:</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" required placeholder="Masukkan Password Baru Anda">
                </div><br>

                <div class="form-group">
                    <label for="new_password_confirmation">Confirm New Password:</label>
                    <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required placeholder="Masukkan Kembali Password Baru Anda">
                </div>
<br>
                <div class="form-group text-right">
                <button type="submit" class="btn btn-primary">Change</button>
            </form>
        </div>
    </div>
@endsection
