@extends('layouts.master')
@section('title', 'Observations')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/wizard.css')}}" />
<link rel="stylesheet" href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/assets/vendor/libs/bs-stepper/bs-stepper.css" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/dropzone/dropzone.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/katex.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/typography.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}">
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
<div id="wizard-validation" >
<div class="bs-stepper wizard-icons wizard-icons-example mt-2 p-3">
  <div class="bs-stepper-header">
    <div class="step" data-target="#account-details">
      <button type="button" class="step-trigger">
        <span class="bs-stepper-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgb(36, 34, 34);"><path d="M15 11h7v2h-7zm1 4h6v2h-6zm-2-8h8v2h-8zM4 19h10v-1c0-2.757-2.243-5-5-5H7c-2.757 0-5 2.243-5 5v1h2zm4-7c1.995 0 3.5-1.505 3.5-3.5S9.995 5 8 5 4.5 6.505 4.5 8.5 6.005 12 8 12z"></path></svg>
        </span>
        <span class="bs-stepper-label">Account Details</span>
      </button>
    </div>
    <div class="line">
      <i class="bx bx-chevron-right"></i>
    </div>
    <div class="step" data-target="#address">
      <button type="button" class="step-trigger">
        <span class="bs-stepper-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);"><path d="M19 4h-3V2h-2v2h-4V2H8v2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2h14c1.103 0 2-.897 2-2V6c0-1.103-.897-2-2-2zM5 20V7h14V6l.002 14H5z"></path><path d="M7 9h10v2H7zm0 4h5v2H7z"></path></svg>
          </svg>
        </span>
        <span class="bs-stepper-label">Assesment</span>
      </button>
    </div>
  </div>

  <div class="bs-stepper-content">
  <form id="wizard-validation-form" method="POST" action="{{ route('make', $data->id) }}"
    enctype="multipart/form-data">
    @csrf
    <!-- Account Details -->
      <div id="account-details" class="content">
        <div class="content-header mb-3">
          <h6 class="mb-0">Account Details</h6>
          <small>Enter Your Account Details.</small>
        </div>
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label" for="auditee"><b>Auditee</b><i class="text-danger">*</i></label>
            <input class="form-control bg-user" type="text" value="{{ $data->auditee->name}}" readonly>
          </div>
          <div class="col-md-6">
            <label for="auditor_id" class="form-label"><b>Auditor</b><i class="text-danger">*</i></label>
            <input id="auditor_id" type="text" class="form-control bg-user" value="{{$auditorData->auditor->name}}" readonly></input>
        </div>
          <div class="col-md-6">
            <div class="form-group">
            <label for="location_id" class="form-label"><b>Location</b><i class="text-danger">*</i></label>
            <select name="location_id" id="location_id" class="form-select select2" required>
            <option value="">Select Location</option>
            @foreach($locations as $d)
                <option value="{{$d->id}}" {{ $data->location_id == $d->id ? 'selected' : '' }}>
                    {{$d->title}}</option>
            @endforeach
            </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
            <label for="department_id" class="form-label"><b>Department</b><i class="text-danger">*</i></label>
            <input id="department_id" type="text" class="form-control bg-user" value="{{$data->departments->name}}" readonly></input>
            </div>
        </div>
        <div class="col-12 d-flex justify-content-between">
            <button class="btn btn-label-secondary btn-prev" disabled> <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
              <span class="align-middle d-sm-inline-block d-none">Previous</span>
            </button>

            <!-- <button id="btnNext" class="btn btn-primary btn-next" disabled>
                <span class="align-middle d-sm-inline-block d-none">Next</span>
                <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
            </button>

            <script>
                // Menyimpan referensi ke tombol Next
                const btnNext = document.getElementById('btnNext');

                // Event listener untuk mengecek validasi sebelum mengaktifkan tombol Next
                document.addEventListener('DOMContentLoaded', function() {
                    // Menambahkan event listener ke setiap input yang diperlukan
                    const inputsRequired = document.querySelectorAll('input[required], select[required], textarea[required]');

                    inputsRequired.forEach(input => {
                        const checkInputs = () => {
                            const allInputsFilled = Array.from(inputsRequired).every(input => input.value.trim() !== '');
                            btnNext.disabled = !allInputsFilled;
                        };

                        if (input.classList.contains('select2')) {
                            $(input).on('change', checkInputs); // Event listener untuk select2
                        } else {
                            input.addEventListener('input', checkInputs);
                        }
                    });
                });
            </script> -->
            <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none" >Next</span> <i class="bx bx-chevron-right bx-sm me-sm-n2"></i></button>
          </div>
        </div>
      </div>

      <div id="address" class="content">
      <div class="content-header mb-3">
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
        <table class="table table-bordered">
            <tr>
                <th><b>Standard Statement</b></th>
                <td>
                    <a href="{{ $data->link }}" target="_blank">{{ $data->link }}</a>
                    @error('link')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </td>
            </tr>
            <tr>
                <td style="width: 60%">
                    <ul class="text-primary">{{ $loop->parent->iteration }}. {{ $statement->name }}</ul>
                </td>
                <td style="width: 35%">
                    <div id="data-sets">
                        <div id="data-set">
                            <div class="checkbox-group">
                                <input type="radio" name="obs_checklist_option[{{ $statement->id }}]" value="KS" required />
                                <label for="ks">KS</label>
                            </div>
                            <div class="checkbox-group">
                                <input type="radio" name="obs_checklist_option[{{ $statement->id }}]" value="OBS" required />
                                <label for="obs">OBS</label>
                            </div>
                            <div class="checkbox-group">
                                <input type="radio" name="obs_checklist_option[{{ $statement->id }}]" value="KTS Minor" required />
                                <label for="kts_minor">KTS MINOR</label>
                            </div>
                            <div class="checkbox-group">
                                <input type="radio" name="obs_checklist_option[{{ $statement->id }}]" value="KTS Mayor" required />
                                <label for="kts_mayor">KTS MAYOR</label>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="width: 60%">
                    <strong>Indicator</strong>
                    <ul>{!! $indicator->name !!}</ul>
                </td>
            </tr>
            <tr>
                <td style="width: 60%" id="review-docs">
                    <strong>Review Document</strong>
                    @foreach ($statement->reviewDocs as $reviewDoc)
                        <ul>{!! $reviewDoc->name !!}</ul>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <label for="remark_description" class="form-label"><b>Deskripsi Audit  :</b><i class="text-danger">*</i></label>
                    <textarea id="remark_description" name="remark_description[{{ $statement->id }}]"
                              class="form-control" maxlength="250" placeholder="MAX 250 characters..."></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <label for="remark_success_failed" class="form-label"><b>Faktor Pendukung Keberhasilan/Kegagalan:</b><i class="text-danger">*</i></label>
                    <textarea id="remark_success_failed" name="remark_success_failed[{{ $statement->id }}]"
                              class="form-control" maxlength="250" placeholder="MAX 250 characters..."></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <label for="remark_recommend" class="form-label"><b>Rekomendasi Audit  :</b><i class="text-danger">*</i></label>
                    <textarea name="remark_recommend[{{ $statement->id }}]"
                              class="form-control" maxlength="250" placeholder="MAX 250 characters..."></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <label for="remark_upgrade_repair" class="form-label"><b>Rencana Peningkatan/Perbaikan:</b><i class="text-danger">*</i></label>
                    <textarea type="text" id="remark_upgrade_repair" class="form-control"
                              name="remark_upgrade_repair[{{ $statement->id }}]" maxlength="250"
                              placeholder="MAX 250 characters..."></textarea>
                </td>
            </tr>
        </table>
    @endforeach
