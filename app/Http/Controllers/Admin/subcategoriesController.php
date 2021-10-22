<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MainCategory;
use App\Models\SubCategory;
use  App\Http\Requests\Admin\subcategoriesRequest;
use DB;
class subcategoriesController extends Controller
{

      public function index ()
	{
		$categories = SubCategory::select('name' ,'active','slug','img' ,'category_id' ,'id') -> with(['mainCategories' => function ($q)
        {
            $q -> select('name', 'id');
        }])->where ('translation_lang' ,get_default_lang()) -> get();
		//return $categories[0] -> mainCategories -> name;
		return view('admin.subcategories.index' , compact ('categories'));
	}
	public function create ()
	{
		$mainCategies = MainCategory::select('name' ,'id') ->active()-> where ('translation_of' , '0')->get();
		return view('admin.subcategories.create',compact ('mainCategies'));

	}   //subcategoriesRequest
	public function store (subcategoriesRequest $q)
	{
		//return $q;
        if ($q ->has('img'))
			$img_name =  move_img_by_Hash ('subcategories' ,$q -> img);

		$sub_categories_arrs =  collect ($q -> category) ;
		$sub_category =$sub_categories_arrs  ->filter (function ($value)
		{
			return $value['abbr'] == get_default_lang();
		})[0];
		try
		{
			DB::beginTransaction();
			$sub_category_id =SubCategory::insertGetId(
			[
					'name' => $sub_category['name'],
                    'slug' =>$q -> slug ,
					'category_id' => $q -> 	main_category_id ??  SubCategory::select ('category_id') -> find ($q -> sub_category_id) -> category_id,
					'parent_id' =>$q -> sub_category_id ?? 0,
					'active' => $sub_category['active'] ?? 0,
					'translation_lang' => $sub_category['abbr'] ?? 0,
					'translation_of' =>  0,
					'img' => $img_name ?? '',

			]) ;


			$sub_categories = $sub_categories_arrs -> filter (function ($value)
			{
				return $value['abbr'] !=  get_default_lang();
			});
			if ($sub_categories -> count () > 0)
			{
				foreach ( array_values ($sub_categories -> all()) as $category)
				{
					$data_insert [] =
					[
					'name' => $category['name'],
                    'slug' =>$q -> slug ,
					'category_id' => $q -> 	main_category_id ??  SubCategory::select ('category_id') -> find ($q -> sub_category_id) -> category_id,
					'parent_id' =>$q -> sub_category_id ?? 0,
					'active' => $category['active'] ?? 0,
					'translation_lang' => $category['abbr'] ?? 0,
					'translation_of' =>  $sub_category_id ,
					'img' => $img_name,

					];
				}

				SubCategory::insert($data_insert);
			}

		DB::commit();
		return redirect()->route('admin.subcategories.create')->with(['success' => 'تم الحفظ بنجاح']);
		}
		catch (Exception $er )
		{
			DB::rollBack();
			return redirect()->route('admin.subcategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
		}
		return $data_insert ;

	}
	public function edit ($id)
	{
		if (!$category  = SubCategory ::with('categries_translation') ->find($id ))
			return  redirect()->route('admin.subcategories')->with(['error' => 'القسم غير موجد ربما تم حذفه']);
		$mainCastegories = MainCategory::where ('active' , 1) ->where ('translation_lang' , get_default_lang()) -> select('id' ,'name')->active()->get ();
		return view('admin.subcategories.edit' , compact ('category' ,'mainCastegories'));

	}
	public function update  ($id , subcategoriesRequest $q)
	{
		//return $q;
        if (!$sub_category = SubCategory ::find($id ))
			return  redirect()->route('admin.subcategories')->with(['error' => 'القسم غير موجد ربما تم حذفه']);
		$category_req = array_values($q -> category  )[0];
        try
        {
			$sub_category ->name = $category_req['name'];
			$sub_category -> active = $category_req['active'] ?? 0;
            $sub_category -> slug = $q -> slug ;


            if ($q -> has ('img') && $q -> has ('updateImg'))
            {
                delete_file ('/site/images/',$q ->  updateImg);
                $sub_category ->img = move_img_by_Hash ('subcategories',$q ->  img);
            }
            if ($q -> has ('main_category_id'))
			{
				$sub_category ->category_id =$q -> main_category_id;
				$sub_category ->categries_translation () -> update (['category_id' => $q -> main_category_id]);
			}
            else if ($q -> has ('sub_category_id'))
            {
                $main_category_id =  SubCategory::select ('category_id') -> find ($q -> sub_category_id) -> category_id;
                $sub_category ->category_id =$main_category_id;
                $sub_category ->categries_translation () -> update (['parent_id' => $q -> sub_category_id ,'category_id' =>$main_category_id]);
                $sub_category -> parent_id = $q -> sub_category_id;
            }
            $sub_category ->categries_translation () -> update (['slug' => $q -> slug ]);

            $sub_category -> save ();

				return redirect()->route('admin.subcategories')->with(['success' => 'تم ألتحديث بنجاح']);
		}  catch (Exception $ex) {

            return redirect()->route('admin.subcategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

		//return $dcategories_update;
	}
	public function delete ($id )
	{
		try
		{
			$cat = SubCategory::find($id);
			if (!$cat)
				return redirect()->route('admin.subcategories')->with(['error' => 'القسم غير موجد ربما تم حذفه']);


			//delete_file ("/site/images/".$cat -> img);
			$cat -> delete();


			return redirect()->route('admin.subcategories')->with(['success' => 'تم حذف القسم بنجاح']);
		}
		catch (Exception $er)
		{
			 return redirect()->route('admin.subcategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
		}
	}
    public function getCategories ( )
	{
        return response() -> json(
            [
            'categories' => SubCategory::select('id' , 'name') -> where('translation_lang' , get_default_lang()) -> get()
            ]);
    }
    public function change_state_cat ($id )
	{
		$value = $_GET['value'] ?? 0;
		if (! $category = SubCategory ::find($id))
			return response() -> json(['error' => 'هذا القسم غير موجود ']);

		$category -> update (['active' => $value ] );

         $category -> categries_translation () -> update (['active' => $value ]);
        return "sussfel update";
	}

}
