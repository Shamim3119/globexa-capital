<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvestmentCharge extends Model
{
    protected $table = 'investment_charges';

    protected $fillable = [
        'level',
        'day',
        'charge',
    ];
}
