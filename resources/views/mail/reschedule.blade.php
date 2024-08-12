@extends('mail.template')
@section('title', $data['subject'])
@section('content')
<table align="left" border="0" cellpadding="0" cellspacing="0" style="text-align: left;" width="100%">
    <tbody>
        <tr>
            <td style="font-size: 10pt;">
                <p><i>Assalamu'alaikum Warahmatullaahi Wabarakaatuh.</i></p><br>
                <p>Dear Mr/Mrs, Your audit plan is rescheduled. Here are the details:</p><br>
                <p style="text-align: justify;"></p>
            </td>
        </tr>
    </tbody>
</table>
<tbody>
            <tr class="pad-left-right-space">
                <td ><p>Auditee <b><b>:</b> {{ $data['auditee_id'] }}</b></p></td>
            </tr>
            <tr class="pad-left-right-space">
                <td ><p>Auditor <b><b>:</b> {{ $data['auditor_id'] }}</b></p></td>
            </tr>
            <tr class="pad-left-right-space">
                <td ><p>Date Start <b><b>:</b> {{ $data['date_start'] }}</b></p></td>
            </tr>
            <tr class="pad-left-right-space">
                <td ><p>Date End  <b><b>:</b> {{ $data['date_end'] }}</b></p></td>
            </tr>
            <tr class="pad-left-right-space">
                <td ><p>Location <b><b>:</b> {{ $data['location_id'] }}</b></p></td>
                <td ></td>
            </tr>
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
                <p><i>Wassalamu'alaikum Warahmatullaahi Wabarakaatuh.</i></p>
                <br>
                <strong>Tim LPM</strong>
            </td>
        </tr>
    </tbody>
</table>

