<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\MainCategory;
use App\Http\Requests\Admin\vendorValidateReuest ;
use Illuminate\Support\Facades\Notification;
use App\Notifications\vendorCreate;

class vendorsController extends Controller
{
	  public function index() 
	{
		$vendors = Vendor::selectVendor() -> paginate(PAGINATION_COUNT);
		return view('admin.vendors.index', compact('vendors'));
	}     
	public function create() 
	{
		$categories = MainCategory::active()->where('translation_lang' , get_default_lang()) -> get();
		return view('admin.vendors.create' ,compact('categories'));
	} 
	public function store(vendorValidateReuest $q) 
	{
		 
			
		try 
		{
			
			$vendor = Vendor::create(
			[
					'name' => $q -> name,
					'mobile' => $q ->mobile ,
					'email' => $q ->email ,
					'category_id' => $q ->category_id ,
					'active' => $q ->active ?? 0 ,
					'address' => $q ->address ,
					'password' => $q ->password,
					'logo' => move_img_by_Hash ('vendors' ,$q -> img) ,
			]);
		//	Notification::send($vendor  ,new vendorCreate($vendor));
			return redirect() -> route('admin.vendors') -> with (['success' =>  'تم الحفظ بنجاح']);
		}
		catch (Exception $er )
		{
			return  $er;
			//return redirect() -> route('admin.vendors') -> with (['error' => $er]);
		}
	} 
	public function edit ($id)
	{
		
		$vendor = Vendor::selectVendor ()-> find($id) ;
		if (!$vendor)
			return redirect()->route('admin.vendors')->with(['error' => 'هذا المتجر غير موجود او ربما يكون محذوفا ']);
		$categories = MainCategory::select('id', 'name')->where('translation_of','0') -> get();
	  return view('admin.vendors.edit' ,compact('vendor' ,'categories'));
	}
	public function update ($id , vendorValidateReuest $q )
	{
		//	return  $q ->password;
		
			$vendor = Vendor::  find($id);
			if (!$vendor)
				return redirect()->route('admin.vendors')->with(['error' => 'هذا المتجر غير موجود او ربما يكون محذوفا ']);
		//	return $vendor;
			
			try 
			{
				if ($q ->has ('img'))
				{
					delete_file ($q -> old_img);
					$vendor -> update(
					[
							'logo' => move_img_by_Hash ('vendors' ,$q -> img) ,
					]);
				}
				if ($q ->has ('password') && !is_null ($q ->password) )
					$vendor -> update(['password' =>$q ->password]);
			
				$vendor -> update(
					[
							'name' => $q -> nameUpdate,
							'mobile' => $q ->mobile ,
							'email' => $q ->email ,
							'category_id' => $q ->category_id ,
							'active' => $q ->active ?? 0 ,
							'address' => $q ->address ,
							
					]);
				
				
				return redirect()->route('admin.vendors')->with(['success' => 'تم الحفظ بنجاح']);
			}
			catch (Exception $ex)
			{
            return redirect()->route('admin.vendors')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
			}
	
	}
	
	public function destroy ($id ) 
	{	
		try 
		{
			$vendor = Vendor::find($id);
			if (!$vendor)
				return redirect()->route('admin.vendors')->with(['error' => 'هذا المتجر غير موجود ربما تم حذفه']);
		
			$vendor -> delete();
			return redirect()->route('admin.vendors')->with(['success' => 'تم حذف القسم بنجاح']);
		}
		catch (Exception $er)
		{
			 return redirect()->route('admin.vendors')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
		}
	}
		// addos to prives 
	public function change_active ($id) 
	{
		$value = $_GET['value'] ?? 0;
		 Vendor::where('id' , $id) -> update(['active' => $value ] );
		 return "success change Lang";
	}
}
