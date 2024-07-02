@extends('layouts.master')
@section('title', 'Observations')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
{{-- <link rel="stylesheet" href="{{asset('assets/vendor/libs/wizard.css')}}" /> --}}
{{-- <link rel="stylesheet" href="assets/vendor/libs/flatpickr/flatpickr.css" /> --}}
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
</style>
@endsection

@section('breadcrumb-title')
<!-- <h3>User Profile</h3> -->
@endsection

@section('content')
<div class="bs-stepper wizard-icons wizard-icons-example">
  <div class="bs-stepper-header">
    <div class="step" data-target="#account-details">
      <button type="button" class="step-trigger">
        <span class="bs-stepper-icon">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM80 64h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16s7.2-16 16-16zm16 96H288c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V256c0-17.7 14.3-32 32-32zm0 32v64H288V256H96zM240 416h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H240c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/></svg>
        </span>
        <span class="bs-stepper-label">Account Details</span>
      </button>
    </div>
    <div class="line">
      <i class="bx bx-chevron-right"></i>
    </div>
    <div class="step" data-target="#personal-info">
      <button type="button" class="step-trigger">
        <span class="bs-stepper-icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM80 64h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16s7.2-16 16-16zm16 96H288c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V256c0-17.7 14.3-32 32-32zm0 32v64H288V256H96zM240 416h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H240c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/></svg>
        </span>
        <span class="bs-stepper-label">Personal Info</span>
      </button>
    </div>
    <div class="line">
      <i class="bx bx-chevron-right"></i>
    </div>
    <div class="step" data-target="#address">
      <button type="button" class="step-trigger">
        <span class="bs-stepper-icon">
          <svg viewBox="0 0 54 54">
            <use xlink:href='assets/svg/icons/form-wizard-address.svg#wizardAddress'></use>
          </svg>
        </span>
        <span class="bs-stepper-label">Assesment</span>
      </button>
    </div>
    <div class="line">
      <i class="bx bx-chevron-right"></i>
    </div>
    <div class="step" data-target="#social-links">
      <button type="button" class="step-trigger">
        <span class="bs-stepper-icon">
          <svg viewBox="0 0 54 54">
            <use xlink:href='assets/svg/icons/form-wizard-social-link.svg#wizardSocialLink'></use>
          </svg>
        </span>
        <span class="bs-stepper-label">Social Links</span>
      </button>
    </div>
    <div class="line">
      <i class="bx bx-chevron-right"></i>
    </div>
    <div class="step" data-target="#review-submit">
      <button type="button" class="step-trigger">
        <span class="bs-stepper-icon">
          <svg viewBox="0 0 54 54">
            <use xlink:href='assets/svg/icons/form-wizard-submit.svg#wizardSubmit'></use>
          </svg>
        </span>
        <span class="bs-stepper-label">Review & Submit</span>
      </button>
    </div>
  </div>
  <div class="bs-stepper-content">
    <form onSubmit="return false">
      <!-- Account Details -->
      <div id="account-details" class="content">
        <div class="content-header mb-3">
          <h6 class="mb-0">Account Details</h6>
          <small>Enter Your Account Details.</small>
        </div>
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label" for="lecture"><b>Lecture</b><i class="text-danger">*</i></label>
            <input class="form-control" type="text" value="{{ $data->lecture->name}}" disabled>

          </div>
          <div class="col-md-6">
            <label class="form-label" for="auditor"><b>Auditor</b><i class="text-danger">*</i></label>
            <input class="form-control" type="text" value="{{ $data->auditor->name}}" disabled>

        </div>
          <div class="col-md-6">
            <div class="form-group">
            <label for="location_id" class="form-label"><b>Location</b><i class="text-danger">*</i></label>
            <select name="location_id" id="location_id" class="form-select" required>
            <option value="">Select Location</option>
            @foreach($locations as $d)
                <option value="{{$d->id}}"
                    {{ (in_array($d->id, old('locations') ?? []) ? "selected": "") }}>
                    {{$d->title}}</option>
            @endforeach
            </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
            <label for="department_id" class="form-label"><b>Department</b><i class="text-danger">*</i></label>
            <select name="department_id" id="department_id" class="form-select" required>
                <option value="">Select Department</option>
                @foreach($department as $d)
                    <option value="{{$d->id}}"
                        {{ (in_array($d->id, old('department') ?? []) ? "selected": "") }}>
                        {{$d->name}}</option>
                    @endforeach
            </select>
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="user-icons"><b>Class Type</b><i class="text-danger">*</i></label>
            <input class="form-control" type="text" placeholder="Input Class Type" required>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Total Student<i class="text-danger">*</i></label>
                <input class="form-control @error('total_students') is-invalid @enderror" id="total_students"
                    name="total_students" value="{{ old('total_students') }}" type=number placeholder="Input Total Students" required>
                @error('total_students')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-12 d-flex justify-content-between">
            <button class="btn btn-label-secondary btn-prev" disabled> <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
              <span class="align-middle d-sm-inline-block d-none">Previous</span>
            </button>
            
            {{-- <!-- Tombol Next dengan JavaScript Validasi -->
            <button id="btnNext" class="btn btn-primary btn-next" disabled>
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
                      input.addEventListener('input', function() {
                          // Memeriksa apakah semua input yang diperlukan sudah diisi
                          const allInputsFilled = Array.from(inputsRequired).every(input => input.value.trim() !== '');
                          btnNext.disabled = !allInputsFilled;
                      });
                  });
              });
            </script> --}}

            <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none" >Next</span> <i class="bx bx-chevron-right bx-sm me-sm-n2"></i></button>
          </div>
        </div>
      </div>
      <!-- Personal Info -->
      <div id="personal-info" class="content">
        <div class="content-header mb-3">
          <h6 class="mb-0">Personal Info</h6>
          <small>Enter Your Personal Info.</small>
        </div>
          <div class="form-group">
            <label class="form-label">Upload Images<i class="text-danger">*</i></label>
              <div class="input-group mb-3">
                <input class="form-control @error('doc_path') is-invalid @enderror"
                  name="doc_path" type="file" accept=".pdf" title="PDF">
                    @error('doc_path')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Link<i class="text-danger">*</i></label>
                    <div class="input-group mb-3">
                    <input class="form-control @error('link') is-invalid @enderror" type="text" id="link"
                        name="link" placeholder="Input link document" value="{{ old('link') }}">
                    @error('link')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
          <div class="col-12 d-flex justify-content-between">
            <button class="btn btn-primary btn-prev"> <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
              <span class="align-middle d-sm-inline-block d-none">Previous</span>
            </button>
            <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none">Next</span> <i class="bx bx-chevron-right bx-sm me-sm-n2"></i></button>
          </div>
        </div>
      </div>
      <!-- Address -->
      <div id="address" class="content">
        <div class="content-header mb-3">
        <small>Category Standard</small>
          <h6 class="mb-0" name="standard_categories_id" id="standard_categories_id">
          @foreach($category as $c)
            <option value="{{ $c->id }}" {{ old('standard_categories_id') == $c->id ? 'selected' : '' }}>
                {{ $c->description }}
            </option>
          @endforeach
          </h6>
          <p></p>
          <small>Criteria Standard</small>
          <h6 class="mb-0" name="standard_criterias_id" id="standard_criterias_id">
          @foreach($criteria as $c)
            <option value="{{ $c->id }}" {{ old('standard_criterias_id') == $c->id ? 'selected' : '' }}>
                {{ $c->title }}
            </option>
          @endforeach
        </div>

        @foreach ($sub_indicator as $sub)
            <table>
              <tr>
                <th colspan="2">Indicator:</th>
              </tr>
              <tr>
                <td colspan="2">
                  {{ $sub->indicator->name }}
                </td>
              </tr>
              <tr>

                <td style="width: 80%">
                  <strong>Sub Indicator:</strong>

                  <p> {!! $sub->name !!}</p>
                </td>
                <td>
                  <div class="checkbox-group">
                    <input type="checkbox" id="ks" name="title_ass" />
                    <label for="ks">KS</label>
                  </div>
                  <div class="checkbox-group">
                    <input type="checkbox" id="obs" name="title_ass" />
                    <label for="obs">OBS</label>
                  </div>
                  <div class="checkbox-group">
                    <input type="checkbox" id="kts" name="title_ass" />
                    <label for="kts">KTS Minor</label>
                  </div>
                  <div class="checkbox-group">
                    <input type="checkbox" id="kts" name="title_ass" />
                    <label for="kts">KTS Mayor</label>
                  </div>
                </td>
              </tr>
              <tr>
                <td colspan="2">
                  <label for="remark_docs">Komentar:</label>
                  <textarea
                    id="remark_docs"
                    name="remark_docs"
                    class="comment"
                    maxlength="100"
                    placeholder="MAX 100 karakter..."></textarea>
                </td>
              </tr>
            </table>
            @endforeach


          <div class="col-12 d-flex justify-content-between">
            <button class="btn btn-primary btn-prev"> <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
              <span class="align-middle d-sm-inline-block d-none">Previous</span>
            </button>
            <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none">Next</span> <i class="bx bx-chevron-right bx-sm me-sm-n2"></i></button>
          </div>
        </div>
      </div>
      <!-- Social Links -->
      <div id="social-links" class="content">
        <div class="content-header mb-3">
          <h6 class="mb-0">Social Links</h6>
          <small>Enter Your Social Links.</small>
        </div>
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label" for="twitter-icons">Twitter</label>
            <input type="text" id="twitter-icons" class="form-control" placeholder="https://twitter.com/abc" />
          </div>
          <div class="col-md-6">
            <label class="form-label" for="facebook-icons">Facebook</label>
            <input type="text" id="facebook-icons" class="form-control" placeholder="https://facebook.com/abc" />
          </div>
          <div class="col-md-6">
            <label class="form-label" for="google-icons">Google+</label>
            <input type="text" id="google-icons" class="form-control" placeholder="https://plus.google.com/abc" />
          </div>
          <div class="col-md-6">
            <label class="form-label" for="linkedin-icons">LinkedIn</label>
            <input type="text" id="linkedin-icons" class="form-control" placeholder="https://linkedin.com/abc" />
          </div>
          <div class="col-12 d-flex justify-content-between">
            <button class="btn btn-primary btn-prev"> <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
              <span class="align-middle d-sm-inline-block d-none">Previous</span>
            </button>
            <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none">Next</span> <i class="bx bx-chevron-right bx-sm me-sm-n2"></i></button>
          </div>
        </div>
      </div>
      <!-- Review -->
      <div id="review-submit" class="content">

        <p class="fw-medium mb-2">Account</p>
        <ul class="list-unstyled">
          <li>Username</li>
          <li>exampl@email.com</li>
        </ul>
        <hr>
        <p class="fw-medium mb-2">Personal Info</p>
        <ul class="list-unstyled">
          <li>First Name</li>
          <li>Last Name</li>
          <li>Country</li>
          <li>Language</li>
        </ul>
        <hr>
        <p class="fw-medium mb-2">Address</p>
        <ul class="list-unstyled">
          <li>Address</li>
          <li>Landmark</li>
          <li>Pincode</li>
          <li>City</li>
        </ul>
        <hr>
        <p class="fw-medium mb-2">Social Links</p>
        <ul class="list-unstyled">
          <li>https://twitter.com/abc</li>
          <li>https://facebook.com/abc</li>
          <li>https://plus.google.com/abc</li>
          <li>https://linkedin.com/abc</li>
        </ul>
        <div class="col-12 d-flex justify-content-between">
          <button class="btn btn-primary btn-prev"> <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
            <span class="align-middle d-sm-inline-block d-none">Previous</span>
          </button>
          <button class="btn btn-success btn-submit">Submit</button>
        </div>
      </div>
    </form>
  </div>
  </div>

@endsection

@section('script')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
{{-- <script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script> --}}
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
</script>
@endsection
