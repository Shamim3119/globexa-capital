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
}