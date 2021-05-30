<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table ='customers';
    protected $fillable=[
        'user_id',
        'name',
        'last_name',
        'type_document',
        'num_document',
        'address',
        'phone',
        'email',
//        'photo'
    ];
    public function user()
    {
        return $this->hasOne(User::class,'user_id');
    }
}
