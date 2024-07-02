<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Email</title>
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
            <h1>Audit Plan Notification</h1>
        </div>
        <div class="content">
            <p>Hello,</p>
            <p>
                You have been assigned a new audit plan. Here are the details:
            </p>
            <p>
                <strong>Lecture:</strong> {{ $data['lecture_id'] }}<br>
                <strong>Date Start:</strong> {{ $data['date_start'] }}<br>
                <strong>Date End:</strong> {{ $data['date_end'] }}<br>
                <strong>Department:</strong> {{ $data['department_id'] }}<br>
                <strong>Location:</strong> {{ $data['location_id'] }}<br>
                <strong>Auditor:</strong> {{ $data['auditor_id'] }}<br>
                <strong>Standard Category:</strong> {{ $data['standard_categories_id'] }}<br>
                <strong>Standard Criteria:</strong> {{ $data['standard_criterias_id'] }}<br>
                <strong>Link:</strong> <a href="{{ $data['link'] }}">{{ $data['link'] }}</a><br>
            </p>
            <p>
                Please review the details and contact us if you have any questions.
            </p>
            <p>Best regards,<br>Audit Mutu Internal</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Audit Company. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
