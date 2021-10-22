<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemTranslation extends Model
{
    
		protected $fillable = ['name','locale', 'description','item_id' ,'short_description'];
		public $timestamps = false;
		public function items ()
		{
			return $this -> hasToMany (Item::class , 'item_id' , 'id');
		}
}
