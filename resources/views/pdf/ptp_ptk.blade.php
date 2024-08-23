<html>
<head>
    <title>AMI Report | {{date('d/m/Y', strtotime($data->date_start)) }}
    </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        @page {
            size: A4 landscape;
            margin: 2cm 1cm;
        }

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
            border: 2px solid black;
            padding: 8px;
            vertical-align: top;
        }
        th {
            background-color: white;
        }
        .checkbox-container {
        display: flex;
        align-items: center;
        }

        .checkbox-group {
            display:block;
            align-items: center;
            margin-right: 10px; /* Spasi antar checkbox, sesuaikan sesuai kebutuhan */
        }

        .checkbox-group input {
            margin-right: 8px; /* Spasi antara checkbox dan label */
        }
        .sub-table {
        width: 100%;
        border-collapse: collapse;
        }

        .sub-table td {
            border: 1px solid black;
            padding: 5px;
            vertical-align: top;
        }

        .divider {
            text-align: center;
        }

        .paraf {
            height: 60px; /* Mengatur tinggi untuk area paraf */
            vertical-align: middle; /* Menjaga teks paraf berada di tengah secara vertikal */
        }
    </style>
</head>
<body>
@foreach ($standardCriterias as $criteria)
<div class="page-break"></div>
<table width="100%">
    <tr>
        <td colspan="1" rowspan="2" class="center">
            <center><img src="{{ public_path('/assets/img/picture2.png') }}" alt="Logo" style="width: 10px; height: auto;"></center>
        </td>
        <td width="20%" valign="top" class="header">
            <center>
            UNIVERSITAS GLOBAL JAKARTA
            </center>
        </td>
    </tr>
    <tr>
        <td width="20%" valign="top"><center>PERMINTAAN TINDAKAN KOREKSI (PTK)</center>
        </td>
    </tr>
    <tr>
        <td width="30%" valign="top">STANDAR</td>
        <td width="70%" valign="top">
            {{ $criteria->title }}
        </td>
    </tr>
    <tr>
        <td width="30%" valign="top">AREA AUDIT</td>
        <td width="70%" valign="top">{{$data->locations->title}}</td>
    </tr>
    <tr>
        <td width="30%" valign="top">AUDITEE</td>
        <td width="70%" valign="top">{{$data->auditee->name}}</td>
    </tr>
    <tr>
        <td width="30%" valign="top">TIPE AUDIT</td>
        <td width="70%" valign="top">{{$data->type_audit}}</td>
    </tr>
    <tr>
        <td width="30%" valign="top">PERIODE AUDIT</td>
        <td width="70%" valign="top">{{$data->periode}}</td>
    </tr>
    <tr>
        <td width="30%" valign="top">AUDITOR</td>
        <td width="70%" valign="top">KETUA : {{ $auditors->first()->auditor->name }}
                <br>ANGGOTA : {{$hodLPM->title}}
        </td>
    </tr>
    <tr>
        <td>KATEGORI TEMUAN AUDIT
            <td>
            <input type="radio" value="OBSERVASI" disabled/>
            <label>Observasi</label>

            <input type="radio" value="KTS MINOR" disabled/>
            <label>KTS Minor</label>

            <input type="radio" value="KTS MAYOR" disabled/>
            <label>KTS Mayor</label>
        </td>
    </tr>
    <tr>
        <td width="30%" valign="top">NOMOR DOKUMEN</td>
        <td></td>
    </tr>
    </table>
    <table width="100%">
    <tr>
        <th><center>NO</center></th>
        <th><center>DESKRIPSI TEMUAN AUDIT</center></th>
        <th><center>AKAR PENYEBAB/FAKTOR PENGHAMBAT</center></th>
        <th><center>REKOMENDASI</center></th>
        <th><center>RENCANA PERBAIKAN</center></th>
        <th><center>JADWAL PENYELESAIAN</center></th>
        <th><center>PIHAK BERTANGGUNG JAWAB</center></th>
    </tr>
    <tr>
    @php $counter = 1; @endphp
    @foreach ($criteria->indicators as $indicator)
        @foreach ($observations as $observation)
    @foreach ($observations as $observation)
        @php
            $filteredObs = $obs_c->where('observation_id', $observation->id)
                                    ->where('indicator_id', $indicator->id);
        @endphp
        @foreach ($filteredObs as $obsChecklist)
            @if ($obsChecklist->obs_checklist_option == "OBS" ||
                $obsChecklist->obs_checklist_option == "KTS MINOR" ||
                $obsChecklist->obs_checklist_option == "KTS MAYOR")
        <tr>
            <td class="center">{{ $counter }}.</td>
            <td><center>{{ $obsChecklist->remark_description }}</center></td>
            <td><center>{!! $obsChecklist->remark_success_failed !!}</center></td>
            <td><center>{!! $obsChecklist->remark_recommend !!}</center></td>
            <td><center>{{ $obsChecklist->remark_upgrade_repair }}</center></td>
            <td><center>{!! $observation->plan_complated !!}</center></td>
            <td><center>{!! $observation->person_in_charge !!}</center></td>
        </tr>
            @php $counter++; @endphp
            @endif
    @endforeach
    @endforeach
    @endforeach
    @endforeach
  </table>
  <table width="100%">
    <tr>
        <th>DISUSUN</th>
        <th>DIPERIKSA</th>
        <th>DIVALIDASI/DISETUJUI</th>
    </tr>
    <tr>
        <td>
        <table class="sub-table">
                <tr>
                    <td>Oleh:</td>
                    <td>{{ $data->auditee->name }}</td>
                </tr>
                <tr>
                    <td>Tanggal:</td>
                    <td>
                    @foreach ($observations as $obs )
                        {{ Date::createFromDate($obs->date_prepared)->locale('id')->translatedFormat('l, j F Y') }}
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td>Paraf:</td>
                    <td class="paraf no-border">&nbsp;</td>
                </tr>
            </table>
        </td>
        <td>
            <table class="sub-table">
                <tr>
                    <td>Oleh:</td>
                    <td>{{ $auditors->first()->auditor->name }}</td>
                </tr>
                <tr>
                    <td>Tanggal:</td>
                    <td>
                    @foreach ($observations as $obs )
                        {{ Date::createFromDate($obs->date_checked)->locale('id')->translatedFormat('l, j F Y') }}
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td>Paraf:</td>
                    <td class="paraf no-border">&nbsp;</td>
                </tr>
            </table>
        </td>
        <td>
            <table class="sub-table">
                <tr>
                    <td>Oleh:</td>
                    <td>{{ $hodLPM->title }}</td>
                </tr>
                <tr>
                    <td>Tanggal:</td>
                    <td>
                    @foreach ($observations as $obs)
                        @if ($obs->date_validated)
                            {{ Date::createFromDate($obs->date_validated)->locale('id')->translatedFormat('l, j F Y') }}
                        @else
                            <!-- Tidak menampilkan apa-apa jika date_validated kosong -->
                        @endif
                    @endforeach
                    </td>
                </tr>
                <tr>
                    <td>Paraf:</td>
                    <td class="paraf no-border">&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
  <table width="100%">
    <tr>
        <td class="paraf no-border">CATATAN:</td>
    </tr>
