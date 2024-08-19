<html>
<head>
    <title>AMI Report | {{date('d/m/Y', strtotime($data->date_start)) }}
    </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        html {
            margin: 2cm 1cm
        }
        .page-break {
            page-break-after: always;
        }

        body {
            font-size: 11pt;
            font-family: "Times New Roman";
        }

        table {
        width: 100%;
        border-collapse: collapse;
        }
        td, th {
            border: 1px solid black;
            padding: 6px;
            vertical-align: top;
        }
        th {
            background-color: white;
        }

        .paraf {
            height: 60px; /* Mengatur tinggi untuk area paraf */
            vertical-align: middle; /* Menjaga teks paraf berada di tengah secara vertikal */
        }
    </style>
</head>
<body>
@foreach ($standardCriterias as $criteria)
<div class="page-break">
<table>
      <tr style="height: 5px">
      <td colspan="2" rowspan="6">
    <center>
    <img src="/assets/img/logo/logo_small.png" style="height: 75px;" alt="Logo"></center></td>
        <td colspan="2"><center>ABSENSI KEGIATAN</center></td>
        <td colspan="2" rowspan="6"><center>FM/JGU/L.007</center></td>
      </tr>
      <tr style="height: 5px">
        <td colspan="2"><center>{{ $criteria->title }}</center></td>
      </tr>
      <tr style="height: 5px">
        <td>Hari/Tgl.</td>
        <td>{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('j F Y') }}</td>
      </tr>
      <tr style="height: 5px">
        <td>Tempat</td>
        <td>{{$data->locations->title}}</td>
      </tr>
      <tr style="height: 5px">
        <td>Pimpinan Rapat</td>
        <td>{{ $auditors->first()->auditor->name }}</td>
      </tr>
      <tr style="height: 5px">
        <td>Peserta Rapat</td>
        <td>Anggota Auditor & Auditee</td>
      </tr>
      <tr style="height: 10px">
        <th style="width:59px;" rowspan="2"><center>No</center></th>
        <th style="width:293px;" colspan="2" rowspan="2"><center>Nama</center></th>
        <th style="width:293px;" rowspan="2"><center>Jabatan</center></th>
        <th style="width:188px;" colspan="2" rowspan="2"><center>Paraf</center></th>
      </tr>
      <tr style="height: 20px"></tr>
      <tr style="height: 20px">
        <td rowspan="2"><center>1</center></td>
        <td colspan="2" rowspan="2"><center>{{ $auditors->first()->auditor->name }}</center></td>
        <td rowspan="2"><center>Ketua Auditor</center></td>
        <td rowspan="2">1.</td>
        <td rowspan="2"></td>
      </tr>
      <tr style="height: 20px"></tr>
      <tr style="height: 20px">
        <td rowspan="2"><center>2</center></td>
        <td colspan="2" rowspan="2"><center>@if($auditors->count() > 1) {{ $auditors->get(1)->auditor->name }} @endif</center></td>
        <td rowspan="2"><center>Anggota</center></td>
        <td rowspan="2"></td>
        <td rowspan="2">2.</td>
      </tr>
      <tr style="height: 20px"></tr>
      <tr style="height: 20px">
        <td rowspan="2"><center>3</center></td>
        <td colspan="2" rowspan="2"><center>{{$data->auditee->name}}</center></td>
        <td rowspan="2"><center>Auditee</center></td>
        <td rowspan="2">3.</td>
        <td rowspan="2"></td>
      </tr>
      <tr style="height: 20px"></tr>
    </table>
    <table>
      <tr>
        <td width="50%"></td>
        <td width="50%" style="text-align: center;">Depok, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('j F Y') }}
        </td>
      </tr>
      <tr>
        <td width="50%" style="text-align: center;">
          Kepala LPM<br><br><br><br>
          <b>( {{ $hodLPM->title }} )</b><br>
          <small>NIK. {{ $hodLPM->content }} </small>
        </td>
        <td width="50%" style="text-align: center;">
          <br>Ketua Auditor<br><br><br><br>
          <b>( {{ $data->auditee->name }} )</b><br>
          <small>NIK. {{ $data->auditee->nidn }}</small>
        </td>
      </tr>
    </table>
  </div>
@endforeach
