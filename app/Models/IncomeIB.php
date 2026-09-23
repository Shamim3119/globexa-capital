<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomeIB extends Model
{
    protected $table = 'income_ib';  

    protected $fillable = [
        'client_id',
        'amount',
        'balance',
    ];
}
