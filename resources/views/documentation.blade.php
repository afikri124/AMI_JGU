@extends('layouts.master')
@section('content')
@section('title', 'Documentation')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/font-awesome.css')}}">
@endsection

@section('content')
<div class="container-fluid">
      <div class="row margin-bottom">
            <div class="col-sm-12">
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
                                    <a href="{{asset('assets/img/AMI_JGU Diagram .png')}}" target="_blank">
                                    <img class="img-fluid" style="max-height: 450px;" src="{{asset('assets/img/AMI_JGU Diagram .png')}}">
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
