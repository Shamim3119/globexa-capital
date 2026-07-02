<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomeGeneration extends Model
{
    protected $fillable = [
        'client_id',
        'amount',
        'invest_id',
    ];
}
