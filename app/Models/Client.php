<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
                            'name', 
                            'address', 
                            'phone', 
                            'email', 
                            'inactive',
                            'password',
                            'left_side',
                            'right_side',
                            'ref_id',
                            'site',
                            'photo',
                            'level',
                            'otp',
                        ];

    public function parent()
    {
        return $this->belongsTo(Client::class, 'ref_id');
    }
}
