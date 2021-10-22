<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Option extends Model
{
    use Translatable;
    public $timestamps = false ;
    protected $with = ['translations'];
    protected $translatedAttributes = ['name'];
    protected $fillable =
    [
         'id' ,'price' ,'attribute_id' ,'img' 
    ];
    public function attributes ()
    {
        return $this -> hastoMany (Attribute::class ,'attribute_id' ,'id');
    }

	public function items ()
     {
        return $this -> belongstomany (Item::class ,Item_attribute_option::class,'option_id' ,'item_id' ,'id' , 'id');

     }
}
