<html>
<head>
    <title>AMI Report | {{date('d/m/Y', strtotime($data->date_start)) }}
    </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        html {
            size: landscape;
            margin: 1cm 2cm
        }

        .page-break {
            page-break-after: always;
        }

        body {
            font-size: 11pt;
            font-family: "Times New Roman", Times, serif;
        }

        table {
        border-collapse: collapse;
        }

        th, td {
            border: 2px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: white;
        }
    </style>
</head>
<body>
  @foreach ($standardCriterias as $criteria)
  <table width="100%">
      <tr style="height: 20px">
        <td colspan="2" rowspan="6"><center><img src="/assets/img/logo/logo_small.png" alt=""></center></td>
        <td colspan="2"><center>ABSENSI KEGIATAN</center></td>
        <td colspan="2" rowspan="6"><center>FM/JGU/L.007</center></td>
      </tr>
      <tr style="height: 20px">
        <td colspan="2"><center>
            {{ $criteria->title }}
        </center></td>
      </tr>
      <tr style="height: 20px">
        <td class="s1">Hari/Tgl.</td>
        <td class="s1">
            {{ Date::createFromDate($data->date_start)->format('l, j F Y') }}
            @if(date('d F Y', strtotime($data->date_start)) != date('d F Y', strtotime($data->date_end)))
            - {{ Date::createFromDate($data->date_end)->format('l, j F Y') }}
            @endif
        </td>
      </tr>
      <tr style="height: 20px">
        <td class="s1">Tempat</td>
        <td class="s1">{{$data->locations->title}}</td>
      </tr>
      <tr style="height: 20px">
        <td class="s1">Pimpinan Rapat</td>
        <td class="s1">{{ $auditor->auditor->name }}</td>
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
        <td rowspan="2"><center>1</center></td>
        <td colspan="2" rowspan="2"><center>{{ $auditor->auditor->name }}</center></td>
        <td rowspan="2"><center>Ketua Auditor</center></td>
        <td rowspan="2">1.</td>
        <td rowspan="2"></td>
      </tr>
      <tr style="height: 35px">
      </tr>
      <tr style="height: 35px">
        <td rowspan="2"><center>2</center></td>
        <td colspan="2" rowspan="2"><center>Auditor 2</center></td>
        <td rowspan="2"><center>Anggota</center></td>
        <td rowspan="2"></td>
        <td rowspan="2">2.</td>
      </tr>
      <tr style="height: 35px">
      </tr>
      <tr style="height: 35px">
        <td rowspan="2"><center>3</center></td>
        <td colspan="2" rowspan="2"><center>{{$data->auditee->name}}</center></td>
        <td rowspan="2"><center>Auditee</center></td>
        <td rowspan="2">3.</td>
        <td rowspan="2"></td>
      </tr>
      <tr style="height: 35px">
      </tr>
  </table>
  <table width="100%">
        <tr>
            <td width="50%"></td>
            <td width="50%" style="text-align: center;">Depok,
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
  @endforeach
    <div class="page-break"></div>
    <table width="100%">
        <tr>
            <td width="50%" valign="top">
                <code style="color: black;font-size:9pt">FM/JGU/L.xxx</code><br>
                <a href=""><img src="" style="height: 85px;"></a>
            </td>
            <td width="50%" style="text-align: right;">
                <img src="{{ public_path('assets/images/logo.png') }}" style="height: 60px;" alt="">
            </td>
        </tr>
    </table>
    <br>
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
                {{ Date::createFromDate($data->date_start)->format('l, j F Y') }}
                @if(date('d F Y', strtotime($data->date_start)) != date('d F Y', strtotime($data->date_end)))
                - {{ Date::createFromDate($data->date_end)->format('l, j F Y') }}
                @endif
            </td>
        </tr>
        <tr>
            <td width="30%" valign="top">Jam</td>
            <td width="70%" valign="top">:
                {{ Date::createFromDate($data->date_start)->format('H:i') }}
                @if(date('H:i', strtotime($data->date_start)) != date('H:i', strtotime($data->date_end)))
                - {{ Date::createFromDate($data->date_end)->format('H:i') }}
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
            <td width="70%" valign="top">:
            </td>
        </tr>
        <tr>
            <td width="30%" valign="top">Auditee</td>
            <td width="70%" valign="top">: {{ $data->auditee->name }}
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
            <td width="50%" style="text-align: center;">Depok,
            </td>
        </tr>
        <tr>
            <td width="50%" style="text-align: center;">
                Auditor<br><br><br><br>
                </td>
        </tr>
        <tr>
            <td colspan="2"><br></td>
        </tr>
        <tr>
            <td width="50%" style="text-align: center;">
                Mengetahui,<br>Kepala LPM<br><br><br><br>
                <b>( {{ $hodLPM->title }} )</b><br>
                <small>NIK. {{ $hodLPM->content }} </small>
            </td>
            <td width="50%" style="text-align: center;">
                <br>Auditee<br><br><br><br>
                <b>( {{ $data->auditee->name }} )</b><br>
                <small>NIK. {{ $data->auditee->nidn }}</small>
            </td>
        </tr>
    </table>
