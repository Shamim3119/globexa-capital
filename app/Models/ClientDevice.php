<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientDevice extends Model
{
    protected $fillable = [
        'client_id',
        'device_id',
        'device_name',
        'platform',
        'verified_at',
        'last_login_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}