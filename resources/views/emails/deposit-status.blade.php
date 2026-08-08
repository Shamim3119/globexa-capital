@extends('emails.layout')

@section('content')

@if($status == 2)

<h2 style="color:#198754;text-align:center;">
    ✅ Deposit Approved
</h2>

<p>
Dear <strong>{{ $client->name }}</strong>,
</p>

<p>
Your deposit request has been <strong style="color:green;">approved</strong>.
</p>

<table width="100%" cellpadding="8" cellspacing="0" style="border:1px solid #ddd;">

<tr>
    <td width="35%"><strong>Deposit ID</strong></td>
    <td>#{{ $deposit->id }}</td>
</tr>

<tr>
    <td><strong>Amount</strong></td>
    <td>{{ number_format($deposit->amount,2) }}</td>
</tr>

<tr>
    <td><strong>Deposit Date</strong></td>
    <td>{{ $deposit->created_at->format('d M Y h:i A') }}</td>
</tr>

<tr>
    <td><strong>Status</strong></td>
    <td style="color:green;"><strong>Approved</strong></td>
</tr>

</table>

<br>

The deposited amount has been added to your account balance.

<br><br>

Thank you for choosing <strong>Globexa Capital Ltd</strong>.

@else

<h2 style="color:#dc3545;text-align:center;">
    ❌ Deposit Rejected
</h2>

<p>
Dear <strong>{{ $client->name }}</strong>,
</p>

<p>
Unfortunately, your deposit request has been rejected.
</p>

<table width="100%" cellpadding="8" cellspacing="0" style="border:1px solid #ddd;">

<tr>
    <td width="35%"><strong>Deposit ID</strong></td>
    <td>#{{ $deposit->id }}</td>
</tr>

<tr>
    <td><strong>Amount</strong></td>
    <td>{{ number_format($deposit->amount,2) }}</td>
</tr>

<tr>
    <td><strong>Date</strong></td>
    <td>{{ $deposit->created_at->format('d M Y h:i A') }}</td>
</tr>

<tr>
    <td><strong>Status</strong></td>
    <td style="color:red;"><strong>Rejected</strong></td>
</tr>

</table>

<br>

Please contact the administrator for further information regarding your deposit request.

@endif

<br><br>

Regards,

<br>

<strong>Team Globexa Capital Ltd</strong>

@endsection