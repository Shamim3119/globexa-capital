@extends('emails.layout')

@section('content')

<p>প্রিয় গ্রাহক,</p>

<p>
<strong>Globexa Capital Ltd</strong>-এ আপনার অ্যাকাউন্ট নিবন্ধনের জন্য ধন্যবাদ।
</p>

<p>
আপনার ইমেইল যাচাই করার জন্য নিচের OTP ব্যবহার করুন।
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
এই OTP <strong>১০ মিনিট</strong> পর্যন্ত কার্যকর থাকবে এবং এটি শুধুমাত্র একবার ব্যবহার করা যাবে।
</p>

<div style="
background:#fff8e6;
border-left:5px solid #ff9800;
padding:15px;
margin-top:25px;
">

<strong>নিরাপত্তা সতর্কতা</strong>

<br><br>

আপনার OTP কারও সাথে শেয়ার করবেন না।

<strong>Globexa Capital Ltd</strong> কখনোই
ফোন, ইমেইল বা SMS-এর মাধ্যমে আপনার OTP বা Password চাইবে না.

</div>

<br>

<p>
ধন্যবাদ,<br>
<strong>Team Globexa Capital Ltd</strong>
</p>

@endsection