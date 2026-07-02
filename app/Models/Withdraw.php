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
    ];
}