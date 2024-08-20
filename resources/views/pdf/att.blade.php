<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AMI Report | {{ date('d/m/Y', strtotime($data->date_start)) }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        html {
            margin: 2cm 1cm;
        }
        body {
            font-size: 11pt;
            font-family: "Times New Roman";
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        td, th {
            border: 1px solid black;
            padding: 6px;
            vertical-align: top;
        }
        th {
            background-color: white;
        }
        .signature-section {
            margin-top: 10px;
        }
        .signature-section .left {
            float: left;
            width: 50%; /* Adjusted width */
            text-align: left;
            margin-top: 50px; /* Space for the signature */
            padding-left: 50px; /* Add padding to avoid text being too close to the edge */
        }
        .signature-section .right {
            float: right;
            width: 50%; /* Adjusted width */
            text-align: left;
            margin-top: 20px;
            padding-right: 50px; /* Add padding to avoid text being too close to the edge */

        }

        .date-section {
            text-align: right;
            margin-bottom: 0px;
            padding-right: 50px;
            margin-top: 20px;
        }
        .clear {
            clear: both;
        }
    </style>
</head>
<body>
@foreach ($standardCriterias as $criteria)
    <table>
        <tr>
            <td rowspan="6" style="width: 10%;">
                <center><img src="/assets/img/logo/logo_small.png" style="height: 75px;" alt="Logo"></center>
            </td>
            <td colspan="2" style="width: 65%;"><center>ABSENSI KEGIATAN</center></td>
            <td rowspan="6" style="width: 10%;"><center>FM/JGU/L.007</center></td>
        </tr>
        <tr>
            <td colspan="2"><center>{{ $criteria->title }}</center></td>
        </tr>
        <tr>
            <td style="width: 25%;">Hari/Tgl.</td>
            <td>{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('j F Y') }}</td>
        </tr>
        <tr>
            <td>Tempat</td>
            <td>{{ $data->locations->title }}</td>
        </tr>
        <tr>
            <td>Pimpinan Rapat</td>
            <td>{{ $auditors->first()->auditor->name }}</td>
        </tr>
        <tr>
            <td>Peserta Rapat</td>
            <td>Anggota Auditor & Auditee</td>
        </tr>
        <tr>
            <th style="width: 5%;"><center>No</center></th>
            <th style="width: 40%;" colspan="2"><center>Nama</center></th>
            <th style="width: 30%;"><center>Jabatan</center></th>
            <th style="width: 10%;" colspan="2"><center>Paraf</center></th>
        </tr>
        <tr>
            <td><center>1</center></td>
            <td colspan="2"><center>{{ $auditors->first()->auditor->name }}</center></td>
            <td><center>Ketua Auditor</center></td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td><center>2</center></td>
            <td colspan="2"><center>@if($auditors->count() > 1) {{ $auditors->get(1)->auditor->name }} @endif</center></td>
            <td><center>Anggota</center></td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td><center>3</center></td>
            <td colspan="2"><center>{{ $data->auditee->name }}</center></td>
            <td><center>Auditee</center></td>
            <td colspan="2"></td>
        </tr>
    </table>
    <div class="date-section">
        <p style="text-align: right;">Depok, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('j F Y') }}</p>
    </div>
    <div class="signature-section">
        <div class="left">
        <p style="margin-bottom: 0;">Mengetahui,</p>
            Kepala LPM<br><br><br><br>
            <b>( {{ $hodLPM->title }} )</b><br>
            <small>NIK. {{ $hodLPM->content }}</small>
        </div>
        <div class="right">
        Ketua Auditor<br><br><br><br>
            <b>( {{ $data->auditee->name }} )</b><br>
            <small>NIK. {{ $data->auditee->nidn }}</small>
        </div>
        <div class="clear"></div>
    </div>
@endforeach
</body>
</html>
