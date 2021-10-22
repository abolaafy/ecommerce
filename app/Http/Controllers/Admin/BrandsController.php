<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\Brand;
use  App\Models\BrandTranslation;
use App\Http\Requests\Admin\BransRequest;
use DB;

class BrandsController extends Controller
{
	public function index ()
	{
	$brands = Brand::get();
		
	//	return $brands -> translate('ar')->name; //translations('en') -> name ;// -> name;
		return view ('admin.brands.index' , compact ('brands'));
	}
	public function create ()
	{
		
		return view ('admin.brands.create' );
	}
	public function store (BransRequest $q)
	{
		$data_arrs = collect ($q -> brand );
		
		 $data_default = $data_arrs -> filter (  function ($value)
		 {
			 return $value['locale'] == get_default_lang ();
		 });
	
		$data_insert_default = array
		(
			'active' => $q ->active ?? 0,
			'img' => move_img_by_hash('brands' , $q ->img),
		);
		try 
		{
			DB::beginTransaction();
			$brand = Brand::create($data_insert_default);
			
			$data_trans = $data_arrs -> filter (function ($value)
			{
				return $value['locale'] != get_default_lang ();
			});
		
			foreach ($data_trans as $data_tran)
			{
				$brand -> name = $data_tran['name'];
				$brand -> locale = $data_tran['locale'];
				 $brand -> save ();
			}
			$brand -> name = $data_default[0]['name'];
			$brand -> locale = get_default_lang ();
			$brand -> save ();
			DB::commit();
			return redirect()->route('admin.brands')->with(['success' => 'تم ألاضافة بنجاح']);
		}
		catch (Exception $er )
		{
			DB::rollback();
			return redirect()->route('admin.brands')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
		}
	}
	public function edit ($id)
	{
		if (!$brand = Brand::find($id))
			return redirect()->route('admin.brands')->with(['error' => 'هذا الماركة غير موجود']);
		//return $brand -> brand_tarnaslation;
		return view ('admin.brands.edit' , compact ('brand'));
	}
	public function update ($id , BransRequest $q)
	{
		
		//return $q;
		try 
		{
			
			if (!$brand = Brand::find($id))
				return redirect()->route('admin.brands')->with(['error' => 'هذا الماركة غير موجود']);
			DB::beginTransaction();
			$brand ->update (['active' => $q -> active?? 0]);
			if ($q ->has('img')){
				$brand ->update (['img' =>  move_img_by_hash('brands' , $q ->img)]);
				delete_file('site/images/'.$q ->updateImg);
			}
			$data_arrs = $q -> brand ;
			foreach ( $q -> brand  as $brand_tran)
			{
				$brand -> translate($brand_tran['locale']) -> name = $brand_tran['name'];
				$brand -> save ();
			}
			DB::commit();
			return redirect()->route('admin.brands')->with(['success' => 'تم ألتعديل نجاح']);
		}
		catch (\Exception $er)
		{
			DB::rollback();
			return redirect()->route('admin.brands')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
		}
		
	}
	public function destroy  ($id )
	{
		
			try 
			{
				if (!$brand = Brand::find($id))
					return redirect()->route('admin.brands')->with(['error' => 'هذا الماركة غير موجود']);
				$brand -> delete ();
				return redirect()->route('admin.brands')->with(['success' => 'تم حذف الماركة بنجاح']);
			}
			catch (\Exception $er)
			{
				return redirect()->route('admin.brands')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
			}
	}
	public function change_active  ($id )
	{
		
		
		$value = $_GET['value'] ?? 0;
		if (! $category = Brand ::find($id))
			return response() -> json(['error' => 'هذا القسم غير موجود ']);
		
		$category -> update (['active' => $value ] );
	}
}
