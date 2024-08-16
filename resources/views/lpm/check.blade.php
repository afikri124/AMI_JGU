@extends('layouts.master')
@section('title', 'Review Standard By LPM')

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
    <form action="{{ route('lpm.lpm_as', $data->id) }}" method="POST" enctype="multipart/form-data">
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
                <td style="width: 60%">
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
            </tr>
        </div>
      </div>
      </table>
      <hr>
      @endforeach
      @endforeach
    @endforeach
    <div class="card-footer text-end">
        <button class="btn btn-primary me-1" type="submit" name="remark_standard_lpm" value="Approve">Approve</button>
        <button id="submitButton" class="btn btn-dark me-1" type="submit">Revision</button>
    </div>
    </form>
  </div>
  </div>

    <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel"><i><b>Standard approval comment by LPM</b></i></h4>
                <a href="" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-body">
                <form id="upload-form" method="POST" action="" enctype="multipart/form-data" style="display: inline;">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="remark_standard_lpm" class="form-label large-text"><b>Remark Standard By LPM</b></label>
                        <textarea class="form-control" id="modal-remark_standard_lpm" name="remark_standard_lpm" rows="3" placeholder="MAX 350 character..."></textarea>
                        <i class="text-danger"><b>* Please comment on why you disagree with this standard</b></i>
                    </div>
                    <div class="text-end" id="button-container">
                        <button class="btn btn-primary me-1" type="submit">Revised</button>
                    </form>
                        <a href="">
                            <span class="btn btn-outline-secondary">Back</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
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

    document.addEventListener('DOMContentLoaded', function() {
    // Menangani klik tombol submit
    document.getElementById('submitButton').addEventListener('click', function(event) {
        // Mencegah form dari pengiriman default
        event.preventDefault();

        // Menampilkan modal
        $('#uploadModal').modal('show');
    });
});

    function showModal(element) {
        var id = $(element).data('id');
        var remark_standard_lpm = $(element).data('remark_standard_lpm');
        $('#modal-remark_standard_lpm').text(remark_standard_lpm).attr('href', remark_standard_lpm);
        $('#upload-form').attr('action', '/lpm/lpm_standard/' + id);
        $('#uploadModal').modal('show');
    }
</script>
@endsection
