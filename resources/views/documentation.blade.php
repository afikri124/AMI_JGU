@extends('layouts.master')
@section('content')
@section('title', 'Documentation')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/font-awesome.css')}}">
@endsection

<style>
    .container, .container-fluid, .container-sm, .container-md, .container-lg, .container-xl, .container-xxl {
    padding-right: 0.5em;
    padding-left: 0.5em;
}
</style>

@section('content')
<div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
        <div class="card">
            <div class="card-datatable table-responsive">
                <div class="card-header flex-column flaex-md-row pb-0">
                    <div class="row">
                        <div class="col-12 pt-3 pt-md-0">
                            <div class="col-12">
                                <div class="row">
                                    <div class="offset-md-0 col-md-0 text-md-end text-center pt-3 pt-md-0">
                                    </div>
                                </div>
                            </div>
            <div class="card">
                  <div class="card-header">
                        <h5>Flow System</h5>
                  </div>
                  <div class="card-body">
                        <ul class="nav nav-tabs" id="icon-tab" role="tablist">
                              <li class="nav-item"><a class="nav-link active" id="icon-home-tab" data-bs-toggle="tab" href="#icon-home" role="tab" aria-controls="icon-home" aria-selected="true" data-bs-original-title="" title="">New</a></li>
                        </ul>
                        <div class="tab-content" id="icon-tabContent">
                              <div class="tab-pane fade active show text-center pt-0" id="icon-home" role="tabpanel" aria-labelledby="icon-home-tab">
                                    <a href="{{asset('assets/img/AMI_JGU Diagram.png')}}" target="_blank">
                                    <img class="img-fluid" style="max-height: 450px;" src="{{asset('assets/img/AMI_JGU Diagram.png')}}">
                                    </a>
                              </div>
                        </div>
                  </div>
            </div>
            </div>
      </div>
      <p></p>
      <div class="row">
            <div class="col-sm-12">
            <div class="card">
                  <div class="card-header">
                  <h5>User Guidance</h5>
                  </div>
                  <div class="d-none d-md-block">
                  <iframe src="{{asset('assets/doc.pdf')}}" style="width:100%; height:650px;" frameborder="0"></iframe>
                  </div>
                  <div class="text-center pb-4">
                  <a href="{{asset('assets/doc.pdf')}}" class="btn btn-primary" target="_blank">Download</a>
                  </div>
            </div>
            </div>
      </div>
</div>
@endsection
