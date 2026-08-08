<?php

namespace App\Mail;

use App\Models\Client;
use App\Models\Withdraw;
use App\Models\ClientAccount;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminWithdrawNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $withdraw;
    public $client;
    public $account;

    public function __construct(
        Withdraw $withdraw,
        Client $client,
        ClientAccount $account
    ) {
        $this->withdraw = $withdraw;
        $this->client = $client;
        $this->account = $account;
    }

    public function build()
    {
        return $this->subject('🔔 New Withdraw Request')
                    ->view('emails.admin-withdraw-notification');
    }
}