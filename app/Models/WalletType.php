<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletType extends Model
{
    protected $fillable = ['name', 'inactive', 'operator_id'];
    protected $table = 'wallet_types';



    public function bank_operator()
    {
        return $this->belongsTo(BankOperator::class, 'operator_id');
    }

 

}
