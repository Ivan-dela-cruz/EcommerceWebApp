<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Income extends Model
{
    use SoftDeletes;
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
