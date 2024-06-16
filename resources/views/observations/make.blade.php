@extends('layouts.master')
@section('title', 'Add Data Audit')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/sweetalert2.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="assets/vendor/libs/flatpickr/flatpickr.css" />
@endsection
@section('style')
<style>
    .input-validation-error~.select2 .select2-selection {
        border: 1px solid red;
    }

</style>
@endsection

@section('breadcrumb-title')
<!-- <h3>User Profile</h3> -->
@endsection

@section('content')
<div class="bs-stepper wizard-numbered mt-2">
<div class="bs-stepper-header">
  <div class="step" data-target="#account-details">
    <button type="button" class="step-trigger">
      <span class="bs-stepper-circle">1</span>
      <span class="bs-stepper-label mt-1">
        <span class="bs-stepper-title">Account Details</span>
        <span class="bs-stepper-subtitle">Setup Account Details</span>
      </span>
    </button>
  </div>
  <div class="line">
    <i class="bx bx-chevron-right"></i>
  </div>
  <div class="step" data-target="#personal-info">
    <button type="button" class="step-trigger">
      <span class="bs-stepper-circle">2</span>
      <span class="bs-stepper-label mt-1">
        <span class="bs-stepper-title">Personal Info</span>
        <span class="bs-stepper-subtitle">Add personal info</span>
      </span>
    </button>
  </div>
  <div class="line">
    <i class="bx bx-chevron-right"></i>
  </div>
  <div class="step" data-target="#social-links">
    <button type="button" class="step-trigger">
      <span class="bs-stepper-circle">3</span>
      <span class="bs-stepper-label mt-1">
        <span class="bs-stepper-title">Social Links</span>
        <span class="bs-stepper-subtitle">Add social links</span>
      </span>
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
          <label class="form-label" for="username">Username</label>
          <input type="text" id="username" class="form-control" placeholder="johndoe" />
        </div>
        <div class="col-md-6">
          <label class="form-label" for="email">Email</label>
          <input type="email" id="email" class="form-control" placeholder="john.doe@email.com" aria-label="john.doe" />
        </div>
        <div class="col-md-6 form-password-toggle">
          <label class="form-label" for="password">Password</label>
          <div class="input-group input-group-merge">
            <input type="password" id="password" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password2" />
            <span class="input-group-text cursor-pointer" id="password2"><i class="bx bx-hide"></i></span>
          </div>
        </div>
        <div class="col-md-6 form-password-toggle">
          <label class="form-label" for="confirm-password">Confirm Password</label>
          <div class="input-group input-group-merge">
            <input type="password" id="confirm-password" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="confirm-password2" />
            <span class="input-group-text cursor-pointer" id="confirm-password2"><i class="bx bx-hide"></i></span>
          </div>
        </div>
        <div class="col-12 d-flex justify-content-between">
          <button class="btn btn-label-secondary btn-prev" disabled>
            <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
            <span class="align-middle d-sm-inline-block d-none">Previous</span>
          </button>
          <button class="btn btn-primary btn-next">
            <span class="align-middle d-sm-inline-block d-none me-sm-1 me-0">Next</span>
            <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
          </button>
        </div>
      </div>
    </div>
    <!-- Personal Info -->
    <div id="personal-info" class="content">
      <div class="content-header mb-3">
        <h6 class="mb-0">Personal Info</h6>
        <small>Enter Your Personal Info.</small>
      </div>
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label" for="first-name">First Name</label>
          <input type="text" id="first-name" class="form-control" placeholder="John" />
        </div>
        <div class="col-md-6">
          <label class="form-label" for="last-name">Last Name</label>
          <input type="text" id="last-name" class="form-control" placeholder="Doe" />
        </div>
        <div class="col-md-6">
          <label class="form-label" for="country">Country</label>
          <select class="select2" id="country">
            <option label=" "></option>
            <option>UK</option>
            <option>USA</option>
            <option>Spain</option>
            <option>France</option>
            <option>Italy</option>
            <option>Australia</option>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label" for="language">Language</label>
          <select class="selectpicker w-auto" id="language" data-style="btn-transparent" data-icon-base="bx" data-tick-icon="bx-check text-white" multiple>
            <option>English</option>
            <option>French</option>
            <option>Spanish</option>
          </select>
        </div>
        <div class="col-12 d-flex justify-content-between">
          <button class="btn btn-primary btn-prev"> <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
            <span class="align-middle d-sm-inline-block d-none">Previous</span>
          </button>
          <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-1 me-0">Next</span> <i class="bx bx-chevron-right bx-sm me-sm-n2"></i></button>
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
          <label class="form-label" for="twitter">Twitter</label>
          <input type="text" id="twitter" class="form-control" placeholder="https://twitter.com/abc" />
        </div>
        <div class="col-md-6">
          <label class="form-label" for="facebook">Facebook</label>
          <input type="text" id="facebook" class="form-control" placeholder="https://facebook.com/abc" />
        </div>
        <div class="col-md-6">
          <label class="form-label" for="google">Google+</label>
          <input type="text" id="google" class="form-control" placeholder="https://plus.google.com/abc" />
        </div>
        <div class="col-md-6">
          <label class="form-label" for="linkedin">LinkedIn</label>
          <input type="text" id="linkedin" class="form-control" placeholder="https://linkedin.com/abc" />
        </div>
        <div class="col-12 d-flex justify-content-between">
          <button class="btn btn-primary btn-prev"> <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
            <span class="align-middle d-sm-inline-block d-none">Previous</span>
          </button>
          <button class="btn btn-success btn-submit">Submit</button>
        </div>
      </div>
    </div>
  </form>
</div>
</div>
@endsection

@section('script')
<script src="{{asset('assets/vendor/libs/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/datatables-bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/datatables.responsive.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/responsive.bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/datatables.checkboxes.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/datatables-buttons.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/buttons.bootstrap5.js')}}"></script>
<script src="{{asset('assets/js/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="assets/vendor/libs/flatpickr/flatpickr.js"></script>
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
