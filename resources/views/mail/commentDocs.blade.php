<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #333333;
        }
        .content {
            font-size: 16px;
            line-height: 1.6;
            color: #555555;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            font-size: 12px;
            color: #999999;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Comment Document</h1>
            <h1>Audit Review</h1>
            <h2>By Auditor</h2>
        </div>
        <div class="content">
            <p>Hello, {{$data['lecture_id']}}</p>
            <p>
                <strong>Lecture             : </strong>{{ $data['lecture_id'] }}<br>
                <strong>Date Start          : </strong> {{ $data['date_start'] }}<br>
                <strong>Date End            : </strong> {{ $data['date_end'] }}<br>
                <strong>Department          : </strong> {{ $data['department_id'] }}<br>
                <strong>Remark By Auditor   : </strong> {{ $data['remark_docs'] }}<br>
            </p>
            <p>Best regards,<br>Audit Mutu Internal</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Audit Company. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