</table>
@endforeach

@foreach ($standardCriterias as $criteria)
<div class="page-break"></div>
<table width="100%">
<tr>
        <td colspan="1" rowspan="2" class="center">
            <center><img src="{{ public_path('/assets/img/picture2.png') }}" alt="Logo" style="width: 10px; height: auto;"></center>
        </td>
        <td width="30%" valign="top" class="header">
            <br><center>
            UNIVERSITAS GLOBAL JAKARTA
            </center><br>
        </td>
    </tr>
    <tr>
        <td width="30%" valign="top"><center>PERMINTAAN TINDAKAN PENINGKATAN
            <br>(PTP)</center>
        </td>
    </tr>
    <tr>
        <td width="30%" valign="top">STANDAR</td>
        <td width="70%" valign="top">
            {{ $criteria->title }}
        </td>
    </tr>
    <tr>
        <td width="30%" valign="top">AREA AUDIT</td>
        <td width="70%" valign="top">{{$data->locations->title}}</td>
    </tr>
    <tr>
        <td width="30%" valign="top">AUDITEE</td>
        <td width="70%" valign="top">{{$data->auditee->name}}</td>
    </tr>
    <tr>
        <td width="30%" valign="top">TIPE AUDIT</td>
        <td width="70%" valign="top">{{$data->type_audit}}</td>
    </tr>
    <tr>
        <td width="30%" valign="top">PERIODE AUDIT</td>
        <td width="70%" valign="top">{{$data->periode}}</td>
    </tr>
    <tr>
        <td width="30%" valign="top">AUDITOR</td>
        <td width="70%" valign="top">KETUA : {{ $auditors->first()->auditor->name }}
                <p></p>ANGGOTA : {{$hodLPM->title}}
        </td>
    </tr>
    <tr>
        <td width="30%" valign="top">NOMOR DOKUMEN</td>
        <td></td>
    </tr>
    </table>

    <table width="100%">
    <tr>
        <th><center>NO</center></th>
        <th><center>DESKRIPSI TEMUAN AUDIT</center></th>
        <th><center>FAKTOR PENDUKUNG KEBERHASILAN</center></th>
        <th><center>REKOMENDASI</center></th>
        <th><center>RENCANA PENINGKATAN</center></th>
        <th><center>JADWAL PENYELESAIAN</center></th>
        <th><center>PIHAK BERTANGGUNG JAWAB</center></th>
    </tr>
    <tr>
