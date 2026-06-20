<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepositeCommission extends Model
{
    protected $fillable = [
                            'level',
                            'day',
                            'deposite_commission'
                        ];
}