</body>
</html>



<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .table-container {
            width: 100%;
            border-collapse: collapse;
        }
        .table-container th, .table-container td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .table-container td {
            text-align: center;
        }
    </style>
</head>
<body>
    <table class="table-container">
        <thead>
            <tr>
                <th>No</th>
                <th>Standard<br>Mutu</th>
                <th>Deskrisi<br>Permasalahan</th>
                <th>Akar Penyebab</th>
                <th>Tindakan Koreksi/<br>Tindakan Perbaikan<br>dan Peningkatan</th>
                <th>Target Waktu</th>
                <th>Pihak dan <br> Bertanggung Jawab</th>
                <th>Status Akhir</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($standardCriterias as $criteria)
        @foreach ($observations as $observation)
        @foreach ($obs_c as $obsChecklist)
            <tr>
                <td class="center">{{ $loop->parent->iteration }}.</td>
                <td>{{ $criteria->title }}</td>
                <td>{{ $obsChecklist->remark_description }}</td>
                <td>{{ $obsChecklist->remark_success_failed }}</td>
                <td>{{ $obsChecklist->remark_upgrade_repair }}</td>
                <td>{{ $observation->plan_complated }}</td>
                <td>{{ $observation->person_in_charge }}</td>
            </tr>
            @endforeach
            @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html> -->

