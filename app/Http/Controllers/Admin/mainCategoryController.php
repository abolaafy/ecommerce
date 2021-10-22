<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\MainCategory;
 use App\Http\Requests\Admin\mainCategoryRequestValidate as validatReq;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\mainCategoryRequestValidate;
use App\Http\Requests\Admin\mainCategoryUpdateRequest;
use DB;

class mainCategoryController extends Controller
{
      public function index()
	{
		$categories = MainCategory::where('translation_lang' ,get_default_lang() ) ->selectCat () -> get ();
		return view('admin.maincategories.index', compact('categories'));
	}
	public function create()
	{
		return view('admin.maincategories.create');
	}
	public function store(validatReq $q)
	{
		if ($q->has('img')){

			$img_name = move_img('C:\xampp\htdocs\shop7\public\site\images\maincategories' ,$q ->img );
		}
		$main_categories = collect ($q -> category);

		$categry_ar = $main_categories -> filter( function ($value , $key )
				{
						return $value['abbr'] == get_default_lang();

				});
		try
		{
			DB::beginTransaction();
			$id_def_lang = MainCategory::insertGetId (
				[
					'translation_lang' => $categry_ar [0]['abbr'],
					'translation_of' => 0,
					'name' => $categry_ar  [0]['name'],
					'slug' => $q -> slug,
					'img' => $img_name,
				]);



			$categry_last = $main_categories -> filter( function ($value , $key )
					{
							return $value['abbr'] != get_default_lang();
					});
					if ( isset ($categry_last ) && $categry_last  -> count () > 0)
					{
								$categries_arr =[];
								foreach ($categry_last as $categry)
								{
									$categries_arr[] =
									[
										'translation_lang' => $categry['abbr'],
										'translation_of' => $id_def_lang ,
										'name' => $categry['name'],
										'slug' => $q -> slug,
											'img' => $img_name,
									];
								}

								MainCategory::insert($categries_arr);
								DB::commit();
							 return redirect()->route('admin.maincategories')->with(['success' => 'تم الحفظ بنجاح']);
					}
		}
		catch (Exception $ex)
			{
				DB::rollBack();
				return redirect()->route('admin.maincategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);

			}

				return  DB::beginTransaction();

	}
	public function edit ($id)
	{
		$mainCategory = MainCategory::with('categories') ->SelectCat() -> find($id );
		if (!$mainCategory)
				return redirect()->route('admin.maincategories')->with(['error' => 'هذا القسم غير موجود ']);
		// return $mainCategory;
		 return view('admin.maincategories.edit', compact('mainCategory'));
	}
	public function update ($id , mainCategoryUpdateRequest $q )
	{
	//	return $q;
        $mainCategory = MainCategory:: find($id );
		if (!$mainCategory)
				return redirect()->route('admin.maincategories')->with(['error' => 'هذا القسم غير موجود ']);

		$category_req = array_values($q -> category  )[0];
		//$img = ['img' => "Rafeh"];
		$dataUpdate =
		[
				'name' =>  $category_req ['name'],
				'active' =>  $category_req ['active']??0,
                'slug' =>  $q -> slug,
		];

		if ($q->has('img'))
				$dataUpdate['img'] = move_img('C:\xampp\htdocs\shop7\public\site\images\maincategories' ,$q ->img );
		try {
				$mainCategory -> update ($dataUpdate);
                $mainCategory -> category_translation () -> update (['slug' =>  $q -> slug]);
				return redirect()->route('admin.maincategories')->with(['success' => 'تم ألتحديث بنجاح']);
			}  catch (Exception $ex) {

            return redirect()->route('admin.maincategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
			//return $q;
	}

	public function delete ($id )
	{
		try
		{
			$cat = MainCategory::find($id);
			if (!$cat)
				return redirect()->route('admin.maincategories')->with(['error' => 'هذا القسم غير موجود ']);

			if ($cat -> vendors -> count () > 0 )
				return redirect()->route('admin.maincategories')->with(['error' => 'لأ يمكن حذف هذا القسم  ']);

			//delete_file ("site/images/maincategories/".$cat -> img);
			$cat -> delete();


			return redirect()->route('admin.maincategories')->with(['success' => 'تم حذف القسم بنجاح']);
		}
		catch (Exception $er)
		{
			 return redirect()->route('admin.maincategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
		}
	}
	public function change_state_cat ($id )
	{
		$value = $_GET['value'] ?? 0;
		if (! $category = MainCategory ::find($id))
			return response() -> json(['error' => 'هذا القسم غير موجود ']);

		$category -> update (['active' => $value ] );

         $category -> category_translation () -> update (['active' => $value ]);
        return "sussfel update";
	}
}
















