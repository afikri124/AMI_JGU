@extends('layouts.master')
@section('title', 'Upload Document Audit')

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
        @if(session('msg'))
            <div class="alert alert-primary alert-dismissible" role="alert">
                  {{session('msg')}}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
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
            @php
                $checklist = $obsChecklist->where('indicator_id', $indicator->id)->first();
            @endphp
            <form action="{{ route('my_audit.my_standard', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
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
                        <td>
                            <div class="form-group mb-3">
                                <label for="doc_path" class="form-label large-text"><b>Upload Document</b>
                                    <i class="text-danger">* </i><i style="color: black;">MAX. 50mb</i></label>
                                <input type="file" class="form-control @error('doc_path') is-invalid @enderror" name="doc_path" accept=".png,.jpg,.jpeg,.pdf,.xls,.xlsx">
                                <input type="hidden" name="indicator_id" value="{{ $indicator->id }}">
                                @if($checklist && $checklist->doc_path)
                                    @php
                                        $fileName = basename($checklist->doc_path);
                                        $fileNameWithoutId = preg_replace('/^\d+_/', '', $fileName); // Menghilangkan ID di depan nama file
                                    @endphp
                                    <div class="mt-2">
                                        <a href="{{ asset($checklist->doc_path) }}" target="_blank" style="word-wrap: break-word; display: inline-block; max-width: 450px;">
                                            {{ $fileNameWithoutId }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </td>                        
                    </tr>
                    <tr>
                        <td style="width: 60%">
                            <strong>Review Document</strong>
                            @foreach ($statement->reviewDocs as $reviewDoc)
                                <ul>{!! $reviewDoc->name !!}</ul>
                            @endforeach
                        </td>
                        <td>
                            <div>
                                <label class="form-label" for="basicDate"><b>Remark Document By Auditee</b></label>
                                <div class="input-group input-group-merge has-validation">
                                    <textarea type="text" class="form-control @error('remark_path_auditee') is-invalid @enderror"
                                    name="remark_path_auditee" placeholder="MAX 250 characters...">{{ $checklist->remark_path_auditee ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="mt-1">
                                <button class="btn btn-success btn-sm" type="submit">Save</button>          
                                @if($checklist && $checklist->doc_path)
                                    <button formaction="{{ route('my_audit.delete_file', ['id' => $checklist->id]) }}" 
                                        class="btn btn-danger btn-sm" type="submit" 
                                        onclick="return confirm('Are you sure you want to delete this file?');">Delete</button>
                                @endif
                            </div>
                        </div>
                    </td>                      
                    </tr>
                </table>
            </form>
            <hr>
        @endforeach
        @endforeach
    @endforeach
    <div class="text-end">
        <form action="{{ route('my_audit.my_standard', $data->id) }}" method="POST">
            @csrf
            <button class="btn btn-primary me-1" type="submit" name="final_submit">Submit</button>
            <a class="btn btn-outline-primary" href="{{ route('my_audit.index') }}">Back</a>
        </form>
    </div>
</div>
</div>
@endsection

@section('script')
    <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
    @if(session('msg'))
    <script type="text/javascript">
        //swall message notification
        $(document).ready(function () {
            swal(`{!! session('msg') !!}`, {
                icon: 'success',
                customClass: {
                    confirmButton: 'btn btn-success'
                }
            });
        });
    </script>
    @endif
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
