<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;
use DB;

class Item extends Model
{
    use SoftDeletes ,Translatable;

	 protected $with = ['translation'];
	 protected $translatedAttributes = ['name','locale', 'description', 'short_description'];
	protected $fillable =
	[
		'id',
		'brand_id',
        'slug',
		'sku',
        'price',
        'special_price',
        'special_price_type',
        'special_price_start',
        'special_price_end',
        'selling_price',
        'manage_stock',
        'qty',
        'in_stock',
        'active'
	];

	 protected $casts = [
        'manage_stock' => 'boolean',
        'in_stock' => 'boolean',
        'active' => 'boolean',
    ];
	protected $date =
	[
		 'special_price_start',
        'special_price_end',
        'start_date',
        'end_date',
        'deleted_at',
	];
    public function wishlists ()
    {
        return $this -> BelongsToMany (User::class, 'wishlists','item_id' ,'user_id');
    }
	public function translation ()
		{
			return $this -> belongsto (ItemTranslation::class , 'item_id' , 'id');
		}
	function brand ()
	{
		return $this -> belongsto (Brand::class) -> withDefault ();

	}

	function categories ()
	{
		return $this -> belongstoMany (SubCategory::class , 'item_categories' , 'item_id' , 'category_id','id' ,  get_default_lang() == 'ar' ? 'id' : 'translation_of');

	}
	function offers ()
	{
		return $this -> belongstoMany (Offer::class , 'item_offers' , 'item_id' , 'offer_id');

	}
	function images ()
	{
		return $this ->  hasMany (Image::class , 'item_id' , 'id' );

	}
	function attributes ()
	{
		return $this ->  belongstoMany (Attribute::class ,Item_attribute::class, 'item_id' , 'attribute_id' ,'id' ,'id' );

	}

	public function options ()
    {
       return $this -> belongstomany (Option::class ,Item_attribute_option::class ,'item_id' ,'option_id'  ,'id' , 'id');

    }
	public function scopeActive($query)
	  {
        return $query -> where('active',1) ;
    }
    public function getActive()
	{
        return  $this -> active  == 0 ?  'غير مفعل'   : 'مفعل' ;
    }
	 static function offerActive ($item_id , $offer_id)
	{
		$data =	DB::table('item_offers')->where('item_id' , $item_id)->where('offer_id' , $offer_id) ->count ();//item_offers where item_id = '.$item_id.' AND offer_id ='.$offer_id )->get ();
		//return $data;
		if ($data == 0)
		{
			DB::statement ('INSERT INTO item_offers (item_id ,offer_id ,offer_active) VALUES ('.$item_id.' ,'.$offer_id.' , 1)');
			return 'مفعل';
		}
		else
		{
			$del = DB::select (' select deleted from item_offers
			where item_id = '.$item_id.' AND offer_id ='.$offer_id );


			if ( $del[0]->deleted == 1)
			{
				return "hiddenTable()";
			}
			else
			{
				return DB::select (' select offer_active from item_offers
				where item_id = '.$item_id.' AND offer_id ='.$offer_id )[0]-> offer_active == 1 ? "مفعل" : "غير مفعل";

			}
		}
	}

}
