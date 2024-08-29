<html>
<head>
    <title>AMI Report | {{date('d/m/Y', strtotime($data->date_start)) }}
    </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        html {
            margin: 1cm 2cm
        }

        .page-break {
            page-break-after: always;
        }

        body {
            font-size: 11pt;
            font-family: "Times New Roman", Times, serif;
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
            width: 50%;
            text-align: left;
            margin-top: 20px;
            padding-left: 100px;
        }

        .date-section {
            text-align: left;
            margin-top: 20px;
            padding-left: 10px;
        }

        .clear {
            clear: both;
        }
    </style>
</head>
<body>
<table width="100%">
        <tr>
            <td width="50%" style="text-align: right;">
                <img src="{{ public_path('/assets/img/picture2.png') }}" alt="Logo" style="width: 100px; height: auto;">
            </td>
        </tr>
    </table>
    <center>
        <h4><u>BERITA ACARA <i>AUDIT MUTU INTERNAL</i></u></h4>
    </center>
    <table width="100%">
        <tr>
            <td colspan="2">
                <br style="text-align: justify; margin-top:20px">Dalam rangka Pelaksanaan Audit Mutu Internal di lingkungan
                    Universitas
                    Global Jakarta, maka pada hari ini:</br>
            </td>
        </tr>
        <tr>
            <td width="30%" valign="top">Hari/tanggal</td>
            <td width="70%" valign="top">:
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
            <td width="30%" valign="top">Jam</td>
            <td width="70%" valign="top">:
                {{ Date::createFromDate($data->date_start)->locale('id')->translatedFormat('H:i') }}
                WIB
            </td>
        </tr>
        <tr>
            <td width="30%" valign="top">Tempat</td>
            <td width="70%" valign="top">:
                {{ $data->locations->title }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <br style="text-align: justify;padding-top:15px">Telah diselenggarakan kegiatan <i>Audit Mutu Internal</i>
                    di lingkungan Program Studi
                    <b>{{ ($data->departments->name==null ? $data->departments->name : $data->departments->name) }}</b>,
                    sebagaimana
                    tercantum dalam daftar hadir terlampir. Unsur kegiatan pada hari ini antara lain:</br>
            </td>
        </tr>
        <tr>
            <td width="30%" valign="top">Ketua Audit</td>
            <td width="70%" valign="top">: {{ $auditors->first()->auditor->name }}
            </td>
        </tr>
        <tr>
            <td width="30%" valign="top">Anggota Audit</td>
            <td width="70%" valign="top">: @if($auditors->count() > 1) {{ $auditors->get(1)->auditor->name }} @endif
            </td>
        </tr>
        <tr>
            <td width="30%" valign="top">Auditee</td>
            <td width="70%" valign="top">: {{ $data->auditee->name }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <br style="text-align: justify;padding-top:15px">Setalah dilakukan Audit Dokumen dan Audit Lapangan,
                    selanjutnya semua unsur yang terlibat dalam kegiatan tersebut menyimpulkan beberapa hal antara lain:
                @php $counter = 1; @endphp
                    @foreach ($obs_c as $c)
                        @if (in_array($c->obs_checklist_option, ["OBS", "KTS MINOR", "KTS MAYOR"]))
                            <ol style="margin-top: 1px; margin-bottom:0%">
                                {{ $counter }}. {{ $c->remark_description }}
                            </ol>
                            @php $counter++; @endphp
                        @endif
                    @endforeach
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <p style="text-align: justify;padding-top:1 px">Demikian berita acara ini dibuat dan disahkan dengan
                    sebenar-benarnya dan tanggung jawab agar dapat dipergunakan sebagaimana mestinya.</p>
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr class="date-section">
            <td></td>
            <td style="text-align: right;">Depok, 
            @foreach ($observations as $obs)
                @if ($obs->date_validated)
                    {{ Date::createFromDate($obs->date_validated)->locale('id')->translatedFormat('j F Y') }}   
                @endif
            @endforeach</td>
        </tr>
        <br>
        <tr class="signature-section">
            <td class="left">
                Kepala Audit<br><br><br><br>({{ $auditors->first()->auditor->name }})<br>
                NIK. {{ $auditors->first()->auditor->nidn }}
            </td>
            <td class="right">
                Anggota Audit<br><br><br><br>
                (@if($auditors->count() > 1) {{ $auditors->get(1)->auditor->name }} @endif)<br>
                NIK. @if($auditors->count() > 1) {{ $auditors->get(1)->auditor->nidn }} @endif
            </td>
        </tr>
        <br>
        <tr class="signature-section">
            <td class="left">
                Mengetahui,<br>Kepala LPM<br><br><br><br>
                ( {{ $hodLPM->title }} )<br>
                NIK. {{ $hodLPM->content }}
            </td>
            <td class="right">
                <br>Ketua BPMI<br><br><br><br>
                ( {{ $hodBPMI->title }} )<br>
                NIK. {{ $hodBPMI->content }}
            </td>
            <div class="clear"></div>
        </tr>
    </table>
