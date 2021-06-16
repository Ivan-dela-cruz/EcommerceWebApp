<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MilkRecord extends Model
{
    protected $table = 'milk_records';
    protected $fillable = [
        'income_id',
        'supplier_id',
        'total_liters',
        'price',
        'sub_total',
        'year',
        'date',
        'hour',
        'status',
    ];
}
