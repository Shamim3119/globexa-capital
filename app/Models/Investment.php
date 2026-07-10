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
                'inactive',
                'created_at',
                'updated_at',
                ];

    public function investor()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
 