{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Audit Plan') }}
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
@section('title', 'Audit Plans')
@section('content')

    <a href="{{ url('form') }}" class="btn btn-primary mb-3">Create Audit Plan</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Status</th>
                <th>Auditee</th>
                <th>Location</th>
                <th>Departement</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($auditPlan as $auditPlan)
                <tr>
                    <td>{{ $auditPlan->id }}</td>
                    <td>{{ $auditPlan->date }}</td>
                    <td>{{ $auditPlan->audit_plan_status_id }}</td>
                    <td>{{ $auditPlan->auditee_id }}</td>
                    <td>{{ $auditPlan->location_id }}</td>
                    <td>{{ $auditPlan->departement_id }}</td>
                    <td>
                        <a href="" class="btn btn-warning btn-sm">Edit</a>
                        <form action="" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
