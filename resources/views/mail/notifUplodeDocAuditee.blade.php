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
    <p>You can now upload the documents required for auditing. Please log in to the system to view and upload the documents.</p>
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