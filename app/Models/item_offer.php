<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class item_offer extends Model
{
   protected $fillable = ['offer_id' ,'item_id' ,'offer_active'];
  
   protected $table = 'item_offers';
   public $timestamps = false;
   
   public function offers ()
   {
	   return $this -> hasMany (Offer::class  ,'offer_i d ', 'id' );
   }
}
