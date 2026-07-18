<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class P2P extends Model
{
    protected $table = 'p2ps';

    protected $fillable = [
        'from_id',
        'to_id',
        'amount',
    ];


    public function sender()
    {
        return $this->belongsTo(Client::class, 'from_id');
    }

    public function receiver()
    {
        return $this->belongsTo(Client::class, 'to_id');
    }
}