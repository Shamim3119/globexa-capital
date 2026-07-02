<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalarySlot extends Model
{
      protected $fillable = [
                            'rank',
                            'name',
                            'left_amount', 
                            'right_amount',
                            'salary_amount',
 
                        ];
}
