<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ItemOptionUnique;

class ItemOptionRequest extends FormRequest
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
            'name' => 'required|min:2|max:35',
            'name' => new ItemOptionUnique ($this -> item_id),
            'price' => 'required|integer|min:2|max:15000000000000',
            'attribute_id' => 'required|exists:attributes,id',
            'item_id' => 'required|exists:items,id',
            'img' => 'required_without:updateImg|mimes:jpg,png,jpeg|max:3000',


        ];
    }
	public function messages()
    {
        return
		[
           	'required' => 'هذا الحقل مطلوب ',
			'min' => 'هذا الحقل يجب الا يقل عن حرفان',
			'max' => 'هذا الحقل يجب الا يزيد عن 150 حرف',
			'unique' => '  عفوا هذا القسم موجود بالفعل  ',
            'img.required_without' => ' يجب اختيار صورة للقسم ',


        ];
    }
}
