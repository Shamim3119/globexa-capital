<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    protected $fillable = [
                'client_id', 
                'investment_id', 
                'amount',
                'before_invest',
                'after_invest',
                ];

    public function investor()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
 