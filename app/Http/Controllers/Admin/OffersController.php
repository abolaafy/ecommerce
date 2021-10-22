<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offer;
use App\Http\Requests\Admin\OffersRequest;
use App\Http\Requests\Admin\OfferTransitionRequest;
use DB;

class OffersController extends Controller
{
		public function index ()
		{
			$offers = Offer:: get ();
			return view ('Admin.offers.index' , compact ('offers'));
		}
		public function create ()
		{
			
			return view ('Admin.offers.create' );
		}
		//OffersRequest
		public function store(OffersRequest $q)
		{
			//return $q;
			$offer = Offer::create(
			[
				'discount' => $q -> discount,
				'special_price_type' => $q -> special_price_type,
				'special_price_start' => $q -> special_price_start,
				'special_price_end' => $q -> special_price_end,
				'active' => $q -> active ?? 0,
			]);
			
				# save translation
			$offer -> name = $q -> name;
			$offer -> description = $q -> description;
			$offer -> save ();
				
			$langs_all = collect (get_langs_active());
			$langs = $langs_all -> filter (function ($val )
			{
				return $val['abbr'] != get_default_lang ();
			});
			$id =  $offer -> id ;
			return view ('Admin.offers.create-transtion' ,compact ('langs' ,'id') );
			//return $q; OfferTransitionRequest Request
		}
		public function stor_translation (OfferTransitionRequest $q)
		{
			$offer =Offer :: find ($q -> item_id);
			
		$default_lang = DB::table ('offer_translations') -> where ('offer_id' , $q -> item_id)->get ();
		DB::statement('delete  FROM offer_translations where offer_id='. $q -> item_id);
		foreach (array_values($q -> offers ) as $trans)
			{
				 
				 $offer -> name = $trans['name'];
				 $offer -> description = $trans['description'];
				 $offer -> locale = $trans ['locale'];
				$offer -> save ();
				echo "THis === >";
				
			 }
		 $offer -> name = $default_lang[0]  -> name;
		 $offer -> description = $default_lang[0]  -> description;
		 $offer -> locale = $default_lang[0]  -> locale;
		$offer -> save ();
	//	return $offer;
		return redirect()->route('admin.offers')->with(['success' => 'تم ألاضافة بنجاح']);
		}
	public function change_active  ($id )
	{
		
		
		$value = $_GET['value'] ?? 0;
		if (! $category = Offer ::find($id))
			return response() -> json(['error' => 'هذا القسم غير موجود ']);
		
		$category -> update (['active' => $value ] );
	}
}
