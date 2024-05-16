{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
</h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                {{ __("You're logged in!") }}
            </div>
        </div>
    </div>
</div>
</x-app-layout> --}}
@extends('layouts.master')
@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1>Hi, <b>{{ Auth::user()->name }}</b>!</h1>
                    {{ __("You're logged in!") }}
                    <br>
                    @if(Auth::user()->roles->count() == 0)
                    <p class="p-0 mb-0 text-danger">Sorry, you don't have access rights, please contact administrator!
                    </p>
                    @else
                    <p class="mb-2">You have access rights as
                        @foreach(Auth::user()->roles as $x)
                        <i class="badge rounded-pill m-0" style="background-color:{{ $x->color }}">{{ $x->name }}</i>
                        @endforeach
                    </p>
                    @endif

            <div class="row">
        <div class="col-xl-6 col-lg-12 xl-50 morning-sec box-col-12">
            <div class="card profile-greeting">
                <div class="card-body pb-0">
                    <div class="media">
                        <div class="media-body">
                            <div class="greeting-user m-0">
                                <h4 class="f-w-600 font-light m-0" id="greeting">Good Morning</h4>
                                <h3>{{ Auth::user()->name }}</h3>
                                <i>{{ Auth::user()->email }}   {{ Auth::user()->phone }}</i>
                                @if(Auth::user()->roles->count() == 0)
                                <p class="p-0 mb-0 text-danger">You don't have access rights, please contact the
                                    administrator!</p>
                                @else
                                <p class="p-0 mb-0 font-light">You have access rights as:</p>
                                @foreach(Auth::user()->roles as $x)
                                <i class="badge badge-secondary m-0">{{ $x->title }}</i>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        <h4>
                            <div class="badge f-10 rounded-pill badge-primary"><i class="fa fa-clock-o"></i> <span
                                    id="txt"></span>
                            </div>
                        </h4>
                    </div>
                    <div class="cartoon"><img class="img-fluid" src="{{asset('/assets/images/cartoon.png')}}"
                            style="max-width: 90%;" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
        </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
