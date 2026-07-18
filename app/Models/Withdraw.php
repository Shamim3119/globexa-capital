<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    protected $fillable = [
        'withdraw_by',
        'account_id',
        'amount',
        'status_id',
        'withdraw_doc', 
        'trxid', 
        'send_at',
    ];


    protected $casts = [
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
    'send_at' => 'datetime',
    ];


    public function withdrawer()
    {
        return $this->belongsTo(Client::class, 'withdraw_by');
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