<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Item_attribute_option extends Model
{

    protected $fillable =['optiont_id' ,'item_id'];
    protected $table = 'item_attribute_options';
    public $timestamps = false ;

}
