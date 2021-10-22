<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use DB;

class Offer extends Model
{
	use Translatable;

   protected $with = ['translation'];
	public $translatedAttributes = ['name' ,'description','locale'];
   protected $fillable =
   [
		'id' ,'active','discount','special_price','special_price_type','special_price_start','special_price_end',
   ];
   protected $table = 'offers';
   public $timestamps = false;

   public function items ()
   {
	   return $this -> belongsToMany (Item::class , 'item_offers' ,'offer_id', 'item_id' );
   }


	public function translation ()
	{
		return $this -> belongsto (offerTranslation::class )->withDefault ();// 'offer_id' , 'id');
	}
	 public function scopeActive($query)
	  {
        return $query -> where('active',1) ;
    }
    public function getActive()
	{
        return  $this -> active  == 0 ?  'غير مفعل'   : 'مفعل' ;
    }
	public function scopeGetType($query)
	  {
        return $query -> where('public',1) ;
    }
	public function scopeWhereissetOffer($query)
	  {
        return $query -> where('public',1) ;
    }
    public function getType()
	{
        return  $this -> public  == 1 ?  'عام'   : 'خاص' ;
    }
	static function scopeOffersPublic($q)
	{
        return  $q -> where('active',1) -> where ('public' , 1) -> get ();
    }

}

