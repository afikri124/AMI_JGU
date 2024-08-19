@extends('mail.template')
@section('content')
<table align="left" border="0" cellpadding="0" cellspacing="0" style="text-align: left;" width="100%">
    <tbody>
        <tr>
            <td style="font-size: 10pt;">
                <p>Dear Mr/Mrs</p><br>
                <p style="text-align: justify;"></p>
            </td>
        </tr>
        
    </tbody>    
</table>
<tbody>
    <p>The Auditor Has Reviewed the Documents You Uploaded, Please Check Whether the Documents You Uploaded Need to be Corrected or Not.
        To check it, please login to the system.<a href="{{ url('/audit_plan') }}">sistem.</a></p>
    <tr>
        <td style="font-size: 10pt;">
            <p style="text-align: justify;">For more information, please log in to <a href="{{ url('/dashboard') }}">sistem.</a>
                    <br>
                <br>If there are problems or want to make changes to the schedule, please contact the LPM JGU Team.</p>
            <br>
            <p>Thank you,</p>
            <br>
            <strong>Tim LPM</strong>
        </td>
    </tr>
</tbody>
@endsection



