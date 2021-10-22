<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class offerTranslation extends Model
{
     protected $fillable = ['name','locale' ,'description' ,'offer_id'];
	    public $timestamps = false;
		public function offers ()
		{
			return $this -> hasToMany (Offer::class , 'offer_id' , 'id');
		}
}
