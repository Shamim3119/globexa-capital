<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomeIBS extends Model
{
    protected $table = 'income_ibs';  

    protected $fillable = [
        'client_id',
        'amount',
        'invest_id',
    ];
}
