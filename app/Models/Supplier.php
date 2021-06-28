<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;
    protected $table ='suppliers';
    protected $fillable=[
        'user_id',
        'name',
        'last_name',
        'type_document',
        'num_document',
        'address',
        'phone',
        'email',
        'photo',
        'status',
    ];

    public function user()
    {
        return $this->hasOne('App\User','user_id');
    }
}
