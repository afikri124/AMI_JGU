@extends('layouts.master')
@section('title', 'Observations')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/wizard.css')}}" />
<link rel="stylesheet" href="assets/vendor/libs/flatpickr/flatpickr.css" />
<link rel="stylesheet" href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/assets/vendor/libs/bs-stepper/bs-stepper.css" />
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
            <select name="auditor_id" id="auditor_id" class="form-select bg-user" readonly>
                @foreach($auditor as $role)
                    <option value="{{$role->id}}" {{ $auditorData->auditor_id == $role->id ? 'selected' : '' }}>
                        {{$role->name}}
                    </option>
                @endforeach
            </select>
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
            <select name="department_id" id="department_id" class="form-select bg-user" readonly>
            @foreach($department as $role)
                    <option value="{{$role->id}}" {{ $data->department_id == $role->id ? 'selected' : '' }}>
                        {{$role->name}}
                    </option>
                @endforeach
            </select>
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
      <small>Category Standard</small>
@foreach ($standardCategories as $category)
    <h6 class="mb-0" name="standard_category_id" id="standard_category_id">
        {{ $category->description }}
    </h6>
@endforeach
<p></p>

<small>Criteria Standard</small>
@foreach ($standardCriterias as $criteria)
    <h6 class="mb-0" name="standard_criteria_id" id="standard_criteria_id">
        {{ $criteria->title }}
    </h6>
@endforeach
<p></p>
@foreach ($standardCriterias as $criteria)
    <h6><b>{{ $loop->iteration }}. {{ $criteria->title }}</b></h6>
    @foreach ($indicators as $indicator)
        @if ($indicator->standard_criteria_id == $criteria->id)
            <table class="table table-bordered">
                <tr>
                    <th><b>Indicator</b></th>
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
                        <ul>{{ $indicator->name }}</ul>
                    </td>
                    <td style="width: 35%">
                        <div id="data-sets">
                            <div id="data-set">
                                <div class="checkbox-group">
                                    <input type="checkbox" id="ks" name="obs_checklist_option" value="KS" />
                                    <label for="ks">KS</label>
                                </div>
                                <div class="checkbox-group">
                                    <input type="checkbox" id="obs" name="obs_checklist_option" value="OBS" />
                                    <label for="obs">OBS</label>
                                </div>
                                <div class="checkbox-group">
                                    <input type="checkbox" id="kts_minor" name="obs_checklist_option" value="KTS Minor" />
                                    <label for="kts_minor">KTS MINOR</label>
                                </div>
                                <div class="checkbox-group">
                                    <input type="checkbox" id="kts_mayor" name="obs_checklist_option" value="KTS Mayor" />
                                    <label for="kts_mayor">KTS MAYOR</label>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%">
                        <strong>Sub Indicator</strong>
                        @foreach ($subIndicators as $subIndicator)
                            @if ($subIndicator->indicator_id == $indicator->id)
                                <ul>{{ $subIndicator->name }}</ul>
                            @endif
                        @endforeach
                    </td>
                    <td>
                        <div class="form_control">
                            <label for="person_in_charge" class="form-label">
                                <b>Pihak yang Bertanggung Jawab</b><i class="text-danger">*</i>
                            </label>
                            <input type="text" id="person_in_charge" class="form-control" name="person_in_charge" placeholder="Pihak Bertanggung Jawab..."></input>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%" id="review-docs">
                        <strong>Review Document</strong>
                        @foreach ($reviewDocs as $reviewDoc)
                            @if ($reviewDoc->indicator_id == $indicator->id)
                                <ul>{{ $reviewDoc->name }}</ul>
                            @endif
                        @endforeach
                    </td>
                    <td style="vertical-align: top;">
                        <div>
                            <label for="plan_complated" class="form-label"><b>Jadwal Penyelesaian</b><i class="text-danger">*</i></label>
                            <input type="date" class="form-control @error('plan_complated') is-invalid @enderror" name="plan_complated" placeholder="YYYY-MM-DD HH:MM" id="flatpickr-datetime">
                        </div>
                    </td>
                </tr>
                <tr>
            <td colspan="3">
                <label for="remark_description" class="form-label"><b>Deskripsi Audit  :</b><i class="text-danger">*</i></label>
                <textarea id="remark_description" name="remark_description" class="form-control" maxlength="250" placeholder="MAX 250 characters..."></textarea>
            </td>
        </tr>
        <tr id="success-field-1" class="hidden">
            <td colspan="3">
                <label for="remark_success" class="form-label"><b>Faktor Pendukung Keberhasilan :</b></label>
                <textarea id="remark_success" name="remark_success_failed" class="form-control" maxlength="250" placeholder="MAX 250 characters..."></textarea>
            </td>
        </tr>
        <tr id="failed-field-1" class="hidden">
            <td colspan="3">
                <label for="remark_failed" class="form-label"><b>Faktor Pendukung Kegagalan :</b></label>
                <textarea id="remark_failed" name="remark_success_failed" class="form-control" maxlength="250" placeholder="MAX 250 characters..."></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <label for="remark_recommend" class="form-label"><b>Rekomendasi Audit  :</b><i class="text-danger">*</i></label>
                <textarea name="remark_recommend" class="form-control" maxlength="250" placeholder="MAX 250 characters..."></textarea>
            </td>
        </tr>
        <tr id="upgrade-field-1" class="hidden">
            <td colspan="3">
                <label for="remark_upgrade" class="form-label"><b>Rencana Peningkatan :</b></label>
                <textarea type="text" id="remark_upgrade" class="form-control" name="remark_upgrade_repair" maxlength="250" placeholder="MAX 250 characters..."></textarea>
            </td>
        </tr>
        <tr id="repair-field-1" class="hidden">
            <td colspan="3">
                <label for="remark_repair" class="form-label"><b>Rencana Perbaikan :</b></label>
                <textarea type="text" id="remark_repair" class="form-control" name="remark_upgrade_repair" maxlength="250" placeholder="MAX 250 characters..."></textarea>
            </td>
        </tr>        
            </table>
        @endif
    @endforeach
