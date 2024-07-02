@extends('layouts.master')
@section('content')
@section('title', 'Edit Category')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/sweetalert2.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
@endsection

<div class="row">
    <div class="col-md-12">
        @if(session('msg'))
        <div class="alert alert-primary alert-dismissible" role="alert">
            {{session('msg')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <div class="card mb-4">
            <!-- Account -->
            <hr class="my-0">
            <div class="card-body">
                <form action="{{ route('standard_category.category_update', $data->id) }}" method="POST">
                    <div class="row">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                        <div class="col-md-3 fv-plugins-icon-container">
                            <label for="audit_status_id" class="form-label" >Status</label>
                            <select name="audit_status_id" id="audit_status_id" class="form-select select2" required>
                                <option value="">Select Status</option>
                                @foreach($status as $x)
                                    <option value="{{ $x->id }}" {{ old('audit_status_id', $data->audit_status_id) == $x->id ? 'selected' : '' }}>
                                        {{ $x->title }}
                                    </option>
                                @endforeach
                            </select>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label for="description" class="col-form-label">Description</label>
                                    <textarea class="form-control" rows="2" name="description" id="description">{{ $data->description }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <div class="form-check checkbox checkbox-default mb-0">
                                        <input class="form-check-input" id="is_required" type="checkbox" value="1" name="is_required" {{ $data->is_required ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_required">Comments are required for this category.</label>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Submit</button>
                                <a class="btn btn-outline-secondary" href="{{ route('standard_category.category') }}">Back</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
                @endsection

@section('script')
<script src="{{asset('assets/vendor/libs/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/datatables-bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/datatables.responsive.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/responsive.bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/datatables.checkboxes.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/datatables-buttons.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/buttons.bootstrap5.js')}}"></script>
<script src="{{asset('assets/js/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
@endsection
