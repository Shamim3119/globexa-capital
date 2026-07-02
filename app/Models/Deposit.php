<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $fillable = [
        'deposit_by',
        'account_id',
        'amount',
        'status_id',
        'deposit_doc',
        'trxid',
        'exchange_amount',
    ];

    protected $casts = [
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
    'accept_at' => 'datetime',
];

    public function depositer()
    {
        return $this->belongsTo(Client::class, 'deposit_by');
    }

    public function account()
    {
        return $this->belongsTo(BussinessAccount::class, 'account_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
