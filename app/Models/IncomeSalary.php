<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomeSalary extends Model
{
        protected $fillable = [
        'client_id',
        'amount',
    ];
}
