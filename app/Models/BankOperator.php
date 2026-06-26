<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankOperator extends Model
{
    protected $fillable = ['name', 'inactive', 'type_id', 'currency_id'];
    protected $table = 'bank_operators';


    public function bank_type()
    {
        return $this->belongsTo(Parameter::class, 'type_id');
    }

    public function currency()
    {
        return $this->belongsTo(Parameter::class, 'currency_id');
    }
}
