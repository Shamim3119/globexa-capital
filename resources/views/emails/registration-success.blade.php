@extends('emails.layout')

@section('content')

<h2 style="color:#198754;text-align:center;">
🎉 অ্যাকাউন্ট সফলভাবে তৈরি হয়েছে
</h2>

<p>
প্রিয় <strong>{{ $client->name }}</strong>,
</p>

<p>
অভিনন্দন! <strong>Globexa Capital Ltd</strong>-এ আপনার অ্যাকাউন্ট সফলভাবে তৈরি হয়েছে।
</p>

<table width="100%" cellpadding="8" cellspacing="0" style="border:1px solid #ddd;">

<tr>
<td width="35%"><strong>ক্লায়েন্ট নাম</strong></td>
<td>{{ $client->name }}</td>
</tr>

<tr>
<td><strong>অ্যাকাউন্ট নম্বর</strong></td>
<td>{{ $client->id }}</td>
</tr>

<tr>
<td><strong>ইমেইল</strong></td>
<td>{{ $client->email }}</td>
</tr>

<tr>
<td><strong>রেজিস্ট্রেশনের তারিখ</strong></td>
<td>{{ $client->created_at->format('d M Y h:i A') }}</td>
</tr>

</table>

<br>

এখন আপনি আপনার অ্যাকাউন্টে লগইন করে আমাদের সেবাগুলো ব্যবহার করতে পারবেন।

<br><br>

ধন্যবাদ,

<br>

<strong>Team Globexa Capital Ltd</strong>

@endsection