@endforeach


          <div class="col-12 d-flex justify-content-between">
          <button class="btn btn-primary btn-prev"> <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
            <span class="align-middle d-sm-inline-block d-none">Previous</span>
          </button>
          <button class="btn btn-primary btn-submit">Submit</button>
          </div>
        </div>
      </div>
    </form>
  </div>
  </div>
@endsection

@section('script')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('assets/vendor/libs/bs-stepper/bs-stepper.js')}}"></script>

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

        if (wizardIconsBtnSubmit) {
            wizardIconsBtnSubmit.addEventListener('click', event => {
                alert('Submitted..!!');
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('input[name="obs_checklist_option"]');
        
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                // Uncheck other checkboxes
                checkboxes.forEach(cb => {
                    if (cb !== checkbox) {
                        cb.checked = false;
                    }
                });

                if (checkbox.checked) {
                    if (checkbox.value === 'KS') {
                        document.getElementById('success-field-1').classList.remove('hidden');
                        document.getElementById('upgrade-field-1').classList.remove('hidden');
                        document.getElementById('failed-field-1').classList.add('hidden');
                        document.getElementById('repair-field-1').classList.add('hidden');
                    } else if (checkbox.value === 'OBS' || checkbox.value === 'KTS Minor' || checkbox.value === 'KTS Mayor') {
                        document.getElementById('failed-field-1').classList.remove('hidden');
                        document.getElementById('repair-field-1').classList.remove('hidden');
                        document.getElementById('success-field-1').classList.add('hidden');
                        document.getElementById('upgrade-field-1').classList.add('hidden');
                    }
                } else {
                    document.getElementById('success-field-1').classList.add('hidden');
                    document.getElementById('upgrade-field-1').classList.add('hidden');
                    document.getElementById('failed-field-1').classList.add('hidden');
                    document.getElementById('repair-field-1').classList.add('hidden');
                }
            });
        });
    });
    </script>
@endsection
