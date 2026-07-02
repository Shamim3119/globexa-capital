<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientAccount extends Model
{
    protected $fillable = [
        'client_id',
        'account_name',
        'account_no',
        'operator_id',
        'balance',
        'inactive'
    ];

    public function operator()
    {
        return $this->belongsTo(BankOperator::class, 'operator_id');
    }
}
