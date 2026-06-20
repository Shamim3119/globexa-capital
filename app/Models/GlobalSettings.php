<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GlobalSettings extends Model
{
    protected $fillable = [
                            'gen_comm_level', 
                            'min_deposit',
                            'min_activation',
                            'min_withdrawal',
                            'max_deposit',
                            'max_activation',
                            'max_withdrawal',
                            'dep_comm_level',
                            'ref_comm'

                        ];
 
 

}
