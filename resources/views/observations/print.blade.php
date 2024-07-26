<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABSENSI KEGIATAN</title>
    <style>
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

      table {
        border-collapse:collapse;
        width: 180%;
        max-width: 1500px; /* Adjust as needed */
      }

      th, td {
        border: 2px solid black;
        padding: 4px;
        text-align: left;
      }

      th {
        background-color:white;
      }

      .logo-container {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
      }

      .logo {
        width: 150px;
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

      .audit-report {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .audit-report, .audit-report th, .audit-report td {
            border: 1px solid black;
        }
        .audit-report th, .audit-report td {
            padding: 8px;
            text-align: left;
        }
        .audit-report th {
            background-color: #f2f2f2;
            text-align: center;
        }
        .audit-report .header {
            text-align: center;
            font-weight: bold;
        }
        .audit-report .center {
            text-align: center;
        }
        .audit-report .no-border {
            border: none;
        }
        .audit-report .signature {
            height: 60px;
        }
    </style>
  </head>
  <body>
  <div class="container-fluid flex-grow-1 container-p-y">
      <table>
        <thead>
        @php
            use Carbon\Carbon;
            Carbon::setLocale('id');
        @endphp
        <tr>
            <td colspan="1"></td>
            <th colspan="4" style="text-align: center;">ABSENSI KEGIATAN</th>
        </tr>
        @foreach ($standardCriterias as $criteria)
            <tr>
                <td colspan="1"></td>
                <th colspan="4" style="text-align: center;">{{ $criteria->title }}</th>
            </tr>
        @endforeach
          <tr>
          <td colspan="1"></td>
            <td colspan="1">Hari/Tgl.</td>
            <td colspan="3">{{ Carbon::parse($data->date_start)->translatedFormat('l, d F Y') }}</td>
          </tr>
          <tr>
          <td colspan="1"></td>
            <td colspan="1">Tempat</td>
            <td colspan="3">{{$data->locations->title}}</td>
          </tr>
          <tr>
          <td colspan="1"></td>
            <td colspan="1">Pimpinan Rapat</td>
            <td colspan="3">{{$auditor->auditor->name}}</td>
          </tr>
          <tr>
          <td colspan="1"></td>
            <td colspan="1">Peserta Rapat</td>
            <td colspan="3">Anggota Auditor & {{$data->auditee->name}}</td>
          </tr>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Paraf</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>{{$auditor->auditor->name}}</td>
            <td>Ketua Auditor</td>
            <td>
              <div class="signature-line"></div>
              <div class="signature-title"></div>
            </td>
          </tr>
          <tr>
            <td>2</td>
            <td>Ariep Jaenul, S.Pd., M.Sc. Eng</td>
            <td>Anggota</td>
            <td>
              <div class="signature-line"></div>
              <div class="signature-title"></div>
            </td>
          </tr>
          <tr>
            <td>3</td>
            <td>{{$data->auditee->name}}</td>
            <td>Auditee</td>
            <td>
              <div class="signature-line"></div>
              <div class="signature-title"></div>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="logo-container">
        <img src="assets/img/jgu.png" alt="">
      </div>
      <div class="signature-1">
        <div class="signature-title">Mengetahui,</div>
        <div class="signature-title">Kepala LPM</div>
        <div class="signature-line"></div>
        <div class="signature-title">Ariep Jaenul, S.Pd. M.Sc.Eng</div>
        <div class="signature-title">NIK. 5092019030004</div>
      </div>
      <div class="signature-2">
        <div class="signature-title">Depok, {{ Carbon::parse($data->date_start)->translatedFormat('l, d F Y') }}</div>
        <div class="signature-title">Ketua Auditor</div>
        <div class="signature-line"></div>
        <div class="signature-title">{{$auditor->auditor->name}}</div>
        <div class="signature-title">NIK. 5092020080002</div>
      </div>
    </div>
  </body>
  </html>

<br>
<br>
<br>
<br>

  <center>
        <h5><u>BERITA ACARA <i>AUDIT MUTU INTERNAL</i></u></h5>
    </center>
        <tr>
            <td colspan="2">
                <p style="text-align: justify; margin-top:20px">Dalam rangka Pelaksanaan Penjaminan Mutu di lingkungan
                    Universitas
                    Global Jakarta, maka pada hari ini:</p>
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
            <td width="70%" valign="top">:{{$data->locations->title}}</td>
        </tr>
        <tr>
            <td colspan="2">
                <p style="text-align: justify;padding-top:15px">Telah diselenggarakan kegiatan <i>Peer Observation</i>
                    di lingkungan Program Studi
                    sebagaimana
                    tercantum dalam daftar hadir terlampir. Unsur kegiatan pada hari ini antara lain:</p>
            </td>
        </tr>
        <tr>
            <td width="30%" valign="top">Auditor </td>
            <td width="70%" valign="top">:{{$auditor->auditor->name}}</td>
        </tr>
        <br>
        <tr>
            <td width="30%" valign="top">Auditee</td>
            <td width="70%" valign="top">:{{$data->auditee->name}}</td>
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
        <tr>
            <td width="50%" style="text-align: center;">
                Auditor <p></p>{{$auditor->auditor->name}}<br>
                <small>NIK.</small>
            </td>
            <td width="50%" style="text-align: center;">
                <br>Auditee<br><br><br><br>{{$data->auditee->name}}
                <br><small>NIK.</small>
            </td>
        </tr>
        <tr>
            <td colspan="2"><br></td>
        </tr>
        <tr>
            <td width="50%" style="text-align: center;">
                Mengetahui,<br>Kepala LPM<br><br><br><br>
                <small>NIK.</small>
            </td>
            <br>
            <td width="50%" style="text-align: center;">
                Kepala BPMI<br><br><br><br>
                <small>NIK.</small>
            </td>
        </tr>

    <div class="page-break"></div>

        <tr>
            <td width="50%" valign="top">
                <code style="color: black;font-size:9pt">FM/JGU/L.079</code><br>
            </td>
            <td width="50%" style="text-align: right;">
            </td>
        </tr>
        <p></p>
        <table class="audit-report">
    <tr>
        <td colspan="2" rowspan="2" class="center">
            <img src="https://via.placeholder.com/100" alt="Logo">
        </td>
        <td colspan="4" class="header">UNIVERSITAS GLOBAL JAKARTA</td>
    </tr>
    <tr>
        <td colspan="4" class="header">DAFTAR PENGECEKAN / CHECK LIST</td>
    </tr>
    <tr>
        <td>STANDAR</td>
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
                <p></p>ANGGOTA : Ariep Jaenul, S.Pd., M.Sc.Eng
        </td>
    </tr>
    <tr>
        <th colspan="6">NOMOR DOKUMEN</th>
    </tr>
    @foreach ($criteria->statements as $no => $statement)
    @foreach ($statement->indicators as $indicator)
    <tr>
        <th>NO</th>
        <th>INDIKATOR CAPAIAN STANDAR</th>
        <th>PERTANYAAN</th>
        <th colspan="3">DOKUMEN YANG AKAN DICHECK</th>
    </tr>
    <tr>
        <td class="center">{{ $loop->parent->iteration }}</td>
        <td>{{ $statement->name }}</td>
        <td>{!! $indicator->name !!}</td>
        <td colspan="3">
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
        <th colspan="3">VALIDASI DAN CATATAN</th>
    </tr>
    <tr>
        <th>DISUSUN</th>
        <th>DIPERIKSA</th>
        <th>DIVALIDASI/DISETUJUI</th>
    </tr>
    <tr>
        <td>
            <p>Oleh</p>
            <p>Safira Faizah, S.Tr.Kom., M.IT</p>
            <p>Tanggal: 9 Agustus 2022</p>
            <p>Paraf:</p>
            <div class="signature"></div>
        </td>
        <td>
            <p>Oleh</p>
            <p>Arisa Olivia, S.S.T., MIT</p>
            <p>Tanggal: 10 Agustus 2022</p>
            <p>Paraf:</p>
            <div class="signature"></div>
        </td>
        <td>
            <p>Oleh</p>
            <p>Ariep Jaenul, S.Pd., M.Sc.Eng</p>
            <p>Tanggal: 10 Agustus 2022</p>
            <p>Paraf:</p>
            <div class="signature"></div>
        </td>
    </tr>
    <tr>
        <td colspan="3">
        @foreach($observations as $obs)
            <p>CATATAN: {{ $obs->remark_plan }}</p>
        @endforeach
        </td>
    </tr>
</table>


        <p></p>
        <table class="audit-report">
    <tr>
        <td colspan="6" class="header">
            <img src="https://via.placeholder.com/150" alt="Logo" style="float:left;">
            <p>UNIVERSITAS GLOBAL JAKARTA</p>
            <p>HASIL AUDIT LAPANGAN KESESUAIAN (HAL-KS)</p>
        </td>
    </tr>
    <tr>
        <td>STANDAR PENDIDIKAN TINGGI</td>
        <td colspan="5">Standar Kompetensi Lulusan</td>
    </tr>
    <tr>
        <td>AREA AUDIT</td>
        <td colspan="5">Program Studi S1 Manajemen</td>
    </tr>
    <tr>
        <td>PELAKSANA STANDAR</td>
        <td colspan="5">Dwi Rachmawati, S.S.T., M.M</td>
    </tr>
    <tr>
        <td>TIPE AUDIT</td>
        <td>AMI</td>
        <td>PERIODE AUDIT</td>
        <td colspan="3">TA 2021/2022</td>
    </tr>
    <tr>
        <td>KETUA</td>
        <td>Safira Faizah, S.Tr.Kom., M.IT</td>
        <td>ANGGOTA</td>
        <td colspan="3">Ariep Jenuel, S.Pd., M.Sc.Eng</td>
    </tr>
    <tr>
        <th>NO/MR DOKUMEN</th>
        <th colspan="5">DESKRIPSI HASIL AUDIT</th>
    </tr>
    <tr>
        <td class="center">1.1</td>
        <td>Pada saat pembuatan pedoman penyusunan capaian pembelajaran tidak dilampirkan daftar arsip dokumen, serta tidak dilampirkan daftar adanya dokumentasi riset.</td>
        <td>OBS</td>
        <td>Pada saat pembuatan pedoman penyusunan capaian pembelajaran tidak dilampirkan daftar arsip dokumen, serta tidak dilampirkan daftar adanya dokumentasi riset.</td>
        <td>Kurang lengkapnya dokumen pendukung dan checklist evaluasi yang disertakan.</td>
    </tr>
    <tr>
        <th class="center">VALIDASI DAN CATATAN</th>
        <th colspan="5"></th>
    </tr>
    <tr>
        <td colspan="2" class="center">
            <p>DISUSUN</p>
            <p><small>OLEH</small></p>
            <p>Safira Faizah, S.Tr.Kom., M.IT</p>
            <p><small>TANGGAL</small></p>
            <p>15 Agustus 2022</p>
            <p><small>PARAF</small></p>
            <p>___________</p>
        </td>
        <td colspan="2" class="center">
            <p>DISETUJUI</p>
            <p><small>OLEH</small></p>
            <p>Dwi Rachmawati, S.S.T., M.M</p>
            <p><small>TANGGAL</small></p>
            <p>15 Agustus 2022</p>
            <p><small>PARAF</small></p>
            <p>___________</p>
        </td>
    </tr>
    <tr>
        <td colspan="6">
            <p>CATATAN: Harap dilakukan perbaikan sesuai dengan catatan hasil AMI</p>
        </td>
    </tr>
</table>
        <p></p>
<table class="audit-report">
    <tr>
        <td colspan="6" class="header">
            <img src="https://via.placeholder.com/150" alt="Logo" style="float:left;">
            <p>UNIVERSITAS GLOBAL JAKARTA</p>
            <p>HASIL AUDIT LAPANGAN KETIDAKSESUAIAN (HAL-KTS)</p>
        </td>
    </tr>
    <tr>
        <td>STANDAR PENDIDIKAN TINGGI</td>
        <td colspan="5">Standar Kompetensi Lulusan</td>
    </tr>
    <tr>
        <td>AREA AUDIT</td>
        <td colspan="5">Program Studi S1 Manajemen</td>
    </tr>
    <tr>
        <td>PELAKSANA STANDAR</td>
        <td colspan="5">Dwi Rachmawati, S.S.T., M.M</td>
    </tr>
    <tr>
        <td>TIPE AUDIT</td>
        <td>AMI</td>
        <td>PERIODE AUDIT</td>
        <td colspan="3">TA 2021/2022</td>
    </tr>
    <tr>
        <td>KETUA</td>
        <td>Safira Faizah, S.Tr.Kom., M.IT</td>
        <td>ANGGOTA</td>
        <td colspan="3">Ariep Jenuel, S.Pd., M.Sc.Eng</td>
    </tr>
    <tr>
        <th>NO/MR DOKUMEN</th>
        <th colspan="5">DESKRIPSI HASIL AUDIT</th>
    </tr>
    <tr>
        <td class="center">1.1</td>
        <td>Pada saat pembuatan pedoman penyusunan capaian pembelajaran tidak dilampirkan daftar arsip dokumen, serta tidak dilampirkan daftar adanya dokumentasi riset.</td>
        <td>OBS</td>
        <td>Pada saat pembuatan pedoman penyusunan capaian pembelajaran tidak dilampirkan daftar arsip dokumen, serta tidak dilampirkan daftar adanya dokumentasi riset.</td>
        <td>Kurang lengkapnya dokumen pendukung dan checklist evaluasi yang disertakan.</td>
    </tr>
    <tr>
        <th class="center">VALIDASI DAN CATATAN</th>
        <th colspan="5"></th>
    </tr>
    <tr>
        <td colspan="2" class="center">
            <p>DISUSUN</p>
            <p><small>OLEH</small></p>
            <p>Safira Faizah, S.Tr.Kom., M.IT</p>
            <p><small>TANGGAL</small></p>
            <p>15 Agustus 2022</p>
            <p><small>PARAF</small></p>
            <p>___________</p>
        </td>
        <td colspan="2" class="center">
            <p>DISETUJUI</p>
            <p><small>OLEH</small></p>
            <p>Dwi Rachmawati, S.S.T., M.M</p>
            <p><small>TANGGAL</small></p>
            <p>15 Agustus 2022</p>
            <p><small>PARAF</small></p>
            <p>___________</p>
        </td>
    </tr>
    <tr>
        <td colspan="6">
            <p>CATATAN: Harap dilakukan perbaikan sesuai dengan catatan hasil AMI</p>
        </td>
    </tr>
</table>