<!-- <!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet">
<title>Make Report</title>
    <style type="text/css">
    @page {
        size: A4 landscape; /* Atur ukuran kertas A4 dalam orientasi lanskap */
        margin: 20mm; /* Sesuaikan margin halaman jika perlu */
    }

    body {
        font-family: sans-serif;
        margin: 0;
        padding: 0;
        width: 297mm; /* Lebar halaman HVS dalam orientasi lanskap */
        height: 210mm; /* Tinggi halaman HVS dalam orientasi lanskap */
    }

    table {
        width: 100%; /* Tabel memenuhi lebar halaman */
        border-collapse: collapse;
    }

    th, td {
        border: 2px solid black;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: white;
    }

    .logo {
        width: 150px;
    }

    .signature-container {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }

    .signature {
        text-align: center;
    }

    .signature-1, .signature-2 {
        text-align: center;
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

    .page-break {
        page-break-before: always;
    }

    @media print {
        body {
            margin: 0;
            padding: 0;
        }
    }
    </style>
  </head>
  <body>
    @php
        use Carbon\Carbon;
        Carbon::setLocale('id');
    @endphp
  @foreach ($standardCriterias as $criteria)
  <table>
      <tr style="height: 20px">
        <td colspan="2" rowspan="6"><center><img src="/assets/img/logo/logo_small.png" alt=""></center></td>
        <td colspan="2"><center>ABSENSI KEGIATAN</center></td>
        <td colspan="2" rowspan="6"><center>FM/JGU/L.007</center></td>
      </tr>
      <tr style="height: 20px">
        <td colspan="2"><center>
            {{ $criteria->title }}
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
        <td class="s1">{{ $auditor->auditor->name }}</td>
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
        <td rowspan="2"><center>1</center></td>
        <td colspan="2" rowspan="2"><center>{{ $auditor->auditor->name }}</center></td>
        <td rowspan="2"><center>Ketua Auditor</center></td>
        <td rowspan="2">1.</td>
        <td rowspan="2"></td>
      </tr>
      <tr style="height: 35px">
      </tr>
      <tr style="height: 35px">
        <td rowspan="2"><center>2</center></td>
        <td colspan="2" rowspan="2"><center>Auditor 2</center></td>
        <td rowspan="2"><center>Anggota</center></td>
        <td rowspan="2"></td>
        <td rowspan="2">2.</td>
      </tr>
      <tr style="height: 35px">
      </tr>
      <tr style="height: 35px">
        <td rowspan="2"><center>3</center></td>
        <td colspan="2" rowspan="2"><center>{{$data->auditee->name}}</center></td>
        <td rowspan="2"><center>Auditee</center></td>
        <td rowspan="2">3.</td>
        <td rowspan="2"></td>
      </tr>
      <tr style="height: 35px">
      </tr>
  </table>
  @endforeach
       <div class="signature-1">
            <p>Kepala LPM</p>
            <br>
            <p>{{ $hodLPM->title }}
            <br>NIK. {{ $hodLPM->content }}
        </div>
        <div class="signature-1">
            <p>Ketua BPMI</p>
            <br>
            <p>{{ $hodBPMI->title }}
            <br>NIK. {{ $hodBPMI->content }}
        </div> -->

<!-- <div class="page-break">
    <!DOCTYPE html>
    <html lang="en">
    <body>
    <div class="container">
        <div class="header">
            <h5><u><center>BERITA ACARA <i>AUDIT MUTU INTERNAL</center></i></u></h5>
        </div>
        <class="content">
            <br>Dalam rangka Pelaksanaan Penjaminan Mutu di lingkungan Universitas Global Jakarta, maka pada hari ini:
            <br>Hari/Tanggal: {{ Carbon::parse($data->date_start)->translatedFormat('l, d F Y') }}
            <br>Jam: {{ Carbon::parse($data->date_start)->format('H:i') }} WIB
            <br>Tempat: {{$data->locations->title}}</br>
            <br>Telah diselenggarakan kegiatan <i>Audit Mutu Internal</i> di lingkungan Program Studi sebagaimana tercantum dalam daftar hadir terlampir. <br>
            Unsur kegiatan pada hari ini antara lain:
            <br>Ketua Audit: {{ $auditor->auditor->name }}
            <br>Anggota Audit: Auditor 2
            <br>Auditee: {{$data->auditee->name}}
            <p>Setelah dilakukan Audit Dokumen dan Audit Lapangan, selanjutnya semua unsur terlibat dalam kegiatan tersebut menyimpulkan beberapa hal <br>
             antara lain:</p>
                @foreach($obs_c as $c)
                    @if(in_array($c->obs_checklist_option, ['OBS', 'KTS MINOR', 'KTS MAYOR']))
                        <ul>{{ $loop->iteration }}. {{ $c->remark_description }}</ul>
                    @endif
                @endforeach
            <p>Demikian berita acara ini dibuat dan disahkan dengan sebenar-benarnya dan tanggung jawab agar dapat dipergunakan sebagaimana mestinya.</p>
            <p>Depok, {{ Carbon::parse($data->date_start)->translatedFormat('l, d F Y') }}</p>
</div>
                <p>Auditor</p>
                <br>
                <p>{{ $auditor->auditor->name }}</p>
                <p>NIK.</p>

                <p>Auditee</p>
                <br>
                <p>{{ $data->auditee->name }}</p>
                <p>NIK.</p>

                <p>Mengetahui,</p>
                <p>Kepala LPM</p>
                <br>
                <p>{{ $hodLPM->title }}</p>
                <p>NIK. {{ $hodLPM->content }}</p>

                <p>Ketua BPMI</p>
                <br>
                <p>{{ $hodBPMI->title }}</p>
                <p>NIK. {{ $hodBPMI->content }}</p>
</body>
</html>
</div> -->

<!-- <div class="page-break">
<html lang="en">
<style>
    .audit-report, .audit-report th, .audit-report td {
        border: 1px solid;
        background-color:white;
    }
    .audit-report th, .audit-report td {
        padding: 8px;
        text-align: left;
        background-color:white;
    }
    .audit-report th {
        background-color:white;
        text-align: center;
    }
    .audit-report .header {
        text-align: center;
        font-weight: bold;
    }
    .audit-report .center {
        text-align: center;
    }
    .audit-report .signature {
        height: 60px;
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
<body>
    <table class="audit-report">
    <tr>
        <td colspan="" rowspan="2" class="center">
            <img src="/assets/img/logo/logo_small.png" alt="Logo">
        </td>
        <td colspan="4" class="header">
            <br>UNIVERSITAS GLOBAL JAKARTA<br>
        </td>
    </tr>
    <tr>
        <td colspan="4">
            <br><center>DAFTAR PENGECEKAN / CHECK LIST<br>　</center>
        </td>
    </tr>
    <tr>
        <td >STANDAR</td>
        <td colspan="5">
        @foreach ($standardCriterias as $criteria)
            {{ $criteria->title }}
        @endforeach
        </td>
    </tr>
    <tr>
        <td>AREA AUDIT</td>
        <td colspan="5">{{$data->locations->title}}</td>
    </tr>
    <tr>
        <td>AUDITEE</td>
        <td colspan="5">{{$data->auditee->name}}</td>
    </tr>
    <tr>
        <td>TIPE AUDIT</td>
        <td colspan="5">{{$data->type_audit}}</td>
    </tr>
    <tr>
        <td>PERIODE AUDIT</td>
        <td colspan="3">{{$data->periode}}</td>
    </tr>
    <tr>
        <td>AUDITOR</td>
        <td colspan="5">KETUA : {{$auditor->auditor->name}}
                <p></p>ANGGOTA : {{$hodLPM->title}}
        </td>
    </tr>
    <tr>
        <td>NOMOR DOKUMEN</td>
    </tr>
    </table>

    <table class="audit-report">
    <tr>
        <th id="401587373C0" style="width:20px;" class="column-headers-background">NO</th>
        <th id="401587373C0" style="width:163px;" class="column-headers-background">INDIKATOR CAPAIAN STANDAR</th>
        <th id="401587373C0" style="width:293px;" class="column-headers-background">PERTANYAAN</th>
        <th id="401587373C0" style="width:203px;" class="column-headers-background">DOKUMEN YANG AKAN DICHECK</th>
    </tr>
    <tr>
    @foreach ($criteria->statements as $no => $statement)
    @foreach ($statement->indicators as $indicator)
        <td class="center">{{ $loop->parent->iteration }}.</td>
        <td>{{ $statement->name }}</td>
        <td>{!! $indicator->name !!}</td>
        <td>
        @foreach ($statement->reviewDocs as $reviewDoc)
            <ul>{!! $reviewDoc->name !!}</ul>
        @endforeach
        </td>
    </tr>
    @endforeach
    @endforeach
</table>
<table class="audit-report">
    <tr>
        <th style="height: 35px" colspan="3">VALIDASI DAN CATATAN</th>
    </tr>
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
                    <td>{{ $auditor->auditor->name }}</td>
                </tr>
                <tr>
                    <td>Tanggal:</td>
                    <td>{{ Carbon::parse($data->date_start)->translatedFormat('l, d F Y') }}</td>
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
                    <td>{{ $hodBPMI->title }}</td>
                </tr>
                <tr>
                    <td>Tanggal:</td>
                    <td>{{ Carbon::parse($data->date_end)->translatedFormat('l, d F Y') }}</td>
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
                    <td>{{ Carbon::parse($data->date_end)->translatedFormat('l, d F Y') }}</td>
                </tr>
                <tr>
                    <td>Paraf:</td>
                    <td class="paraf no-border">&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table class="audit-report">
    <tr>
        <td class="paraf no-border">CATATAN: {{$data->remark_docs }}</td>
    </tr>
</table>

<div class="page-break">
<table class="audit-report">
    <tr>
        <td colspan="" rowspan="2" class="center">
            <img src="/assets/img/logo/logo_small.png" alt="Logo">
        </td>
        <td colspan="4" class="header">
            <br>
            UNIVERSITAS GLOBAL JAKARTA
            <br>
        </td>
    </tr>
    <tr>
        <td colspan="4"><center>HASIL AUDIT LAPANGAN KESESUAIAN
            <br>(HAL-KS)</center>
        </td>
    </tr>
    <tr>
        <td >STANDAR</td>
        <td colspan="5">
        @foreach ($standardCriterias as $criteria)
            {{ $criteria->title }}
        @endforeach
        </td>
    </tr>
    <tr>
        <td>AREA AUDIT</td>
        <td colspan="5">{{$data->locations->title}}</td>
    </tr>
    <tr>
        <td>AUDITEE</td>
        <td colspan="5">{{$data->auditee->name}}</td>
    </tr>
    <tr>
        <td>TIPE AUDIT</td>
        <td colspan="5">{{$data->type_audit}}</td>
    </tr>
    <tr>
        <td>PERIODE AUDIT</td>
        <td colspan="3">{{$data->periode}}</td>
    </tr>
    <tr>
        <td>AUDITOR</td>
        <td colspan="5">KETUA : {{$auditor->auditor->name}}
                <p></p>ANGGOTA : {{$hodLPM->title}}
        </td>
    </tr>
    <tr>
        <td>NOMOR DOKUMEN</td>
    </tr>
    </table>
    <table class="audit-report">
    <tr>
        <th id="401587373C0" style="width:20px;" class="column-headers-background">CL</th>
        <th id="401587373C0" style="width:163px;" class="column-headers-background">DESKRIPSI HASIL AUDIT</th>
        <th id="401587373C0" style="width:293px;" class="column-headers-background">KATEGORI TEMUAN AUDIT</th>
        <th id="401587373C0" style="width:203px;" class="column-headers-background">FAKTOR PENDUKUNG KEBERHASILAN</th>
    </tr>
    <tr>
    @foreach ($obs_c as $no => $c)
        @if ($c->obs_checklist_option == "KS")
            <tr>
                <td class="center">{{ $loop->iteration }}.</td>
                <td><center>{{ $c->remark_description }}</center></td>
                <td><center>{!! $c->obs_checklist_option !!}</center></td>
                <td><center>{!! $c->remark_success_failed !!}</center></td>
            </tr>
        @endif
    @endforeach
</table>

<table class="audit-report">
    <tr>
        <th style="height: 35px" colspan="3">VALIDASI DAN CATATAN</th>
    </tr>
    <tr>
        <th>DISUSUN</th>
        <th>DIVALIDASI/DISETUJUI</th>
    </tr>
    <tr>
        <td>
            <table class="sub-table">
                <tr>
                    <td>Oleh:</td>
                    <td>{{ $auditor->auditor->name }}</td>
                </tr>
                <tr>
                    <td>Tanggal:</td>
                    <td>{{ Carbon::parse($data->date_start)->translatedFormat('l, d F Y') }}</td>
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
                    <td>{{ Carbon::parse($data->date_end)->translatedFormat('l, d F Y') }}</td>
                </tr>
                <tr>
                    <td>Paraf:</td>
                    <td class="paraf no-border">&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table class="audit-report">
    <tr>
        <td class="paraf no-border">CATATAN:
        @foreach ($observations as $o)
        {!! $o->remark_plan !!}
        </td>
        @endforeach
    </tr>
</table>
</body>
</html>
</div>

<div class="page-break">
<table class="audit-report">
    <tr>
        <td colspan="" rowspan="2" class="center">
            <img src="/assets/img/logo/logo_small.png" alt="Logo">
        </td>
        <td colspan="4" class="header">
            <br>
            UNIVERSITAS GLOBAL JAKARTA
            <br>
        </td>
    </tr>
    <tr>
        <td colspan="4"><center>HASIL AUDIT LAPANGAN KETIDAKSESUAIAN
            <br>(HAL-KTS)</center>
        </td>
    </tr>
    <tr>
        <td >STANDAR</td>
        <td colspan="5">
        @foreach ($standardCriterias as $criteria)
            {{ $criteria->title }}
        @endforeach
        </td>
    </tr>
    <tr>
        <td>AREA AUDIT</td>
        <td colspan="5">{{$data->locations->title}}</td>
    </tr>
    <tr>
        <td>AUDITEE</td>
        <td colspan="5">{{$data->auditee->name}}</td>
    </tr>
    <tr>
        <td>TIPE AUDIT</td>
        <td colspan="5">{{$data->type_audit}}</td>
    </tr>
    <tr>
        <td>PERIODE AUDIT</td>
        <td colspan="3">{{$data->periode}}</td>
    </tr>
    <tr>
        <td>AUDITOR</td>
        <td colspan="5">KETUA : {{$auditor->auditor->name}}
                <p></p>ANGGOTA : {{$hodLPM->title}}
        </td>
    </tr>
    <tr>
        <td>NOMOR DOKUMEN</td>
    </tr>
    </table>
    <table class="audit-report">
    <tr>
        <th id="401587373C0" style="width:20px;" class="column-headers-background">CL</th>
        <th id="401587373C0" style="width:163px;" class="column-headers-background">DESKRIPSI HASIL AUDIT</th>
        <th id="401587373C0" style="width:293px;" class="column-headers-background">KATEGORI TEMUAN AUDIT</th>
        <th id="401587373C0" style="width:203px;" class="column-headers-background">AKAR PENYEBAB/<br>FAKTOR PENGHAMBAT</th>
    </tr>
    <tr>
    @foreach ($obs_c as $no => $c)
        @if (in_array($c->obs_checklist_option, ['OBS', 'KTS MINOR', 'KTS MAYOR']))
            <tr>
                <td class="center">{{ $loop->iteration }}.</td>
                <td><center>{{ $c->remark_description }}</center></td>
                <td><center>{!! $c->obs_checklist_option !!}</center></td>
                <td><center>{!! $c->remark_success_failed !!}</center></td>
            </tr>
        @endif
    @endforeach
</table>

<table class="audit-report">
    <tr>
        <th style="height: 35px" colspan="3">VALIDASI DAN CATATAN</th>
    </tr>
    <tr>
        <th>DISUSUN</th>
        <th>DIVALIDASI/DISETUJUI</th>
    </tr>
    <tr>
        <td>
            <table class="sub-table">
                <tr>
                    <td>Oleh:</td>
                    <td>{{ $auditor->auditor->name }}</td>
                </tr>
                <tr>
                    <td>Tanggal:</td>
                    <td>{{ Carbon::parse($data->date_start)->translatedFormat('l, d F Y') }}</td>
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
                    <td>{{ Carbon::parse($data->date_end)->translatedFormat('l, d F Y') }}</td>
                </tr>
                <tr>
                    <td>Paraf:</td>
                    <td class="paraf no-border">&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table class="audit-report">
    <tr>
        <td class="paraf no-border">CATATAN:
        @foreach ($observations as $o)
        {!! $o->remark_plan !!}
        </td>
        @endforeach
        </td>
    </tr>
</table>
</body>
</html>
</div>

<div class="page-break">
<!DOCTYPE html>
<html lang="en">
<body>

<style type="text/css">
    .ritz .waffle a {
        color: inherit;
    }
    .ritz .waffle .s0 {
        border-left: 1px solid #000000;
        border-top: 1px solid #000000;
        border-bottom: 1px solid #000000;
        border-right: 1px solid #000000;
        background-color: #ffffff;
        text-align: left;
        color: #000000;
        font-family: Arial;
        font-size: 10pt;
        vertical-align: bottom;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px;
    }
    .checkbox-container {
    display: flex;
    align-items: center;
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        margin-right: 20px; /* Spasi antar checkbox, sesuaikan sesuai kebutuhan */
    }

    .checkbox-group input {
        margin-right: 8px; /* Spasi antara checkbox dan label */
    }

</style>
<table>
    <tr>
        <td colspan="1" rowspan="2" class="center">
            <img src="/assets/img/logo/logo_small.png" alt="Logo">
        </td>
        <td colspan="4" class="header">
            <br>
            UNIVERSITAS GLOBAL JAKARTA
            <br>
        </td>
    </tr>
    <tr>
        <td colspan="4"><center>PERMINTAAN TINDAKAN KOREKSI
            <br>(PTK)</center>
        </td>
    </tr>
    <tr>
        <td >STANDAR</td>
        <td colspan="5">
        @foreach ($standardCriterias as $criteria)
            {{ $criteria->title }}
        @endforeach
        </td>
    </tr>
    <tr>
        <td>AREA AUDIT</td>
        <td colspan="5">{{$data->locations->title}}</td>
    </tr>
    <tr>
        <td>AUDITEE</td>
        <td colspan="5">{{$data->auditee->name}}</td>
    </tr>
    <tr>
        <td>TIPE AUDIT</td>
        <td colspan="5">{{$data->type_audit}}</td>
    </tr>
    <tr>
        <td>PERIODE AUDIT</td>
        <td colspan="3">{{$data->periode}}</td>
    </tr>
    <tr>
        <td>AUDITOR</td>
        <td colspan="5">KETUA : {{$auditor->auditor->name}}
                <p></p>ANGGOTA : {{$hodLPM->title}}
        </td>
    </tr>
    <tr>
        <td colspan="3">KATEGORI TEMUAN AUDIT
            <td>
                <div class="form-group">
                    <div class="checkbox-container">
                        <div class="checkbox-group">
                            <input type="checkbox" id="observasi" value="OBSERVASI" disabled/>
                            <label for="observasi">Observasi</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" id="kts_minor" value="KTS MINOR" disabled/>
                            <label for="kts_minor">KTS Minor</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" id="kts_mayor" value="KTS MAYOR" disabled/>
                            <label for="kts_mayor">KTS Mayor</label>
                        </div>
                    </div>
                </div>
            </td>
        </td>
    </tr>
    <tr>
        <td>NOMOR DOKUMEN</td>
    </tr>
    </table>

    <table class="audit-report">
    <tr>
        <th id="401587373C0" style="width:20px;" class="column-headers-background">NO</th>
        <th id="401587373C0" style="width:163px;" class="column-headers-background">DESKRIPSI TEMUAN AUDIT</th>
        <th id="401587373C0" style="width:203px;" class="column-headers-background">AKAR PENYEBAB/FAKTOR PENGHAMBAT</th>
        <th id="401587373C0" style="width:293px;" class="column-headers-background">REKOMENDASI</th>
        <th id="401587373C0" style="width:163px;" class="column-headers-background">RENCANA PERBAIKAN</th>
        <th id="401587373C0" style="width:293px;" class="column-headers-background">JADWAL PENYELESAIAN</th>
        <th id="401587373C0" style="width:203px;" class="column-headers-background">PIHAK BERTANGGUNG JAWAB</th></tr>
    </tr>
    <tr>
    @foreach ($obs_c as $no => $c)
    @if (in_array($c->obs_checklist_option, ['OBS', 'KTS MINOR', 'KTS MAYOR']))
        <tr>
            <td class="center">{{ $loop->iteration }}.</td>
            <td><center>{{ $c->remark_description }}</center></td>
            <td><center>{!! $c->remark_success_failed !!}</center></td>
            <td><center>{!! $c->remark_recommend !!}</center></td>
            <td><center>{{ $c->remark_upgrade_repair }}</center></td>
    @foreach ($observations as $o)
    <td><center>{!! $o->plan_complated !!}</center></td>
        <td><center>{!! $o->person_in_charge !!}</center></td>
    </tr>
    @endforeach
    @endif
    @endforeach
    <tr style="height: 20px">
    </tr>
      </body>
      </thead>
  </table>
  <table class="audit-report">
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
                    <td>{{ $auditor->auditor->name }}</td>
                </tr>
                <tr>
                    <td>Tanggal:</td>
                    <td>{{ Carbon::parse($data->date_start)->translatedFormat('l, d F Y') }}</td>
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
                    <td>{{ $hodBPMI->title }}</td>
                </tr>
                <tr>
                    <td>Tanggal:</td>
                    <td>{{ Carbon::parse($data->date_end)->translatedFormat('l, d F Y') }}</td>
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
                    <td>{{ Carbon::parse($data->date_end)->translatedFormat('l, d F Y') }}</td>
                </tr>
                <tr>
                    <td>Paraf:</td>
                    <td class="paraf no-border">&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
  <table class="audit-report">
    <tr>
        <td class="paraf no-border">CATATAN:</td>
    </tr>
</table>
</body>
</html>
</div>

<div class="page-break">
<html lang="en">
<body>
<style type="text/css">
    .checkbox-container {
    display: flex;
    align-items: center;
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        margin-right: 20px; /* Spasi antar checkbox, sesuaikan sesuai kebutuhan */
    }

    .checkbox-group input {
        margin-right: 8px; /* Spasi antara checkbox dan label */
    }

</style>
<table>
    <tr>
        <td colspan="1" rowspan="2" class="center">
            <img src="/assets/img/logo/logo_small.png" alt="Logo">
        </td>
        <td colspan="4" class="header">
            <br>
            UNIVERSITAS GLOBAL JAKARTA
            <br>
        </td>
    </tr>
    <tr>
        <td colspan="4"><center>PERMINTAAN TINDAKAN PENINGKATAN
            <br>(PTP)</center>
        </td>
    </tr>
    <tr>
        <td >STANDAR</td>
        <td colspan="5">
        @foreach ($standardCriterias as $criteria)
            {{ $criteria->title }}
        @endforeach
        </td>
    </tr>
    <tr>
        <td>AREA AUDIT</td>
        <td colspan="5">{{$data->locations->title}}</td>
    </tr>
    <tr>
        <td>AUDITEE</td>
        <td colspan="5">{{$data->auditee->name}}</td>
    </tr>
    <tr>
        <td>TIPE AUDIT</td>
        <td colspan="5">{{$data->type_audit}}</td>
    </tr>
    <tr>
        <td>PERIODE AUDIT</td>
        <td colspan="3">{{$data->periode}}</td>
    </tr>
    <tr>
        <td>AUDITOR</td>
        <td colspan="5">KETUA : {{$auditor->auditor->name}}
                <p></p>ANGGOTA : {{$hodLPM->title}}
        </td>
    </tr>
    <tr>
        <td>NOMOR DOKUMEN</td>
    </tr>
    </table>

    <table class="audit-report">
    <tr>
        <th id="401587373C0" style="width:20px;" class="column-headers-background">NO</th>
        <th id="401587373C0" style="width:163px;" class="column-headers-background">DESKRIPSI TEMUAN AUDIT</th>
        <th id="401587373C0" style="width:203px;" class="column-headers-background">FAKTOR PENDUKUNG KEBERHASILAN</th>
        <th id="401587373C0" style="width:293px;" class="column-headers-background">REKOMENDASI</th>
        <th id="401587373C0" style="width:163px;" class="column-headers-background">RENCANA PENINGKATAN</th>
        <th id="401587373C0" style="width:293px;" class="column-headers-background">JADWAL PENYELESAIAN</th>
        <th id="401587373C0" style="width:203px;" class="column-headers-background">PIHAK BERTANGGUNG JAWAB</th></tr>
    </tr>
    <tr>
    @foreach ($obs_c as $no => $c)
    @if (in_array($c->obs_checklist_option, ['KS']))
        <tr>
            <td class="center">{{ $loop->iteration }}.</td>
            <td><center>{{ $c->remark_description }}</center></td>
            <td><center>{!! $c->remark_success_failed !!}</center></td>
            <td><center>{!! $c->remark_recommend !!}</center></td>
            <td><center>{{ $c->remark_upgrade_repair }}</center></td>
    @foreach ($observations as $o)
    <td><center>{!! $o->plan_complated !!}</center></td>
        <td><center>{!! $o->person_in_charge !!}</center></td>
    </tr>
    @endforeach
    @endif
    @endforeach
    <tr style="height: 20px">
    </tr>
      </body>
      </thead>
  </table>
  <table class="audit-report">
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
                    <td>{{ $auditor->auditor->name }}</td>
                </tr>
                <tr>
                    <td>Tanggal:</td>
                    <td>{{ Carbon::parse($data->date_start)->translatedFormat('l, d F Y') }}</td>
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
                    <td>{{ $hodBPMI->title }}</td>
                </tr>
                <tr>
                    <td>Tanggal:</td>
                    <td>{{ Carbon::parse($data->date_end)->translatedFormat('l, d F Y') }}</td>
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
                    <td>{{ Carbon::parse($data->date_end)->translatedFormat('l, d F Y') }}</td>
                </tr>
                <tr>
                    <td>Paraf:</td>
                    <td class="paraf no-border">&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
  <table class="audit-report">
    <tr>
        <td class="paraf no-border">CATATAN:</td>
    </tr>
</table>
</body>
</html>
</div> -->
