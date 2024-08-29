@extends('layouts.master')
@section('title', 'Review Standard Auditee')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
@endsection

@section('style')
<style>
    .input-validation-error~.select2 .select2-selection {
        border: 1px solid red;
    }
    .form-container {
        width: 600px;
        margin: 50px auto;
        border: 1px solid #ccc;
        padding: 20px;
        box-shadow: 2px 2px 8px #aaa;
        border-radius: 5px;
      }
      table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
      }
      table,
      th,
      td {
        border: 1px solid #ddd;
      }
      th,
      td {
        padding: 10px;
        text-align: left;
      }
      .checkbox-group {
        display: flex;
        align-items: center;
      }
      .checkbox-group input {
        margin-right: 5px;
      }
      .comment {
        width: 100%;
        height: 50px;
        padding: 10px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
      }
      table.dataTable tbody td {
        vertical-align: middle;
        }

        table.dataTable td:nth-child(2) {
            max-width: 120px;
        }

        table.dataTable td:nth-child(3) {
            max-width: 100px;
        }
      table.dataTable td {
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }
        .text-wrapper {
        width: 100px; /* set a width for the wrapping container */
        word-wrap: break-word /* ensures the text wraps to the next line if it overflows the container */
    }
    .bg-user {
        background-color: #F5F7F8;
    }
    .hidden {
        display: none;
    }

</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
    @if ($errors->any())
    <div class="alert alert-danger outline alert-dismissible fade show" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"
            data-bs-original-title="" title=""></button>
    </div>
@endif
<div class="card mb-5">
    <div class="card-body">
    <form action="{{ route('observations.remark_doc', $data->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
      <strong class="text-primary">Category Standard</strong>
        @foreach ($standardCategories as $category)
            <h6 class="mb-0" name="standard_category_id" id="standard_category_id">
                {{ $category->description }}
            </h6>
        @endforeach
        <p></p>

        <strong class="text-primary">Criteria Standard</strong>
        @foreach ($standardCriterias as $criteria)
            <h6 class="mb-0" name="standard_criteria_id" id="standard_criteria_id">
                {{ $criteria->title }}
            </h6>
        @endforeach
        <p></p>
    @foreach ($standardCriterias as $criteria)
        <h6 class="text-primary"><b>{{ $loop->iteration }}. {{ $criteria->title }}</b></h6>

        @foreach ($criteria->statements as $no => $statement)
    @foreach ($statement->indicators as $indicator)
    @foreach ($observations as $observation)
        @php
            // Ambil daftar ObservationChecklist berdasarkan observation_id dan indicator_id
            $filteredObs = $obs_c->where('observation_id', $observation->id)
                                    ->where('indicator_id', $indicator->id);
        @endphp
        @foreach ($filteredObs as $checklist)
        <table class="table table-bordered">
            <tr>
                <td style="width: 60%">
                    <ul class="text-primary">{{ $loop->parent->iteration }}. {{ $statement->name }}</ul>
                </td>
                <td>
                    <label class="form-label"><b>Audit Document</b></label>
                    <br>
                            @if ($checklist->doc_path)
                                @php
                                    // Mengambil nama file tanpa ID di depannya jika menggunakan underscore sebagai pemisah
                                    $fileName = basename($checklist->doc_path);
                                    $fileNameWithoutId = preg_replace('/^\d+_/', '', $fileName); // Menghilangkan ID di depan nama file
                                @endphp
                                <a href="{{ asset($checklist->doc_path) }}" target="_blank" style="word-wrap: break-word; display: inline-block; max-width: 450px;">
                                    {{ $fileNameWithoutId }}
                                </a>
                            @endif
                    @error('doc_path')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </td>
            </tr>
            <tr>
                <td style="width: 10%">
                    <strong>Indicator</strong>
                    <ul>{!! $indicator->name !!}</ul>
                </td>
                <td>
                    <div>
                        <label class="form-label" for="basicDate"><b>Remark Document By Auditee</b></label>
                        <div class="input-group input-group-merge has-validation">
                            <textarea type="text" class="form-control bg-user @error('remark_path_auditee') is-invalid @enderror"
                            name="remark_path_auditee[{{ $indicator->id }}]" placeholder="MAX 250 characters..." readonly>{{ $checklist->remark_path_auditee}}</textarea>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="width: 10%" id="review-docs">
                    <strong>Review Document</strong>
                    @foreach ($statement->reviewDocs as $reviewDoc)
                        <ul>{!! $reviewDoc->name !!}</ul>
                    @endforeach
                </td>
                <td>
                    <div>
                        <label class="form-label" for="basicDate"><b>Remark Document By Auditor</b></label>
                        <div class="input-group input-group-merge has-validation">
                            <textarea type="text" class="form-control @error('remark_docs.*') is-invalid @enderror"
                                name="remark_docs[{{ $indicator->id }}]" placeholder="MAX 250 characters...">{{ old('remark_docs.' . $indicator->id) }}</textarea>
                        </div>
                    </div>
                </td>                
            </tr>
        </table>
        <hr>
        @endforeach
        @endforeach
    @endforeach
@endforeach
@endforeach
    <div class="card-footer text-end">
        <button class="btn btn-primary me-1" type="submit">Submit</button>
        <a href="{{ url()->previous() }}">
            <span class="btn btn-outline-secondary">Back</span>
        </a>
    </div>
    </form>
  </div>
  </div>
@endsection

@section('script')
    <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
    <script type="text/javascript">
    "use strict";
    setTimeout(function () {
        (function ($) {
            "use strict";
            $(".select2").select2({
                allowClear: true,
                minimumResultsForSearch: 7,
            });
        })(jQuery);
    }, 350);
</script>
@endsection
