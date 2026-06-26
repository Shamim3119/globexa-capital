<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BussinessAccount extends Model
{
    protected $fillable = [
                            'business_id', 
                            'account_name', 
                            'account_no', 
                            'operator_id', 
                            'inactive',
                            'balance',
                        ];

    public function operator()
    {
        return $this->belongsTo(BankOperator::class, 'operator_id');
    }
 
}
