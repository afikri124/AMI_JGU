@extends('layouts.master')
@section('title', 'Remark Document')

<style>
</style>

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5><b>Remark Document</b></h5>
                    <div class="form-group">
                        <textarea class="form-control" id="remark_docs" name="remark_docs" rows="3" readonly>{{ $data->remark_docs }}</textarea>
                    </div>
                    <p></p>
                    <div class="text-end">
                        <a href="{{ url()->previous() }}">
                            <span class="btn btn-secondary">Back</span>
                        </a>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection
