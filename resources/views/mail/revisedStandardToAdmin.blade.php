@extends('mail.template')
@section('title', $data['subject'])
@section('content')
<table align="left" border="0" cellpadding="0" cellspacing="0" style="text-align: left;" width="100%">
    <tbody>
        <tr>
            <td style="font-size: 10pt;">
                <p>Dear Mr/Mrs, The Standards You Create Get Revised</p><br>
            </td>
        </tr>
    </tbody>
</table>
<tbody>
    <!-- <h3>The Standards You Create Get Revised</h3> -->
    <p>The following is a comment from LPM:</p>
    <p></b><b> {{ $data['remark_standard_lpm'] }}</b></p>      
</tbody>
<table align="left" border="0" cellpadding="0" cellspacing="0" style="text-align: left; margin-bottom:50px;"
    width="100%">
    <tbody>
        <tr>
            <td style="font-size: 10pt;">
                <p style="text-align: justify;">For more information, please log in to <a
                        href="{{ url('/dashboard') }}">sistem.</a><br>
                    <br>If there are problems or want to make changes to the schedule, please contact the LPM JGU Team.</p>
                <br>
                <p>Thank you,</p>
                <br>
                <strong>Tim LPM</strong>
            </td>
        </tr>
    </tbody>
</table>

