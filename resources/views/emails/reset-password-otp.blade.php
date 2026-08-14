@extends('emails.layout')

@section('content')

<h2 style="color:#003366;text-align:center;">
    🔐 Password Reset Verification
</h2>

<p>
    Dear Customer,
</p>

<p>
    We received a request to reset the password for your
    <strong>Globexa Capital Ltd</strong> account.
</p>

<p>
    Please use the following One-Time Password (OTP) to verify your password reset request.
</p>

<div style="
text-align:center;
margin:35px 0;
padding:18px;
background:#eef5ff;
border:2px dashed #003366;
border-radius:8px;
font-size:36px;
font-weight:bold;
letter-spacing:8px;
color:#0B5ED7;
">

    {{ $otp }}

</div>

<p>
    This OTP will expire in <strong>10 minutes</strong>.
</p>

<div style="
background:#fff8e6;
border-left:5px solid #ff9800;
padding:15px;
margin-top:20px;
">

    <strong>Security Notice</strong>

    <br><br>

    Never share this OTP with anyone.

    <br><br>

    Globexa Capital Ltd will never ask for your OTP via phone, email or SMS.

</div>

<br>

Regards,

<br>

<strong>Team Globexa Capital Ltd</strong>

@endsection

