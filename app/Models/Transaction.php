<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['order_id' , 'transaction_id', 'payment_method' ];
    public function orders ()
    {
        return $this -> belongsTo(Order::class ,'order_id','id');
    }
}
