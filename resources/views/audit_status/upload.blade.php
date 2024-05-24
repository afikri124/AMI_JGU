@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Profil</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <fieldset>
                            <div class="row">
                                <div class="mb-3 col-lg-12 col-md-12">
                                    <label>Photo documentation<i class="text-danger">*</i></label>
                                    <input class="form-control" name="image_path" type="file" accept="image/*"
                                        title="Photo documentation" data-bs-original-title="" title="only accept image"
                                        required>
                                </div>
                                <div class="mb-3 col-lg-12 col-md-12">
                                    <label>Overall Comment<i class="text-danger">*</i> <i id="count"
                                            class="text-danger">(0/350)</i></label>
                                    <textarea class="form-control" id="remark" name="remark" title="Overall comment"
                                        minlength="350" required
                                        rows="5">{{ (old('remark')==null ? $data->remark : old('remark')) }}</textarea>
                                    <i class="invalid-feedback d-block">Note: The remark must be at least 350
                                        characters.</i>
                                </div>
                            </div>
                            <div class="f1-buttons">
                                <button class="btn btn-secondary btn-previous" type="button">Previous</button>
                                <input class="btn btn-primary btn-submit" type="submit" name="submit" value="Submit">
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
