@extends('layouts.master')
@section('title', 'Audit Details')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3>Remark Documents</h3>
                    <div class="form-group">
                        <label for="remark_docs">Remark Document Review</label>
                        <textarea class="form-control" id="remark_docs" name="remark_docs" rows="3" readonly>{{ $data->remark_docs }}</textarea>
                    </div>
                    <p></p>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
