<?php

namespace App\Mail;

use App\Models\Client;
use App\Models\Withdraw;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WithdrawStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $withdraw;
    public $client;
    public $status;

    public function __construct(Withdraw $withdraw, Client $client, $status)
    {
        $this->withdraw = $withdraw;
        $this->client = $client;
        $this->status = $status;
    }

    public function build()
    {
        $subject = $this->status == 2
            ? '✅ Withdrawal Approved'
            : '❌ Withdrawal Rejected';

        return $this->subject($subject)
                    ->view('emails.withdraw-status');
    }
}