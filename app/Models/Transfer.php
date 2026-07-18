<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    //

        protected $fillable = [
                'bofore_incom', 
                'before_deposit', 
                'amount',
                'after_incom',
                'after_deposit',
                'client_id',

 
                ];

    public function member()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

 
}