@php $counter = 1; @endphp
    @foreach ($criteria->indicators as $indicator)
        @foreach ($observations as $observation)
    @foreach ($observations as $observation)
        @php
            $filteredObs = $obs_c->where('observation_id', $observation->id)
                                    ->where('indicator_id', $indicator->id);
        @endphp
        @foreach ($filteredObs as $obsChecklist)
            @if ($obsChecklist->obs_checklist_option == "KS")
                <tr>
                    <td class="center">{{ $counter }}.</td>
                    <td><center>{{ $obsChecklist->remark_description }}</center></td>
                    <td><center>{!! $obsChecklist->remark_success_failed !!}</center></td>
                    <td><center>{!! $obsChecklist->remark_recommend !!}</center></td>
                    <td><center>{{ $obsChecklist->remark_upgrade_repair }}</center></td>
                    <td><center>{!! $observation->plan_complated !!}</center></td>
                    <td><center>{!! $observation->person_in_charge !!}</center></td>
                </tr>
                @php $counter++; @endphp
            @endif
            @endforeach
            @endforeach
            @endforeach
            @endforeach
        </table>
  <table width="100%">
    <tr>
        <th>DISUSUN</th>
        <th>DIPERIKSA</th>
        <th>DIVALIDASI/DISETUJUI</th>
    </tr>
    <tr>
        <td>
        <table class="sub-table">
                <tr>
                    <td>Oleh:</td>
                    <td>{{ $data->auditee->name }}</td>
                </tr>
                <tr>
                    <td>Tanggal:</td>
                    <td>
                    @foreach ($observations as $obs )
                        {{ Date::createFromDate($obs->date_prepared)->locale('id')->translatedFormat('l, j F Y') }}
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td>Paraf:</td>
                    <td class="paraf no-border">&nbsp;</td>
                </tr>
            </table>
        </td>
        <td>
            <table class="sub-table">
                <tr>
                    <td>Oleh:</td>
                    <td>{{ $auditors->first()->auditor->name }}</td>
                </tr>
                <tr>
                    <td>Tanggal:</td>
                    <td>
                    @foreach ($observations as $obs )
                        {{ Date::createFromDate($obs->date_checked)->locale('id')->translatedFormat('l, j F Y') }}
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td>Paraf:</td>
                    <td class="paraf no-border">&nbsp;</td>
                </tr>
            </table>
        </td>
        <td>
            <table class="sub-table">
                <tr>
                    <td>Oleh:</td>
                    <td>{{ $hodLPM->title }}</td>
                </tr>
                <tr>
                    <td>Tanggal:</td>
                    <td>
                    @foreach ($observations as $obs)
                        @if ($obs->date_validated)
                            {{ Date::createFromDate($obs->date_validated)->locale('id')->translatedFormat('l, j F Y') }}
                        @else
                            <!-- Tidak menampilkan apa-apa jika date_validated kosong -->
                        @endif
                    @endforeach
                    </td>
                </tr>
                <tr>
                    <td>Paraf:</td>
                    <td class="paraf no-border">&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
  <table width="100%">
    <tr>
        <td class="paraf no-border">CATATAN:</td>
    </tr>
</table>
@endforeach
