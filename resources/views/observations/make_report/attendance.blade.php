<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet">
<title>Absensi</title>
    <style type="text/css">
    .ritz .waffle a { color: inherit; }
    .ritz .waffle .s0 {
        border-top: 1px SOLID #000000;
        border-left: 1px SOLID #000000;
        border-bottom: 1px SOLID #000000;
        border-right: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: center;
        color: #000000;
        font-family: docs-Calibri, Arial;
        font-size: 12pt;
        vertical-align: middle;
        white-space: nowrap;
        direction: ltr;
        padding: 0px 3px 0px 3px;
    }
    .ritz .waffle .s1 {
        border-top: 1px SOLID #000000;
        border-left: 1px SOLID #000000;
        border-bottom: 1px SOLID #000000;
        border-right: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: left;
        color: #000000;
        font-family: docs-Calibri, Arial;
        font-size: 12pt;
        vertical-align: middle;
        white-space: nowrap;
        direction: ltr;
        padding: 0px 3px 0px 3px;
    }
      body {
        font-family: sans-serif;
        margin: 60px;
        padding: 15px;
        /* Landscape orientation */
        orientation: landscape;
        /* Adjust for A4 paper */
        width: 21.0cm;
        height: 29.7cm;
      }

      /* table {
        border-collapse:collapse;
        width: 180%;
        max-width: 1500px;
      } */

      th, td {
        border: 2px solid black;
        padding: 4px;
        text-align: left;
      }

      th {
        background-color:white;
      }

      .logo {
        width: 150px;
      }

    .signature-container {
    display: flex;
    justify-content: space-between;
    }

    .signature {
        text-align: center;
    }

    .logo {
        display: block;
        margin: 20px auto;
    }
      .signature-1 {
        text-align: left;
        margin-top: 20px;
      }

      .signature-2 {
        text-align:end;
        margin-top: 20px;
      }

      .signature-title {
        margin-bottom: 5px;
      }

      .signature-line {
        width: 100px;
        background-color: black;
        display: inline-block;
      }
    </style>
  </head>
  <body>
  <div class="container-fluid" dir="ltr">
  <table cellspacing="0" cellpadding="0">
  <thead>
        @php
            use Carbon\Carbon;
            Carbon::setLocale('id');
        @endphp
    <body>
      <tr style="height: 20px">
        <td class="s0" colspan="2" rowspan="6"><center><img src="/assets/img/logo/logo_small.png" alt=""></center></td>
        <td class="s0" colspan="2"><center>ABSENSI KEGIATAN</center></td>
        <td class="s0" colspan="2" rowspan="6"><center>FM/JGU/L.007</center></td>
      </tr>
      <tr style="height: 20px">
        <td class="s0" colspan="2"><center>
        @foreach ($standardCriterias as $criteria)
            {{ $criteria->title }}
        @endforeach
        </center></td>
      </tr>
      <tr style="height: 20px">
        <td class="s1">Hari/Tgl.</td>
        <td class="s1">{{ Carbon::parse($data->date_start)->translatedFormat('l, d F Y') }}</td>
      </tr>
      <tr style="height: 20px">
        <td class="s1">Tempat</td>
        <td class="s1">{{$data->locations->title}}</td>
      </tr>
      <tr style="height: 20px">
        <td class="s1">Pimpinan Rapat</td>
        <td class="s1">{{$data->locations->title}}</td>
      </tr>
      <tr style="height: 20px">
        <td class="s1">Peserta Rapat</td>
        <td class="s1">Anggota Auditor & {{$data->auditee->name}}</td>
      </tr>
    <tr style="height: 15px">
        <th id="401587373C0" style="width:59px;" class="column-headers-background" rowspan="2"><center>No</center></th>
        <th id="401587373C1" style="width:293px;" class="column-headers-background" colspan="2" rowspan="2"><center>Nama</center></th>
        <th id="401587373C2" class="column-headers-background" rowspan="2"><center>Jabatan</center></th>
        <th id="401587373C3" style="width:188px;" class="column-headers-background" colspan="2" rowspan="2"><center>Paraf</center></th>
    </tr>
    <tr style="height: 20px">
    </tr>
      <tr style="height: 35px">
        <td class="s0" rowspan="2"><center>1</center></td>
        <td class="s0" colspan="2" rowspan="2"><center>nama auditor 1</center></td>
        <td class="s0" rowspan="2"><center>Ketua Auditor</center></td>
        <td class="s0" rowspan="2">1.</td>
        <td class="s0" rowspan="2"></td>
      </tr>
      <tr style="height: 35px">
      </tr>
      <tr style="height: 35px">
        <td class="s0" rowspan="2"><center>2</center></td>
        <td class="s0" colspan="2" rowspan="2"><center>nama auditor 2</center></td>
        <td class="s0" rowspan="2"><center>Anggota</center></td>
        <td class="s0" rowspan="2"></td>
        <td class="s0" rowspan="2">2.</td>
      </tr>
      <tr style="height: 35px">
      </tr>
      <tr style="height: 35px">
        <td class="s0" rowspan="2"><center>3</center></td>
        <td class="s0" colspan="2" rowspan="2"><center>{{$data->auditee->name}}</center></td>
        <td class="s0" rowspan="2"><center>Auditee</center></td>
        <td class="s0" rowspan="2">3.</td>
        <td class="s0" rowspan="2"></td>
      </tr>
      <tr style="height: 35px">
      </tr>
      </body>
      </thead>
  </table>
</div>
    <div class="signature-container">
        <div class="signature-1">
            <p>Kepala LPM</p>
            <br>
            <p>{{ $hodLPM->title }}
            <br>NIK. {{ $hodLPM->content }}</NIK.>
        </div>
        <div class="signature-1">
            <p>Ketua BPMI</p>
            <br>
            <p>{{ $hodBPMI->title }}
            <br>NIK. {{ $hodBPMI->content }}</NIK.>
        </div>
    </div>
