<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
     protected $fillable = ['item_id', 'img' ,'id'];
	 public $timestamps = false ;
	 protected $table = "item_images";
	public function items ()
	{
		return $this -> belongsto (Item::class , 'item_id' ,'id');
	}
}
