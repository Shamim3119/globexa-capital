<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable = ['client_id', 'amount'];
    protected $table = 'incomes';
}
