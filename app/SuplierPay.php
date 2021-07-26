<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SuplierPay extends Model
{
   protected $table = 'suplier_pays';

   protected $fillable=[
    'suplier_id',
    'user_id',
    'date',
    'biweekly',
    'address',
    'description',
    'total_liters',
    'unit_price',
    'cheese',
    'serum',
    'yogurt',
    'loan',
    'balanced',
    'salt',
    'transaction',
    'total'
   ];
   public function supplier(){
      return $this->belongsTo('App\Models\Supplier', 'suplier_id');
   }
}
