<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABSENSI KEGIATAN</title>
    <style>
      body {
        font-family: sans-serif;
        margin: 0;
        padding: 0;
        /* Landscape orientation */
        orientation: landscape;
        /* Adjust for A4 paper */
        width: 21.0cm;
        height: 29.7cm;
      }

      .container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
      }

      table {
        border-collapse: collapse;
        width: 100%;
        max-width: 1000px; /* Adjust as needed */
      }

      th, td {
        border: 1px solid black;
        padding: 10px;
        text-align: left;
      }

      th {
        background-color: #f0f0f0;
      }

      .logo-container {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
      }

      .logo {
        width: 150px;
      }

      .signature {
        text-align: center;
        margin-top: 20px;
      }

      .signature-title {
        margin-bottom: 5px;
      }

      .signature-line {
        width: 100px;
        height: 2px;
        background-color: black;
        display: inline-block;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <table>
        <thead>
          <tr>
            <th colspan="4">ABSENSI KEGIATAN</th>
          </tr>
          <tr>
            <th colspan="4">Standar Kompetensi Lulusan</th>
          </tr>
          <tr>
            <th colspan="2">Hari/Tgl.</th>
            <th colspan="2">Senin, 15 Agustus 2022</th>
          </tr>
          <tr>
            <th colspan="2">Tempat</th>
            <th colspan="2">Ruang Program Studi Manajemen</th>
          </tr>
          <tr>
            <th colspan="2">Pimpinan Rapat</th>
            <th colspan="2">Safira Faizah, S.TR.KOM, M.IT</th>
          </tr>
          <tr>
            <th colspan="2">Peserta Rapat</th>
            <th colspan="2">Anggota Auditor & Auditee</th>
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
            <td>Safira Faizah, S.TR.KOM, M.IT</td>
            <td>Ketua Auditor</td>
            <td>
              <div class="signature-line"></div>
              <div class="signature-title">Saial</div>
            </td>
          </tr>
          <tr>
            <td>2</td>
            <td>Ariep Jaenul, S.Pd., M.Sc. Eng</td>
            <td>Anggota</td>
            <td>
              <div class="signature-line"></div>
              <div class="signature-title">Ahel</div>
            </td>
          </tr>
          <tr>
            <td>3</td>
            <td>Dwi Rachmawati, S.S.T., M.Mgt</td>
            <td>Auditee</td>
            <td>
              <div class="signature-line"></div>
              <div class="signature-title">Dwi</div>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="logo-container">
        <img class="logo" src="logo.png" alt="JGU Logo">
      </div>
      <div class="signature">
        <div class="signature-title">Mengetahui,</div>
        <div class="signature-title">Kepala LPM</div>
        <div class="signature-line"></div>
        <div class="signature-title">Ariep Jaenul, S.Pd. M.Sc.Eng</div>
        <div class="signature-title">NIK. 5092019030004</div>
      </div>
      <div class="signature">
        <div class="signature-title">Depok, 15 Agustus 2022</div>
        <div class="signature-title">Ketua Auditor</div>
        <div class="signature-line"></div>
        <div class="signature-title">Safira Faizah, S.TR.KOM, M.IT</div>
        <div class="signature-title">NIK. 5092020080002</div>
      </div>
    </div>
  </body>
  </html>
