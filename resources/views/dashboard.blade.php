@extends('layouts.master')
@section('title', 'Dashboard')


@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/date-picker.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/font-awesome.css')}}">
<style>
    
    .default-datepicker .datepicker-inline .datepicker {
    width: auto;
    background: #fff;
    -webkit-box-shadow: none;
    box-shadow: none;
    padding: 0
}

.default-datepicker .datepicker-inline .datepicker .datepicker--content .datepicker--days .datepicker--days-names {
    margin: 60px 0 0;
    padding: 15px 0;
}

.default-datepicker .datepicker-inline .datepicker .datepicker--content .datepicker--days .datepicker--cells .datepicker--cell-day {
    height: 58px;
    border-radius: 0;
    /* color: #2b2b2b */
    font-size: 20px
}

.default-datepicker .datepicker-inline .datepicker .datepicker--content .datepicker--days .datepicker--days-names .datepicker--day-name {
    color: #696CFF;
    font-size: 18px
}

.bg-card {
    background-image: url('{{asset('/assets/img/bg.jpg')}}'); /* Ganti dengan path ke background image Anda */
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    color: white; /* Sesuaikan warna teks agar terlihat dengan baik di atas background image */
}

h3{
    color: #fff; 
}

#greeting{
    color: #fff
}

#txt{
    color: #fff
}
.greeting-container {
    display: flex;
    gap: 370px; /* Atur jarak antar elemen jika diperlukan */
}

.f-w-600 {
    margin-right: 10px; /* Atur jarak sesuai kebutuhan */
}

.profile-greeting .card-body {
    padding: 40px 20px
}   


</style>
@endsection


@section('content')
<div class="app-calendar-wrapper">
    <div class="row">
        <div class="col-xl-6 col-lg-12 xl-50 morning-sec box-col-12">
            <div class="card profile-greeting bg-card">
                <div class="card-body pb-0">
                    <div class="media">
                        <div class="media-body">
                            <div class="greeting-user m-0">
                                <div class="greeting-container">
                                    <h4 class="f-w-600 font-light m-0 mb-3" id="greeting">Good Morning</h4>
                                    <h4><span id="txt"></span></h4>
                                </div>
                                <h3>{{ Auth::user()->name }}</h3>
                                <i class="emaill">{{ Auth::user()->email }}</i>
                            </div>
                        </div>
                     
                    </div>
                    <div class="cartoon"><img class="img-fluid" src="{{asset('/assets/img/bg.jpg')}}"
                            style="max-width: 90%;" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-12 xl-60 calendar-sec box-col-6">
            <div class="card gradient-primary o-hidden">
                <div class="card-body">
                    <div class="default-datepicker">
                        <div class="datepicker-here" data-language="en"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<table class="table" id="datatable">
    <thead>
        <tr>
            <th>Announcements</th>
        </tr>
    </thead>
</table>
@foreach ($auditplans as $x)
    <ul class="list-group">
        <div class="card-container">
            <li class="list-group-item">
                <br>
                <div class="card" data-aos="fade-down">
                    <div class="card h-100">
                        <div class="card-header flex-grow-0">
                            <div class="d-flex">
                                <div class="avatar flex-shrink-0 me-3">
                                    <img src="../../assets/img/avatars/user.png" alt="User"
                                        class="w-100 rounded-circle">
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-1">
                                    <div class="me-2">
                                        <h5 class="mb-0">{{ ucfirst(Auth::user()->username) }} Shared Post</h5>
                                        <small
                                            class="text-muted">{{ $x->created_at->format('d M Y \a\t h:i A') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <img src="{{ asset($x->doc_path) }}" class="img-fluid" alt="" width="500px"
                            height="500px">
                        <div class="featured-date mt-n4 ms-4 bg-white rounded w-px-50 shadow text-center p-1">
                            <h5 class="mb-0 text-dark">{{ date('d', strtotime($x->date_start)) }}</h5>
                            <span class="text-primary">{{ date('F', strtotime($x->date_start)) }}</span>
                        </div>
                        <div class="card-body">
                            <h5 class="text-truncate">{{ $x->lecture_id }}</h5>
                            <div class="d-flex gap-2">
                            </div>
                            <div class="d-flex my-3">
                                <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal{{ $x->id }}">
                                    Show Description
                                </button>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="card-actions">
                                    <a href="javascript:;" class="text-muted me-3"><i class="bx bx-heart me-1"></i>
                                        236</a>
                                    <a href="javascript:;" class="text-muted"><i class="bx bx-message me-1"></i> 12</a>
                                </div>
                                <div class="dropup d-none d-sm-block">
                                    <button class="btn p-0" type="button" id="sharedList" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Button trigger modal -->
                <!-- Modal -->
                <div class="modal fade" id="exampleModal{{ $x->id }}" tabindex="-1"
                    aria-labelledby="exampleModalLabel{{ $x->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel{{ $x->id }}">
                                    <p>{{ $x->lecture_id }}</p>
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>{{ $x->auditor_id }}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
@endforeach
</li>
</div>
</ul>


@endsection
@section('script')
<script type="text/javascript">
    $(window).on('load', function () {
        $('#myModal').modal('show');
    });

</script>
<!-- <script src="{{asset('assets/js/notify/bootstrap-notify.min.js')}}"></script> -->
<script>
    // greeting
    var today = new Date()
    var curHr = today.getHours()

    if (curHr >= 0 && curHr < 4) {
        document.getElementById("greeting").innerHTML = 'Good Night!';
    } else if (curHr >= 4 && curHr < 12) {
        document.getElementById("greeting").innerHTML = 'Good Morning!';
    } else if (curHr >= 12 && curHr < 16) {
        document.getElementById("greeting").innerHTML = 'Good Afternoon!';
    } else {
        document.getElementById("greeting").innerHTML = 'Good Evening!';
    }
    // time 
    function startTime() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        // var s = today.getSeconds();
        var ampm = h >= 12 ? 'PM' : 'AM';
        h = h % 12;
        h = h ? h : 12;
        m = checkTime(m);
        // s = checkTime(s);
        document.getElementById('txt').innerHTML =
            h + ":" + m + ' ' + ampm;
        var t = setTimeout(startTime, 500);
    }

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i
        }; // add zero in front of numbers < 10
        return i;
    }

    startTime();

</script>
<!-- <script src="{{asset('assets/js/notify/index.js')}}"></script> -->


@endsection
