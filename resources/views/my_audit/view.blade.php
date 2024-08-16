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
        width: 200px; /* set a width for the wrapping container */
        word-wrap: break-word /* ensures the text wraps to the next line if it overflows the container */
    }
    .bg-user {
        background-color: #ddd;
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
    <form action="{{ route('my_audit.my_standard', $data->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
      <strong style="color: black;">CATEGORY STANDARD</strong>
        @foreach ($standardCategories as $category)
            <h6 class="mb-0" name="standard_category_id" id="standard_category_id">
                {{ $category->description }}
            </h6>
        @endforeach
        <p></p>

        <strong style="color: black;">CRITERIA STANDARD</strong>
        @foreach ($standardCriterias as $criteria)
            <h6 class="mb-0" name="standard_criteria_id" id="standard_criteria_id">
                {{ $criteria->title }}
            </h6>
        @endforeach
        <p></p>
    @foreach ($standardCriterias as $criteria)
        <h6 style="color: black;"><b>{{ $loop->iteration }}. {{ $criteria->title }}</b></h6>

    @foreach ($criteria->statements as $no => $statement)
    @foreach ($statement->indicators as $indicator)
        <table class="table table-bordered">
            <tr>
                <td style="width: 65%">
                    <ul style="color: black;">{{ $loop->parent->iteration }}. {{ $statement->name }}</ul>
                </td>
            </tr>
            <tr>
                <td style="width: 60%">
                    <strong>Indicator</strong>
                    <ul>{!! $indicator->name !!}</ul>
                </td>
            <tr>
                <td style="width: 60%" id="review-docs">
                    <strong>Review Document</strong>
                    @foreach ($statement->reviewDocs as $reviewDoc)
                        <ul>{!! $reviewDoc->name !!}</ul>
                    @endforeach
                </td>
                <td>
                    <div class="form-group mb-3">
                        <label for="doc_path" class="form-label large-text"><b>Upload Document</b><i class="text-danger">*</i></label>
                        <input type="file" class="form-control" name="doc_path[]" accept=".pdf">
                        <input type="hidden" name="indicator_ids[]" value="{{ $indicator->id }}">
                        <br>
                        </div>
                </td>
            </tr>
        </div>
      </div>
    </table>   
    </table>   
    <hr>
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
