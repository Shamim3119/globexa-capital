<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomeReference extends Model
{
    protected $table = 'income_references'; 

    protected $fillable = [
        'client_id',
        'amount',
        'invest_id',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function investment()
    {
        return $this->belongsTo(Investment::class, 'invest_id');
    }

}
