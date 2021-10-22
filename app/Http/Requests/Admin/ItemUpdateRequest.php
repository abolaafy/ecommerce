<?php

namespace App\Http\Requests\Admin;

use App\Rules\ItemUpdateRule;
use Illuminate\Foundation\Http\FormRequest;

class ItemUpdateRequest extends FormRequest
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
     * /
    */
    public function rules()
    {
        return
		[
            'name' => 'required|min:2|max:200',
            'slug' => 'required|min:2|max:150|regex:/^\S*$/u',
            'name' => new ItemUpdateRule('item_translations' , $this -> item_id),
            'sub_category_id' => 'nullable:exists:sub_categories,id',
            'slug' =>new ItemUpdateRule('items', $this -> item_id),
            'categories' => 'array',
            'language' => 'exists:languages,abbr',
            'description' => 'required|min:10|max:2000',
            'short_description' => 'required|min:10|max:70',
			'brand_id' => 'nullable|exists:brands,id',
			'price' => 'required|min:0|max:70000000000|numeric',
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
