<!DOCTYPE html>
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
</html>
