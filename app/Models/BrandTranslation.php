<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandTranslation extends Model
{
     protected $fillable = ['name','locale' ,'brand_id'];
	protected  $table = 'brands_translation';
		
		
		public function brands ()
		{
			$this -> belongsTO ('App\Models\Brand' , 'brand_id' , 'id');
		}
		
}