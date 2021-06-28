<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MilkRecord extends Model
{
    use SoftDeletes;
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
