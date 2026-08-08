@extends('emails.layout')

@section('content')

@if($status == 2)

<h2 style="color:#198754;text-align:center;">
✅ Withdrawal Approved
</h2>

<p>
Dear <strong>{{ $client->name }}</strong>,
</p>

<p>
Your withdrawal request has been approved.
</p>

<table width="100%" cellpadding="8" cellspacing="0" style="border:1px solid #ddd;border-collapse:collapse;">

<tr>
    <td width="35%"><strong>Withdrawal ID</strong></td>
    <td>#{{ $withdraw->id }}</td>
</tr>

<tr>
    <td><strong>Amount</strong></td>
    <td>{{ number_format($withdraw->amount,2) }}</td>
</tr>

<tr>
    <td><strong>Transaction ID</strong></td>
    <td>{{ $withdraw->trxid }}</td>
</tr>

<tr>
    <td><strong>Status</strong></td>
    <td style="color:green;"><strong>Approved</strong></td>
</tr>

<tr>
    <td><strong>Date</strong></td>
    <td>{{ $withdraw->send_at?->format('d M Y h:i A') }}</td>
</tr>

</table>

<br>

Your withdrawal has been processed successfully.

@endif

@if($status == 3)

<h2 style="color:#dc3545;text-align:center;">
❌ Withdrawal Rejected
</h2>

<p>
Dear <strong>{{ $client->name }}</strong>,
</p>

<p>
Unfortunately your withdrawal request has been rejected.
</p>

<table width="100%" cellpadding="8" cellspacing="0" style="border:1px solid #ddd;border-collapse:collapse;">

<tr>
    <td width="35%"><strong>Withdrawal ID</strong></td>
    <td>#{{ $withdraw->id }}</td>
</tr>

<tr>
    <td><strong>Amount</strong></td>
    <td>{{ number_format($withdraw->amount,2) }}</td>
</tr>

<tr>
    <td><strong>Status</strong></td>
    <td style="color:red;"><strong>Rejected</strong></td>
</tr>

<tr>
    <td><strong>Date</strong></td>
    <td>{{ now()->format('d M Y h:i A') }}</td>
</tr>

</table>

<br>

The withdrawal amount has been returned to your income balance.

<br><br>

If you have any questions, please contact the administrator.

@endif

<br><br>

Regards,

<br>

<strong>Team Globexa Capital Ltd</strong>

@endsection