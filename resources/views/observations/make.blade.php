@extends('layouts.master')
@section('title', 'Add Data Audit')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/sweetalert2.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="assets/vendor/libs/bs-stepper/bs-stepper.css" />
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

<div class="bs-stepper wizard-icons wizard-icons-example">
<div class="bs-stepper-header">
  <div class="step" data-target="#account-details">
    <button type="button" class="step-trigger">
      <span class="bs-stepper-icon">
        <svg viewBox="0 0 54 54">
          <use xlink:href='assets/svg/icons/form-wizard-account.svg#wizardAccount'></use>
        </svg>
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
        <svg viewBox="0 0 58 54">
          <use xlink:href='assets/svg/icons/form-wizard-personal.svg#wizardPersonal'></use>
        </svg>
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
      <span class="bs-stepper-label">Address</span>
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
          <label class="form-label" for="username-icons">Username</label>
          <input type="text" id="username-icons" class="form-control" placeholder="johndoe" />
        </div>
        <div class="col-md-6">
          <label class="form-label" for="email-icons">Email</label>
          <input type="email" id="email-icons" class="form-control" placeholder="john.doe@email.com" aria-label="john.doe" />
        </div>
        <div class="col-md-6 form-password-toggle">
          <label class="form-label" for="password-icons">Password</label>
          <div class="input-group input-group-merge">
            <input type="password" id="password-icons" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password2" />
            <span class="input-group-text cursor-pointer" id="password2"><i class="bx bx-hide"></i></span>
          </div>
        </div>
        <div class="col-md-6 form-password-toggle">
          <label class="form-label" for="confirm-password-icon">Confirm Password</label>
          <div class="input-group input-group-merge">
            <input type="password" id="confirm-password-icon" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="confirm-password2-icon" />
            <span class="input-group-text cursor-pointer" id="confirm-password2-icon"><i class="bx bx-hide"></i></span>
          </div>
        </div>
        <div class="col-12 d-flex justify-content-between">
          <button class="btn btn-label-secondary btn-prev" disabled> <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
            <span class="align-middle d-sm-inline-block d-none">Previous</span>
          </button>
          <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none">Next</span> <i class="bx bx-chevron-right bx-sm me-sm-n2"></i></button>
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
          <label class="form-label" for="first-name-icons">First Name</label>
          <input type="text" id="first-name-icons" class="form-control" placeholder="John" />
        </div>
        <div class="col-md-6">
          <label class="form-label" for="last-name-icons">Last Name</label>
          <input type="text" id="last-name-icons" class="form-control" placeholder="Doe" />
        </div>
        <div class="col-md-6">
          <label class="form-label" for="country-icons">Country</label>
          <select class="select2" id="country-icons">
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
          <label class="form-label" for="language-icons">Language</label>
          <select class="selectpicker w-auto" id="language-icons" data-style="btn-transparent" data-icon-base="bx" data-tick-icon="bx-check text-white" multiple>
            <option>English</option>
            <option>French</option>
            <option>Spanish</option>
          </select>
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
        <h6 class="mb-0">Address</h6>
        <small>Enter Your Address.</small>
      </div>
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label" for="address">Address</label>
          <input type="text" class="form-control" id="address" placeholder="98  Borough bridge Road, Birmingham">
        </div>
        <div class="col-md-6">
          <label class="form-label" for="landmark">Landmark</label>
          <input type="text" class="form-control" id="landmark" placeholder="Borough bridge">
        </div>
        <div class="col-md-6">
          <label class="form-label" for="pincode">Pincode</label>
          <input type="text" class="form-control" id="pincode" placeholder="658921">
        </div>
        <div class="col-md-6">
          <label class="form-label" for="city">City</label>
          <input type="text" class="form-control" id="city" placeholder="Birmingham">
        </div>
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
<script src="assets/vendor/libs/bs-stepper/bs-stepper.js"></script>
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
