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

        .page-break {
            page-break-after: always;
        }
        td,
        th {
            border: 1px solid black;
            padding: 4px;
            vertical-align: middle;
            text-align: left;
        }

        th {
            background-color: white;
            text-align: center;
        }

        td[colspan="2"] {
            text-align: center;
        }

        .header-row td {
            text-align: center;
            padding: 2px;
        }

        .no-border {
            border: none !important;
        }

        .signature-section {
            margin-top: 10px;
        }

        .signature-section .left {
            float: left;
            width: 50%;
            text-align: left;
            margin-top: 10px;
            padding-left: 50px;
        }

        .signature-section .right {
            float: right;
            text-align: left;
            padding-right: 50px;
            margin-top: 20px;
        }

        .date-section {
            text-align: right;
            margin-bottom: 0px;
            padding-right: 50px;
            margin-top: 30px;
        }

        .clear {
            clear: both;
        }
    </style>
</head>
<body>
    @foreach ($standardCriterias as $criteria)
    <div class="page-break"></div>
    <table>
        <tr class="header-row">
        <td rowspan="6" style="width: 10%;"><center><img src="{{ public_path('/assets/img/picture2.png') }}" alt="Logo" style="width: 10px; height: auto;"></center></td>
            <td colspan="3" style="width: 75%; padding: 2px;"><center><b>ABSENSI KEGIATAN</b></center></td>
            <td rowspan="6" style="width: 10%;"><center>FM/JGU/L.007</center></td>
        </tr>
        <tr>
            <td colspan="3" style="padding: 2px;"><center><b>{{ $criteria->title }}</b></center></td>
        </tr>
        <tr>
            <td style="width: 20%; padding: 2px;">Hari/Tgl.</td>
            <td colspan="2" style="padding: 2px;">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, j F Y') }}</td>
        </tr>
        @foreach($observations as $observation)
            <tr>
                <td style="padding: 2px;">Tempat</td>
                <td colspan="2" style="padding: 2px;">{{ $observation->location->title }}</td>
            </tr>
        @endforeach
        <tr>
            <td style="padding: 2px;">Pimpinan Rapat</td>
            <td colspan="2" style="padding: 2px;">{{ $auditors->first()->auditor->name }}</td>
        </tr>
        <tr>
            <td style="padding: 2px;">Peserta Rapat</td>
            <td colspan="2" style="padding: 2px;">Anggota Auditor & Auditee</td>
        </tr>
        <tr>
            <th style="width: 2%;"><center>No</center></th>
            <th style="width: 55%;"><center>Nama</center></th>
            <th style="width: 20%;"><center>Jabatan</center></th>
            <th style="width: 20%;" colspan="2"><center>Paraf</center></th>
        </tr>
        <tr>
            <td><center>1</center></td>
            <td>{{ $auditors->first()->auditor->name }}</td>
            <td><center>Ketua Auditor</center></td>
            <td class="signature-cell"></td>
            <td class="signature-cell"></td>
        </tr>
        <tr>
            <td><center>2</center></td>
            <td>@if($auditors->count() > 1) {{ $auditors->get(1)->auditor->name }} @endif</td>
            <td><center>Anggota</center></td>
            <td class="signature-cell"></td>
            <td class="signature-cell"></td>
        </tr>
        <tr>
            <td><center>3</center></td>
            <td>{{ $data->auditee->name }}</td>
            <td><center>Auditee</center></td>
            <td class="signature-cell"></td>
            <td class="signature-cell"></td>
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
