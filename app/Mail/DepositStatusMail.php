<?php

namespace App\Mail;

use App\Models\Client;
use App\Models\Deposit;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DepositStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $deposit;
    public $client;
    public $status;

    public function __construct(Deposit $deposit, Client $client, $status)
    {
        $this->deposit = $deposit;
        $this->client = $client;
        $this->status = $status;
    }

    public function build()
    {
        $subject = $this->status == 2
            ? '✅ Deposit Approved'
            : '❌ Deposit Rejected';

        return $this->subject($subject)
                    ->view('emails.deposit-status');
    }
}