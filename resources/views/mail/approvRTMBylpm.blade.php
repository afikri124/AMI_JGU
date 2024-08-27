<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link rel="icon" href="{{asset('assets/img/favicon.png')}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{asset('assets/img/favicon.png')}}" type="image/x-icon">
    <title>AMI JGU - Email Notification</title>
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
<style type="text/css">
body {
    text-align: center;
    margin: 0 auto;
    width: 100%;
    max-width: 650px;
    font-family: work-Sans, sans-serif;
    background-color: #f6f7fb;
    display: block;
}
ul {
    margin: 0;
    padding: 0;
}
li {
    display: inline-block;
    text-decoration: unset;
}
a {
    text-decoration: none;
}
p {
    margin: 5px 0;
}
h5 {
    color: #444;
    text-align: left;
    font-weight: 400;
}
.text-center {
    text-align: center
}
.main-bg-light {
    background-color: #fafafa;
    box-shadow: 0px 0px 14px -4px rgba(0, 0, 0, 0.2705882353);
}
.title {
    color: #444444;
    font-size: 22px;
    font-weight: bold;
    margin-top: 10px;
    margin-bottom: 10px;
    padding-bottom: 0;
    text-transform: uppercase;
    display: inline-block;
    line-height: 1;
}
table {
    margin-top: 5px
}
table.top-0 {
    margin-top: 0;
}
table.order-detail {
    border: 1px solid #ddd;
    border-collapse: collapse;
}
table.order-detail tr:nth-child(even) {
    border-top: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
}
table.order-detail tr:nth-child(odd) {
    border-bottom: 1px solid #ddd;
}
.pad-left-right-space {
    border: unset !important;
}
.pad-left-right-space td {
    padding: 5px 15px;
    padding-left: 5px;  /* Sesuaikan nilai ini sesuai kebutuhan */
    padding-right: 5px; /* Sesuaikan nilai ini sesuai kebutuhan */
}
.pad-left-right-space td p {
    margin: 0;
}
.pad-left-right-space td b {
    font-size: 10pt;
    font-family: 'Roboto', sans-serif;
}
.order-detail th {
    font-size: 10pt;
    padding: 15px;
    text-align: center;
    background: #fafafa;
}
.footer-social-icon tr td img {
    margin-left: 5px;
    margin-right: 5px;
}
</style>
</head>
<body style="margin: 20px auto;">
    <table align="center" border="0" cellpadding="0" cellspacing="0"
        style="padding: 0 30px;background-color: #fff; -webkit-box-shadow: 0px 0px 14px -4px rgba(0, 0, 0, 0.2705882353);box-shadow: 0px 0px 14px -4px rgba(0, 0, 0, 0.2705882353);width: 100%;">
        <tbody>
                <tr>
                <td>
                    <table align="left" border="0" cellpadding="0" cellspacing="0" style="text-align: left;"
                            width="100%">
            <tbody>
                <tr>
                    <td style="text-align: center;">
                        <a target="_blank" href="{{ url('/dashboard') }}">
                        <img src="{{asset('assets-landing/img/jgu.png')}}" alt="AMI JGU"
                                style="margin: 20px 0; width:150px;">
                        </a>
                    </td>
                </tr>
                <tr>
            </tbody>
                    </table>
                </td>
                </tr>
        </tbody>
    </table>
    <table class="main-bg-light text-center top-0" align="center" border="0" cellpadding="0" cellspacing="0"
        width="100%">
        <tbody>
                <tr>
                <td style="padding: 30px;">
                <tr>
                <td style="font-size: 10pt;">
                    <p style="text-align: justify;">Dear Mr/Mrs,</p><br>
                </td>
            
                <tr class="pad-left-right-space">
                    <td ><p style="text-align: justify;">RTM has been <b>Approved by LPM</b>, to see the results of the audit please login to the<a href="{{ url('/audit_plan') }}">sistem.</p></td>
                </tr>
                <br>
            <tr>
                <td style="font-size: 10pt;">
                    <p style="text-align: justify;">For more information, please log in to <a
                            href="{{ url('/dashboard') }}">sistem.</a>
                        <br>If there are problems or want to make changes to the schedule, please contact the LPM JGU Team.</p>
                    <br>
                    <p style="text-align: justify;">Thank you,</p>
                    <br>
                </td>
            </tr>
                    <div style="border-top: 1px solid #ddd; margin: 20px auto 0;"></div>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 20px auto 0;">
                            <tbody>
                            <tr>
                                <td>
                                        <b style="font-size:8pt; margin:0; color:#444">Copyright by <a
                                            href="https://itic.jgu.ac.id" style="color:#444">ITIC JGU</a></b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <a href="https://jgu.ac.id" style="font-size:10pt; color:red">
                                        <b>Jakarta Global University</b>
                                        </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <p style="font-size:8pt; margin:0; color:#949494">
                                        Grand Depok City, Jl. Boulevard Raya No.2<br>Kota Depok 16412, Jawa Barat,
                                        Indonesia
                                        </p>
                                </td>
                            </tr>
                            </tbody>
                    </table>
                </td>
                </tr>
        </tbody>
    </table>
</body>
</html>








