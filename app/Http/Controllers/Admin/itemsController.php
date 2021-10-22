<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\subCategory;
use App\Models\Item;
use App\Models\Offer;
use App\Models\Image;
use DB;
use App\Http\Requests\Admin\ItemsRequest;
use App\Http\Requests\Admin\ItemStockRequest;
use App\Http\Requests\Admin\ItemTransationReuest;
use App\Http\Requests\Admin\ItemOffersRequest;
use App\Http\Requests\Admin\ItemUpdateRequest;
use App\Http\Requests\Admin\OfferTransitionRequest;
use App\Models\Item_category;
use App\Models\Language;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

class itemsController extends Controller
{
		public function index ()
		{
			$items = Item::select ('id' ,'slug' , 'price' ) ->with(['categories' => function ($q)
            {
                $q  -> select ('id' ,'name' , 'translation_of' ) -> where ('translation_lang' , get_default_lang() );
            }]) -> get ();
          // return $items [0] ->categories [0] ['name'] ;
			return view ('Admin.items.general.index' , compact ('items'));
		}
		public function create  ()
		{
			$data ['brands'] = Brand :: where ('active' , 1 ) -> select ('id') -> get ();
			$data ['categories'] = DB::table('sub_categories') -> where ('translation_lang' , get_default_lang() ) -> where ('active' , 1 ) ->  where ('status' , 1 ) -> get ();
			//return $data;
			return view ('Admin.items.general.create' ,$data );
		}
		public function store  (ItemsRequest $q)
		{

			try
			{
				DB::beginTransaction();
				$item  = Item::create (
				[
					'slug' => $q -> slug ,
					'price' => $q -> price ,
					'brand_id' => $q -> brand_id ,
					'active' => $q -> active ?? 0 ,
				]);

					# saving Tanslations
				$item -> name = $q -> name;
				$item -> description = $q -> description;
				$item -> short_description = $q -> short_description;
				$item -> save ();

					# save item categories
				$item -> categories () -> attach ($q -> categories);
				DB::commit ();
				$data =1;

				$langs_all = collect (get_langs_active());
				$langs = $langs_all -> filter (function ($val )
				{
					return $val['abbr'] != get_default_lang ();
				});
				$id =  $item -> id ;
				return view ('Admin.items.general.create-transtion' ,compact ('langs' ,'id') );
			}
			catch (Exception $er )
			{
				DB::rollback();
				return redirect()->route('admin.items')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
			}
			return $item;
		}
        public function edit ($id)
		{
           // return Item_category::select('category_id')-> where ('category_id' ,7 )->first()->category_id  ;
			$data['item'] = Item::select('id' ,'brand_id' , 'slug' ,'price')-> find ($id);
        //  return $data['item'];
            $data['categories'] = subCategory ::where ('active' , 1)->where ('status' , 1)->where ('translation_lang' , get_default_lang()) -> get ();
            $data['brands'] = Brand::select('id'  ) -> get ();
            return view ('Admin.items.general.edit' ,$data);
		}
        public function update (ItemUpdateRequest $q)
		{
              // return $q;
			if (!$item = Item:: find ($q-> item_id))
                 return redirect()->route('admin.items')->with(['error' => 'هذ المنتج غير موجود ربما تم حذفه']);
                 App ::setLocale($q -> language);
                 $item ->name = $q -> name;
                $item ->translate($q -> language)-> description=$q ->description;
                $item ->translate($q -> language)->short_description =$q ->short_description;
                $item ->price = $q -> price ;
                $item ->slug = $q -> slug ;
                $item ->brand_id = $q -> brand_id ;
                $item -> save ();
                if ($q -> has('categories'))
                     DB::statement(' DELETE FROM item_categories  where item_id = '.$q-> item_id);
                     $item -> categories () -> attach ($q-> categories );
                return redirect()->route('admin.items')->with(['success' => 'تم ألاضافة بنجاح']);


		}
		public function save_translation (ItemTransationReuest $q)
		{
			if (!$item = Item::find( $q -> item_id))
				return redirect()->route('admin.items')->with(['error' => 'هذ المنتج غير موجود ربما تم حذفه']);
			try
			{
				DB::beginTransaction ();
				$default_lang = DB::table ('item_translations') -> where ('item_id' , $q -> item_id)->get ();
				DB::statement('delete  FROM item_translations where item_id='. $q -> item_id);
					foreach (array_values($q -> items ) as $trans)
					{

						 $item -> name = $trans['name'];
						 $item -> description = $trans['description'];
						 $item -> short_description = $trans['short_description'];
						 $item -> locale = $trans ['locale'];
						$item -> save ();

					}
					 $item -> name = $default_lang[0]  -> name;
						 $item -> description = $default_lang[0]  -> description;
						 $item -> short_description = $default_lang[0]  -> short_description;
						 $item -> locale = $default_lang[0]  -> locale;
						$item -> save ();
				DB::commit ();
				return redirect()->route('admin.items')->with(['success' => 'تم ألاضافة بنجاح']);
			}
			catch (Exception $er )
			{
				DB::rollback();
				return redirect()->route('admin.items')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
			}


		}
		public function create_stock ($id)
		{
			if (!$item = Item:: find ($id))
				return redirect()->route('admin.items')->with(['error' => 'هذ المنتج غير موجود ربما تم حذفه']);
		//	return $item -> name;
			 return view('admin.items.stock.create' ,compact ('item'));

		}
		public function store_stock (ItemStockRequest $q)
		{
			if ( $q -> manage_stock  == 1)
				Item::whereId($q -> item_id) -> update ($q -> except('_token' , 'item_id'));
			else
			{
				$q -> request -> add (['qty' => null]);
				Item::whereId($q -> item_id) -> update ($q -> except('_token' , 'item_id' , ));

			}
			return redirect()->route('admin.items')->with(['success' => 'تم التحديث بنجاح']);
			//return $q;
		}
		public function add_offer ($id)
		{
			if (!$item = Item::with(['offers' => function ($q) {return $q -> where ('active' ,1)-> where ('public' ,'0')-> where ('deleted' ,'0');}])->  find($id))
				return redirect()->route('admin.items')->with(['error' => 'هذ المنتج غير موجود ربما تم حذفه']);
			//$item['offers'] = Offer::offersPublic ();
			//return $item -> id;
			return view ('Admin.items.offers.add',compact ('item') );
		}
		public function offer_save  (Request $q)
		{
			$validate = $q -> validate (
			[
			'item_id' => 'required|exists:items,id',
			'offer_id' => 'required|exists:offers,id',
			'active' => 'sometimes|in:1',
			] ,
			[
			'required' => 'هذا الحقل مطلوب ',
			'min' => 'هذا الحقل يجب الا يقل عن حرفان',
			'max' => 'هذا الحقل يجب الا يزيد عن 150 حرف',
			'in' => '  يجب ان يساوي رقم 1 ',
			'exists' => '  عفوا هذا القسم غير موجود  ',
			]);
			$active = $q -> active ?? 0;

			 DB::statement('insert into item_offers (item_id , offer_id , offer_active) values ('.$q -> item_id .','.$q -> offer_id .','.$active .')');
			 return redirect()->route('admin.items')->with(['success' => 'تم ألحفظ بنجاح']);
			return $q;
		}
		public function save_offer (ItemOffersRequest $q)
		{
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
				# save relashinShip
				$offer -> items () -> attach ($q -> item_id);

			$langs_all = collect (get_langs_active());
			$langs = $langs_all -> filter (function ($val )
			{
				return $val['abbr'] != get_default_lang ();
			});
			$id =  $offer -> id ;
			return view ('Admin.items.offers.create-transtion' ,compact ('langs' ,'id') );
			//return $q; OfferTransitionRequest Request
		}
		public function stor_offer_translation (OfferTransitionRequest $q)
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
		return redirect()->route('admin.items')->with(['success' => 'تم ألاضافة بنجاح']);
		}

		public function change_active_offer ( $item_id , $offer_id)
		{

			$value = $_GET['value'] ?? 0;
			if (! $item = Item ::find($item_id))
				return response() -> json(['error' => 'هذا القسم غير موجود ']);

			$item -> offers () -> where ('offer_id',$offer_id) ->update (['offer_active' => $value ] );
			return "success ";
		}
		public function deleted_offer  ( $item_id , $offer_id)
		{

			$value = $_GET['value'] ?? 0;
			if (! $item = Item ::find($item_id))
				return response() -> json(['error' => 'هذا القسم غير موجود ']);

			$item -> offers () -> where ('offer_id',$offer_id)-> where ('deleted','0')-> where ('item_id',$item_id) ->update (['deleted' => 1 ] );
			return "success ";
		}
		public function add_images ($item_id)
		{
			$imgs = Item ::find($item_id)-> images ;
			//return $imgs ;
			return view ('Admin.items.images.create',compact (['imgs' ,'item_id']));
		}
		public function save_images_direction (Request $q)
		{
			return response() -> json (
			[
				'oldImg' => $q -> img -> getClientOriginalName(),
				'newImg' => move_img_by_Hash ('items' ,$q -> img),

			]);

		}public function delete_image (Request $q)
		{
			if ($q -> has('img_id') )
			{
				$img = Image::select('img')->find ($q -> img_id);
				  delete_file ('site/images/'.$img -> img);
                  Image::find ($q -> img_id) -> delete ();
                  return response() -> json (['status' => 'true']);
        	}
			else
			{
                return response() -> json (['status' => 'false']);
		 	}
        }
		public function delete_images_direction (Request $q)
		{

				 return delete_file ('site/images/'.$q -> img);
		}
		public function save_images_database (Request $q)
			{
				 $q -> validate (
				[
				'item_id' => 'required|exists:items,id',
				'imgs' => 'required|array|min:1|max:70',
				'imgs.*' => 'required|min:10|max:220',
				] ,
				[
				'required' => 'هذا الحقل مطلوب ',
				'min' => 'هذا الحقل يجب الا يقل عن حرفان',
				'max' => 'هذا الحقل يجب الا يزيد عن 150 حرف',
				'exists' => '  عفوا هذا القسم غير موجود  ',
				]);
				try
				{

					foreach ($q -> imgs as $img )
					{
						 Image::create(
						[
							'item_id' => $q ->item_id,
							'img' => $img,
						]);
					}
					return redirect()->route('admin.items')->with(['success' => 'تم التحديث بنجاح']);

			}catch(\Exception $ex)
			{
				return redirect()->route('admin.items')->with(['error' => 'هذ المنتج غير موجود ربما تم حذفه']);

			}

		}
        public function destroy  ($id )
	{
		try
		{
			$item = Item::find($id);
			if (!$item)
				return redirect()->route('admin.items')->with(['error' => 'القسم غير موجد ربما تم حذفه']);



			$item -> delete();


			return redirect()->route('admin.items')->with(['success' => 'تم حذف القسم بنجاح']);
		}
		catch (Exception $er)
		{   //return $er;
			 return redirect()->route('admin.items')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
		}
	}
}
