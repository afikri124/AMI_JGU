@extends('layouts.master')
@section('content')
@section('title', 'Documentation')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/font-awesome.css')}}">
@endsection



@section('content')
<div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
    <div class="card">
        <div class=" flex-column flaex-md-row pb-0">
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
                            <div class="tab-content" id="icon-tabContent">
                                <div class="tab-pane fade active show text-center pt-0" id="icon-home" role="tabpanel"
                                    aria-labelledby="icon-home-tab">
                                    <a href="{{asset('../assets/img/flowchart AMI.png')}}" target="_blank">
                                        <img class="img-fluid" style="max-height: 70vh;"
                                            src="{{asset('../assets/img/flowchart AMI.png')}}">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
