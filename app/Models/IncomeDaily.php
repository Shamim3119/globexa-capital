<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomeDaily extends Model
{
    protected $fillable = [
        'client_id',
        'amount',
        'invest_id',
    ];
}
