<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Attribute extends Model
{
     use Translatable;
	 protected $with = ['translations'];
	 protected $translatedAttributes = ['name'];

	 public function items ()
     {
        return $this -> belongstomany (Item::class ,Item_attribute::class,'attribute_id' ,'item_id' ,'id' , 'id');

     }


	 public function options ()
	 {
		 return $this -> belongsto (Option::class ,'attribute_id' ,'id');
	 }
}
