<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet">
<title>Make Report</title>
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
      .page-break{
        page-break-before: always;
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
        <td class="s0" rowspan="2"><center>1</center></td>
        <td class="s0" colspan="2" rowspan="2"><center>{{ $auditor->auditor->name }}</center></td>
        <td class="s0" rowspan="2"><center>Ketua Auditor</center></td>
        <td class="s0" rowspan="2">1.</td>
        <td class="s0" rowspan="2"></td>
      </tr>
      <tr style="height: 35px">
      </tr>
      <tr style="height: 35px">
        <td class="s0" rowspan="2"><center>2</center></td>
        <td class="s0" colspan="2" rowspan="2"><center>Auditor 2</center></td>
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

    
<div class="page-break">
    <!DOCTYPE html>
    <html lang="en">
    <body>
    <center>
            <h5><u>BERITA ACARA <i>AUDIT MUTU INTERNAL</i></u></h5>
        </center>
            <tr>
                <td colspan="3">
                    <br style="text-align: justify; margin-top:20px">Dalam rangka Pelaksanaan Penjaminan Mutu di lingkungan
                        Universitas
                        Global Jakarta, maka pada hari ini:</br>
                </td>
            </tr>
            <tr>
                <td width="30%" valign="top">Hari/Tanggal</td>
                <td width="70%" valign="top">: {{ Carbon::parse($data->date_start)->translatedFormat('l, d F Y') }}</td>
            </tr>
            <br>
            <tr>
                <td width="30%" valign="top">Jam</td>
                <td width="70%" valign="top">: {{ Carbon::parse($data->date_start)->format('H:i') }} WIB</td>
            </tr>
            <br>
            <tr>
                <td width="30%" valign="top">Tempat</td>
                <td width="70%" valign="top">: {{$data->locations->title}}</td>
            </tr>
            <br>
            <tr>
                <td colspan="2">
                    <br style="text-align: justify;padding-top:5px">Telah diselenggarakan kegiatan <i>Audit Mutu Internal</i>
                        di lingkungan Program Studi
                        sebagaimana
                        tercantum dalam daftar hadir terlampir. Unsur kegiatan pada hari ini antara lain:</br>
                <td width="30%" valign="top">Ketua Audit</td>
                <td width="70%" valign="top">: {{ $auditor->auditor->name }}</td>
            </tr>
            <br>
            <tr>
                <td width="30%" valign="top">Anggota Audit</td>
                <td width="70%" valign="top">: Auditor 2</td>
            </tr>
            <br>
            <tr>
                <td width="30%" valign="top">Auditee</td>
                <td width="70%" valign="top">: {{$data->auditee->name}}</td>
            </tr>
            <tr>
                <td colspan="2">
                    <p style="text-align: justify;padding-top:15px">Setelah dilakukan Audit Dokumen dan Audit Lapangan, selanjutnya
                        semua unsur terlibat dalam kegiatan tersebut menyimpulkan beberapa hal antara lain:
                    </p>
                </td>
                @foreach($obs_c as $c)
                    @if(in_array($c->obs_checklist_option, ['OBS', 'KTS MINOR', 'KTS MAYOR']))
                        <ul>{{ $loop->iteration }}. {{ $c->remark_description }}</ul>
                    @endif
                @endforeach
            </tr>
            <tr>
                <td colspan="2">
                    <p style="text-align: justify;padding-top:15px">Demikian berita acara ini dibuat dan disahkan dengan
                        sebenar-benarnya dan tanggung jawab agar dapat dipergunakan sebagaimana mestinya.</p>
                </td>
            </tr>
        </table>
            <tr>
                <td width="50%"></td>
                <td width="50%" style="text-align: center;">Depok, {{ Carbon::parse($data->date_start)->translatedFormat('l, d F Y') }}</td>
            </tr>
            <br>
        <div class="signature-container">
            <div class="signature">
                <p>Auditor</p>
                <br>
                <p>{{ $auditor->auditor->name }}
                <br>NIK.
            </div>
            <div class="signature">
                <p>Auditee</p>
                <br>
                <p>{{ $data->auditee->name }}
                <br>NIK.
            </div>
        </div>

        <div class="signature-container">
            <div class="signature-1">
                <p>Mengetahui,</p>
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
            </div>
        </div>
    </body>
    </html>
</div>

<p></p>
<br>
<div class="page-break">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
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

    table {
        width: 150%;
        border-collapse: collapse;
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

<p></p>
<br>
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

<p></p>
<br>
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

<p></p>
<br>
<div class="page-break">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
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

<div class="container-fluid" dir="ltr">
<table class="audit-report">
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

<p></p>
<br>
<div class="page-break">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
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
<div class="container-fluid" dir="ltr">
<table class="audit-report">
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
</div>
