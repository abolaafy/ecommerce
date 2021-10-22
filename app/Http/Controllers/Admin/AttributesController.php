<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attribute;
use  App\Http\Requests\Admin\AttributeRequest;

class AttributesController extends Controller
{
	public function index ()
	{
		$attributes = Attribute ::get ();
		return view('admin.Attributes.index',compact ('attributes'));
	}
	public function create ()
	{
		return view('admin.Attributes.create');
	}
	public function store (Request $q)
	{
		$q -> validate (['name' => 'required|min:2|max:117|unique:attribute_translations,name'],['required' => 'هذا الحقل مطلوب ','min' => 'هذا الحقل يجب الا يقل عن حرفان', 'max' => 'هذا الحقل يجب الا يزيد عن 150 حرف', ]);
		 DB::beginTransaction();
		$attr = Attribute::create();
		
			# save translation
		$attr -> name = $q -> name;
		$attr -> save ();
		DB::commit();
		return redirect()->route('admin.attributes')->with(['success' => 'تم ألحفظ بنجاح']);
	}
	public function edit  ( $id)
	{
		if (!$attribute = Attribute ::find ($id))
			return redirect()->route('admin.attributes')->with(['error' => 'هذه الخاصية غير موجودة ربما تم حذفها']);
		return view('admin.Attributes.edit',compact ('attribute'));
	}
	public function update   ( AttributeRequest $q)
	{
		if (!$attribute = Attribute ::find ($q -> id))
			return redirect()->route('admin.annnnttributes')->with(['error' => 'هذه الخاصية غير موجودة ربما تم حذفها']);
		
		# save translation
		$attribute->name = $q->name;
		//return $attribute;
          $attribute->save();

		return redirect()->route('admin.attributes')->with(['success' => 'تم ألحفظ بنجاح']);
	}
}
