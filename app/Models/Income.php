<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $table = 'incomes';

    protected $fillable = [
        'company_id',
        'year',
        'date',
        'hour',
        'total_liters',
        'total_price',
        'description',
        'time_milk_record',
        'status_milk_record',
        'status',
    ];
}
