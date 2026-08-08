@extends('emails.layout')

@section('content')

<h2 style="color:#dc3545;text-align:center;">
🔔 New Withdrawal Request
</h2>

<p>
Hello Admin,
</p>

<p>
A new withdrawal request has been submitted.
</p>

<table width="100%" cellpadding="8" cellspacing="0" style="border:1px solid #ddd;border-collapse:collapse;">

<tr>
<td width="35%"><strong>Request ID</strong></td>
<td>#{{ $withdraw->id }}</td>
</tr>

<tr>
<td><strong>Client ID</strong></td>
<td>{{ $client->id }}</td>
</tr>

<tr>
<td><strong>Name</strong></td>
<td>{{ $client->name }}</td>
</tr>

<tr>
<td><strong>Email</strong></td>
<td>{{ $client->email }}</td>
</tr>

<tr>
<td><strong>Phone</strong></td>
<td>{{ $client->phone }}</td>
</tr>

<tr>
<td><strong>Amount</strong></td>
<td>{{ number_format($withdraw->amount,2) }}</td>
</tr>

<tr>
<td><strong>Rate</strong></td>
<td>{{ $withdraw->rate }}</td>
</tr>

<tr>
<td><strong>Send Amount</strong></td>
<td>{{ number_format($withdraw->send_amount,2) }}</td>
</tr>

<tr>
<td><strong>Operator</strong></td>
<td>{{ $account->operator->name ?? '' }}</td>
</tr>

<tr>
<td><strong>Account Name</strong></td>
<td>{{ $account->account_name }}</td>
</tr>

<tr>
<td><strong>Account Number</strong></td>
<td>{{ $account->account_no }}</td>
</tr>

<tr>
<td><strong>Status</strong></td>
<td>Pending</td>
</tr>

<tr>
<td><strong>Date</strong></td>
<td>{{ $withdraw->created_at->format('d M Y h:i A') }}</td>
</tr>

</table>

<br>

Please review this withdrawal request from the admin panel.

<br><br>

<strong>Team Globexa Capital Ltd</strong>

@endsection