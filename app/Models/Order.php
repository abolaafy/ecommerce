<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['customer_id' , 'customer_phone', 'customer_name' , 'total' ,'locale','payment_method' ,'status'];
    const PAID = 'paid';
    const UNPAID = 'unpaid';

    protected $dates = ['start_date', 'end_date', 'deleted_at'];

    public function user ()
    {
        return $this -> belongsTo(User::class , 'customer_id');
    }

}
