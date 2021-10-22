<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\subCategory;
use DB;

class ItemsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return
		[
            'name' => 'required|min:2|max:200',
            'slug' => 'required|min:2|max:150|regex:/^\S*$/u|unique:items,slug',
            'description' => 'required|min:10|max:7000',
            'short_description' => 'required|min:10|max:70',
			'categories' => 'array|required|min:1|max:700',
			'categories.*' => 'required|min:1|max:'.SubCategory::where ('active',1) -> count (),
			'brand_id' => 'required|min:1|max:'.DB::table('brands') -> where ('active',1) -> count (),
			'price' => 'required|min:0|max:70000000000|integer',
			'active' => 'sometimes|in:1',



        ];
    }
	public function messages()
    {
        return
		[
           	'required' => 'هذا الحقل مطلوب ',
           	'price.required' => ' يجب ادخال سعر المنتج ',
			'min' => 'هذا الحقل يجب الا يقل عن حرفان',
			'max' => 'هذا الحقل يجب الا يزيد عن 150 حرف',
			'unique' => '  عفوا هذا القسم موجود بالفعل  ',
			'regex' => '  غير مسموح بوجود مسافات ',


        ];
    }
}
