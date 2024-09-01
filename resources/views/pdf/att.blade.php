<html>
<head>
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
            margin-top: 5px;
        }

        .signature-section .left {
            float: left;
            width: 50%;
            text-align: left;
            margin-top: 1px;
            padding-left: 135px;
        }

        .signature-section .right {
            float: right;
            text-align: left;
            padding-right: 135px;
            margin-top: 30px;
        }

        .date-section {
            text-align: right;
            padding-right: 100px;
            margin-top: 5px;
        }

        .clear {
            clear: both;
        }
    </style>
</head>
<body>
    @foreach ($standardCriterias as $criteria)
    <div class="page-break">
        <table>
        <tr class="header-row">
        <td rowspan="6" style="width: 10%;"><center><img src="{{ public_path('/assets/img/picture2.png') }}" alt="Logo" style="width: 100px; height: auto;"></center></td>
            <td colspan="3" style="width: 75%; padding: 2px;"><center><b>ABSENSI KEGIATAN</b></center></td>
            <td rowspan="6" style="width: 10%;"><center>FM/JGU/L.007</center></td>
        </tr>
        <tr>
            <td colspan="3" style="padding: 2px;"><center><b>{{ $criteria->title }}</b></center></td>
        </tr>
        <tr>
            <td style="width: 20%; padding: 2px;">Hari/Tgl.</td>
            <td colspan="2" style="padding: 2px;">
                @foreach ($observations as $obs)
                    @if ($obs->date_prepared)
                        {{ Date::createFromDate($obs->date_prepared)->locale('id')->translatedFormat('l, j F Y') }}
                    @else
                        <!-- Tidak menampilkan apa-apa jika date_prepared kosong -->
                    @endif
                @endforeach
            </td>
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
        <tr style="height: 50px;">
            <th style="width: 2%; padding: 10px 0;"><center>No</center></th>
            <th style="width: 40%; padding: 10px 0;"><center>Nama</center></th>
            <th style="width: 30%; padding: 10px 0;"><center>Jabatan</center></th>
            <th style="width: 20%; padding: 10px 0;" colspan="2"><center>Paraf</center></th>
        </tr>
        <tr>
            <td style="padding: 15px 0;"><center>1.</center></td>
            <td style="padding: 15px 0;"><center>{{ $auditors->first()->auditor->name }}</center></td>
            <td style="padding: 15px 0;"><center>Ketua Auditor</center></td>
            <td class="signature-cell" style="padding: 15px 0;">1.</td>
            <td class="signature-cell" style="padding: 15px 0;"></td>
        </tr>
        <tr>
            <td style="padding: 15px 0;"><center>2.</center></td>
            <td style="padding: 15px 0;"><center>@if($auditors->count() > 1) {{ $auditors->get(1)->auditor->name }} @endif</center></td>
            <td style="padding: 15px 0;"><center>Anggota</center></td>
            <td class="signature-cell" style="padding: 15px 0;"></td>
            <td class="signature-cell" style="padding: 15px 0;">2.</td>
        </tr>
        <tr>
            <td style="padding: 15px 0;"><center>3.</center></td>
            <td style="padding: 15px 0;"><center>{{ $data->auditee->name }}</center></td>
            <td style="padding: 15px 0;"><center>Auditee</center></td>
            <td class="signature-cell" style="padding: 15px 0;">3.</td>
            <td class="signature-cell" style="padding: 15px 0;"></td>
        </tr>
    </table>
    <div class="date-section">
        <p style="text-align: right;">Depok, 
            @foreach ($observations as $obs)
            @if ($obs->date_prepared)
                {{ Date::createFromDate($obs->date_prepared)->locale('id')->translatedFormat('j F Y') }}
            @else
                <!-- Tidak menampilkan apa-apa jika date_validated kosong -->
            @endif
        @endforeach</p>
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
</div>
@endforeach
