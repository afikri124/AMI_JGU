@extends('layouts.master')

@section('content')
@section('title', 'Create List Document')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
@endsection

<div class="row">
      <div class="col-md-12">
            @if(session('msg'))
            <div class="alert alert-primary alert-dismissible" role="alert">
                  {{ session('msg') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="card mb-4">
                  <hr class="my-0">
                  <div class="card-header">Review Document</div>
                  <div class="card-body">
                  <form id="form-add-new-record" method="POST" action="{{ route('store_docs.review_docs') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group col-md-4">
                              <label for="indicator_id" class="form-label">Select Indicator<i class="text-danger">*</i></label>
                              <select class="form-select digits select2 @error('indicator_id') is-invalid @enderror"
                                    name="indicator_id" id="indicator_id" data-placeholder="Select">
                              <option value="" selected disabled>Select Indicator</option>
                              @foreach($indicators as $c)
                                    <option value="{{ $c->id }}" {{ old('indicator_id') == $c->id ? 'selected' : '' }}>
                                          {{ $c->name }}
                                    </option>
                              @endforeach
                              </select>
                              @error('indicator_id')
                              <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                        </div>


                        <div class="form-group col-md-4">
                              <label for="numForms">Number of Forms</label>
                              <input type="number" class="form-control" id="numForms" name="numForms" min="1">
                        </div>

                        <div id="dynamic-form-container"></div>

                        <div class="col-sm-12 mt-4">
                              <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">Create</button>
                              <a href="{{ route('standard_criteria.review_docs')}}">
                              <span class="btn btn-outline-secondary">Back</span>
                              </a>
                        </div>
                  </form>
                  </div>
            </div>
      </div>
      </div>

      @section('script')
      <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
      <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
      <script>
      document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('numForms').addEventListener('input', function() {
            var numForms = this.value;
            var container = document.getElementById('dynamic-form-container');
            container.innerHTML = ''; // Clear existing forms

            for (var i = 0; i < numForms; i++) {
                  var row = `
                  <p></p>
                  <div class="row mb-3">
                              <div class="form-group">
                              <label for="inputField${i + 1}_1">Review Document<i class="text-danger">*</i></label>
                              <input type="hidden"  class="form-control" id="inputField${i + 1}_1" name="review_docs[${i}][name]"></input>
                              <trix-editor input="inputField${i + 1}_1"></trix-editor>
                              </div>
                        </div>
                  `;
                  container.insertAdjacentHTML('beforeend', row);
            }
      });
});
</script>
<!-- <div class="col-md-4">
                        <div class="form-group">
                            <label for="inputField${i + 1}_2">Sub Indikator</label>
                            <textarea type="text-danger" class="form-control" id="inputField${i + 1}_2" name="indicators[${i}][sub_indicator]"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="inputField${i + 1}_3">Review Document</label>
                            <textarea type="text-danger" class="form-control" id="inputField${i + 1}_3" name="indicators[${i}][review_document]"></textarea>
                        </div>
                    </div> -->
@endsection
@endsection
