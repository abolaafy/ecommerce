<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item_attribute extends Model
{
    protected $fillable =['attribute_id' ,'item_id	'];
    protected $table = 'item_attributes';
    public $timestamps = false ;
}