@endforeach

    <hr class="text-dark">
@endforeach
            <div class="row">
                <div class="col-lg-6 col-md-6 mb-3">
                    <label for="person_in_charge" class="form-label"><b>Pihak yang Bertanggung Jawab</b><i class="text-danger">*</i></label>
                    <input type="text" id="person_in_charge" class="form-control" name="person_in_charge[{{ $statement->id }}]" placeholder="Pihak Bertanggung Jawab...">
                </div>
                <div class="col-lg-6 col-md-6 mb-3">
                    <label for="plan_completed" class="form-label"><b>Jadwal Penyelesaian</b><i class="text-danger">*</i></label>
                    <input type="date" class="form-control" name="plan_completed[{{ $statement->id }}]" id="plan_completed" placeholder="YYYY-MM-DD">
                </div>
            </div>
            <div class="col-sm-12 fv-plugins-icon-container">
                <label class="form-label" for="basicDate"><b>Remark</b><i class="text-danger">*</i></label></label>
                <div class="input-group input-group-merge has-validation">
                    <textarea type="text" class="form-control @error('remark_plan') is-invalid @enderror"
                    name="remark_plan" placeholder="MAX 250 characters..."></textarea>
                    @error('remark_plan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12 d-flex justify-content-between">
                    <button class="btn btn-primary btn-prev">
                        <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                    </button>
                    <button class="btn btn-primary btn-submit">Submit</button>
                </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
  </div>
@endsection

@section('script')
    <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/bs-stepper/bs-stepper.js')}}"></script>
    <script src="{{ asset('assets/vendor/libs/form-wizard-validation/form-wizard-validation.js') }}"></script>
    <script src="{{ asset('assets/js/forms-file-upload.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/quill/katex.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/quill/quill.js') }}"></script>
    <script src="{{ asset('assets/js/forms-editors.js') }}"></script>
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/documentation/assets/vendor/libs/bs-stepper/bs-stepper.js">
    </script>
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/documentation/assets/vendor/libs/@form-validation/popular.js">
    </script>
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/documentation/assets/vendor/libs/@form-validation/bootstrap5.js">
    </script>
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/documentation/assets/vendor/libs/@form-validation/auto-focus.js">
    </script>
    <script>
        var quill = new Quill('#editor-container', {
            theme: 'snow'
        });

        // Sync the content of the Quill editor with the textarea
        quill.on('text-change', function() {
            var notes = document.querySelector('textarea[name=notes]');
            notes.value = quill.root.innerHTML;
        });

        // If the textarea already has content, load it into Quill
        var notes = document.querySelector('textarea[name=notes]').value;
        if (notes) {
            quill.root.innerHTML = notes;
        }
    </script>
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

    // $(document).ready(function() {

    //             $("#remark_description").prop('disabled', true).attr('data-placeholder',
    //                 'Remark Descripstion data is required');
    //             $("#obs_checklist_option").prop('disabled', true).attr('data-placeholder',
    //                 'Form Checklist data is required');
    //             $("#remark_success_failed").prop('disabled', true).attr('data-placeholder',
    //                 'Remark success failed data is required');
    //             $("#remark_recommend").prop('disabled', true).attr('data-placeholder',
    //                 'Remark Recommend data is required');
    //             $("#remark_upgrade_repair").prop('disabled', true).attr('data-placeholder',
    //                 'Remark Upgrade Repair data is required');
    //             $("#person_in_charge").prop('disabled', true).attr('data-placeholder',
    //                 'Person In Charge data is required');
    //             $("#plan_completed").prop('disabled', true).attr('data-placeholder',
    //                 'Plan Complated data is required');
    //         });
</script>
<script>
    const wizardIcons = document.querySelector('.wizard-icons-example');

    if (typeof wizardIcons !== undefined && wizardIcons !== null) {
        const wizardIconsBtnNextList = [].slice.call(wizardIcons.querySelectorAll('.btn-next')),
              wizardIconsBtnPrevList = [].slice.call(wizardIcons.querySelectorAll('.btn-prev')),
              wizardIconsBtnSubmit = wizardIcons.querySelector('.btn-submit');

        const iconsStepper = new Stepper(wizardIcons, {
            linear: false
        });

        if (wizardIconsBtnNextList) {
            wizardIconsBtnNextList.forEach(wizardIconsBtnNext => {
                wizardIconsBtnNext.addEventListener('click', event => {
                    iconsStepper.next();
                });
            });
        }

        if (wizardIconsBtnPrevList) {
            wizardIconsBtnPrevList.forEach(wizardIconsBtnPrev => {
                wizardIconsBtnPrev.addEventListener('click', event => {
                    iconsStepper.previous();
                });
            });
        }
    }
    </script>
@endsection
