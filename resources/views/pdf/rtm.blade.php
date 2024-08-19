<html>
<head>
    <title>RTM Report | {{ date('d/m/Y') }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        @page {
            size: A4 landscape;
            margin: 2cm 1cm;
        }

        body {
            font-size: 11pt;
            font-family: "Times New Roman", Times, serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: white;
        }

        .paraf {
            height: 60px;
            vertical-align: middle;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
  <table width="100%">
    <tr style="height: 20px">
    <td>
    <center><img src="" style="height: 50px;" alt="Logo"></center>
</td>

        <td ><center>ABSENSI KEGIATAN</center></td>
        <td><center>FM/JGU/L.007</center></td>
    </tr>
  </table>

  <br>

  <b><center>RAPAT TINJAUAN MANAJEMEN PRODI {{ $data->departments->name }} TAHUN {{ $data->periode }}</center></b>
    <p></p>
  <table width="100%">
    <tr>
        <th><center>NO</center></th>
        <th><center>Standar Mutu </center></th>
        <th><center>Deskripsi Permasalahan</center></th>
        <th><center>Akar Penyebab</center></th>
        <th><center>Tindakan Koreksi/ <br>Tindakan Perbaikan <br>dan Peningkatan</center></th>
        <th><center>Target Waktu</center></th>
        <th><center>Pihak yang <br>Bertanggung Jawab</center></th>
        <th><center>Status Akhir</center></th>
    </tr>
    <tr>
    @php $counter = 1; @endphp
@foreach ($standardCriterias as $criteria)
    @php $isFirstRow = true; @endphp
    @foreach ($criteria->indicators as $indicator)
        @foreach ($observations as $observation)
            @php
                $filteredObs = $obs_c->where('observation_id', $observation->id)
                                        ->where('indicator_id', $indicator->id);
            @endphp
            @foreach ($filteredObs as $obsChecklist)
                <tr>
                    @if ($isFirstRow)
                        <td><center>{{ $counter }}.</center></td>
                        <td><b>{{ $criteria->title }}</b></td>
                        @php $isFirstRow = false; @endphp
                    @else
                        <td></td>
                        <td></td>
                    @endif
                    <td>{{ $obsChecklist->remark_description }}</td>
                    <td>{{ $obsChecklist->remark_success_failed }}</td>
                    <td>{{ $obsChecklist->remark_upgrade_repair }}</td>
                    <td>{{ $observation->plan_complated }}</td>
                    <td>{{ $observation->person_in_charge }}</td>
            @endforeach
            @php
                $filteredRtm = $rtm->where('observation_id', $observation->id)
                                    ->where('indicator_id', $indicator->id);
            @endphp
            @foreach ($filteredRtm as $r)
                @if ($r->status)
                        <td>{{ $r->status }}</td>
                    </tr>
                @endif
            @endforeach
        @endforeach
    @endforeach
    @php
        $counter++;
        $isFirstRow = true;
    @endphp
@endforeach
</table>
<table width="100%">
        <tr>
            <td width="50%"></td>
            <td width="50%" style="text-align: center;">
            {{ Date::createFromDate($data->date_start)->locale('id')->translatedFormat('l, j F Y') }}
            </td>
        </tr>
        <tr>
            <td width="50%" style="text-align: center;">
                Ka. Prodi {{ $data->departments->name }}<br><br><br><br>
                <b> {{ $hodLPM->title }} </b><br>
            </td>
            <td width="50%" style="text-align: center;">
                UPM Prodi {{ $data->departments->name }}<br><br><br><br>
                <b> {{ $data->auditee->name }} </b><br>
            </td>
        </tr>
    </table>
</body>
</html>
