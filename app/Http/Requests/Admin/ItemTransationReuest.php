<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ItemTransationReuest extends FormRequest
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
            'items' => 'required|array|min:1|max:170',
            'items.*.name' => 'required|min:2|max:117',
            'items.*.description' => 'required|min:5|max:99999999999917',
            'items.*.short_description' => 'required|min:5|max:200',
            'item_id' => 'exists:items,id',
        ];
		
    }
	public function messages()
    {
        return 
		[
			'img.required_without' => ' يجب اختيار صورة للقسم ', 
			'required' => 'هذا الحقل مطلوب ', 
			'min' => 'هذا الحقل يجب الا يقل عن حرفان', 
			'max' => 'هذا الحقل يجب الا يزيد عن 150 حرف', 
			'unique' => '  عفوا هذا القسم موجود بالفعل  ', 
			
        ];
    }
}
