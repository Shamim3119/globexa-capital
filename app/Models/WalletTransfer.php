<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletTransfer extends Model
{
    protected $fillable = ['transfer_type_id', 'inactive', 'wallet_type_id'];
    protected $table = 'wallet_transfers';



    public function transfer_type()
    {
        return $this->belongsTo(Parameter::class, 'transfer_type_id');
    }


    public function wallet_type()
    {
        return $this->belongsTo(WalletType::class, 'wallet_type_id');
    }
}
