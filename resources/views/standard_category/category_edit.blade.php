@extends('layouts.master')
@section('content')
@section('title', 'Edit Category')

@section('css')
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
                        <div class="col-sm-6 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Status<i class="text-danger">*</i></label>
                                <select name="status" class="form-select input-sm select2 @error('status') is-invalid @enderror" data-placeholder="Status">
                                    <option value='1' {{ (1==$data->status ? "selected": "") }}>ON</option>
                                    <option value='0' {{ (0==$data->status ? "selected": "") }}>OFF</option>
                                </select>
                            </div>
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
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
@endsection
