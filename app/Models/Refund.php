<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
        protected $fillable = [
            'amount',
            'investment_id',
            'client_id',
            'charge',
            'deduct',
            'pass_day',
            'return_amount',
            'status_id',
        ];
                        
        protected $casts = [
            'accept_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];


        
    public function member()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }


    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
