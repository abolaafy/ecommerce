<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item_category extends Model
{
   
   protected $fillable = ['protuct_id' , 'category_id'];
	protected $table = 'item_categories';
	
	
}
