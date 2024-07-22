@extends('layouts.master')
@section('content')
@section('title', 'Edit Criteria')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
@endsection

<style>

</style>

<div class="container-fluid flex-grow-1 container-p-y">
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
                <form action="{{ route('standard_criteria.criteria_update', $data->id) }}" method="POST">
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
                                    <label for="title" class="col-form-label">Title<i class="text-danger">*</i></label>
                                    <textarea class="form-control"  maxlength="175" placeholder="Note: Maximum 175 char...." rows="2" name="title" id="title">{{ $data->title }}</textarea>
                                </div>
                            </div>
                            <br>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary me-1">Update</button>
                                <a class="btn btn-outline-secondary" href="{{ route('standard_criteria.criteria') }}">Back</a>
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
</script>
@endsection
