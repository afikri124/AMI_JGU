<!-- resources/views/audit_plan_statuses/index.blade.php -->

@extends('layouts.master')
@section('title', 'Audit Status')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Audit Plan Statuses</div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Title</th>
                                    <th>Remark by LPM</th>
                                    <th>Remark by Approver</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($auditPlanStatuses as $status)
                                    <tr>
                                        <td>{{ $status->id }}</td>
                                        <td>{{ $status->name }}</td>
                                        <td>{{ $status->title }}</td>
                                        <td>{{ $status->remark_by_lpm }}</td>
                                        <td>{{ $status->remark_by_approver }}</td>
                                        <td>
                                            <a href="" class="btn btn-primary">Edit</a>
                                            <form action="" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
