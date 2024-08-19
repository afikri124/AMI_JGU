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
    </style>
</head>
<body>
<table width="100%">
        <tr>
            <td width="50%" style="text-align: right;">
                <img src="{{ public_path('assets/images/logo.png') }}" style="height: 60px;" alt="">
            </td>
        </tr>
    </table>
    <center>
        <h5><u>BERITA ACARA <i>AUDIT MUTU INTERNAL</i></u></h5>
    </center>
    <table width="100%">
        <tr>
            <td colspan="2">
                <p style="text-align: justify; margin-top:20px">Dalam rangka Pelaksanaan Audit Mutu Internal di lingkungan
                    Universitas
                    Global Jakarta, maka pada hari ini:</p>
            </td>
        </tr>
        <tr>
            <td width="30%" valign="top">Hari/tanggal</td>
            <td width="70%" valign="top">:
                {{ Date::createFromDate($data->date_start)->locale('id')->translatedFormat('l, j F Y') }}
                @if(date('d F Y', strtotime($data->date_start)) != date('d F Y', strtotime($data->date_end)))
                    - {{ Date::createFromDate($data->date_end)->locale('id')->translatedFormat('l, j F Y') }}
                @endif
            </td>
        </tr>
        <tr>
            <td width="30%" valign="top">Jam</td>
            <td width="70%" valign="top">:
                {{ Date::createFromDate($data->date_start)->locale('id')->translatedFormat('H:i') }}
                @if(date('H:i', strtotime($data->date_start)) != date('H:i', strtotime($data->date_end)))
                - {{ Date::createFromDate($data->date_end)->locale('id')->translatedFormat('H:i') }}
                @endif
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
                <p style="text-align: justify;padding-top:15px">Telah diselenggarakan kegiatan <i>Audit Mutu Internal</i>
                    di lingkungan Program Studi
                    <b>{{ ($data->departments->name==null ? $data->departments->name : $data->departments->name) }}</b>,
                    sebagaimana
                    tercantum dalam daftar hadir terlampir. Unsur kegiatan pada hari ini antara lain:</p>
            </td>
        </tr>
        <tr>
            <td width="30%" valign="top">Auditor</td>
            <td width="70%" valign="top">: {{ $auditors->first()->auditor->name }}
            </td>
        </tr>
        <tr>
            <td width="30%" valign="top">Auditee</td>
            <td width="70%" valign="top">: {{ $data->auditee->name }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <p style="text-align: justify;padding-top:15px">Setalah dilakukan Audit Dokumen dan Audit Lapangan,
                    selanjutnya semua unsur yang terlibat dalam kegiatan tersebut menyimpulkan beberapa hal antara lain:
                </p>
                @php $counter = 1; @endphp
                    @foreach ($obs_c as $c)
                        @if (in_array($c->obs_checklist_option, ["OBS", "KTS MINOR", "KTS MAYOR"]))
                            <ul>
                                {{ $counter }}. {{ $c->remark_description }}
                            </ul>
                            @php $counter++; @endphp
                        @endif
                    @endforeach
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <p style="text-align: justify;padding-top:15px">Demikian berita acara ini dibuat dan disahkan dengan
                    sebenar-benarnya dan tanggung jawab agar dapat dipergunakan sebagaimana mestinya.</p>
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="50%"></td>
            <td width="50%" style="text-align: center;">Depok, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('j F Y') }}
            </td>
        </tr>
        <tr>
            <td width="50%" style="text-align: left;">
                Kepala Auditor<br><br><br>({{ $auditors->first()->auditor->name }})<br>
                NIK. {{ $auditors->first()->auditor->nidn }}
            </td>
            <td width="50%" style="text-align: left;">
                Auditor<br><br><br>
                (@if($auditors->count() > 1) {{ $auditors->get(1)->auditor->name }} @endif)<br>
                NIK. @if($auditors->count() > 1) {{ $auditors->get(1)->auditor->nidn }} @endif
            </td>
        </tr>
        <br>
        <tr>
            <td width="50%" style="text-align: left;">
                Mengetahui,<br>Kepala LPM<br><br><br><br>
                ( {{ $hodLPM->title }} )<br>
                NIK. {{ $hodLPM->content }}
            </td>
            <td width="50%" style="text-align: left;">
                <br>Auditee<br><br><br><br>
                ( {{ $data->auditee->name }} )<br>
                NIK. {{ $data->auditee->nidn }}
            </td>
        </tr>
    </table>
