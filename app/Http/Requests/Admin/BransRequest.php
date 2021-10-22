<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BransRequest extends FormRequest
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
          'img' => 'required_without:updateImg|mimes:jpg,png,jpeg|max:3000',
          'brand' => 'required|array|min:1|max:117',
		  'brand.*.name' => 'required|min:2|max:150',
		  'brand.*.locale' => 'required|min:2|max:10',
          'active' => 'sometimes|min:0|max:2',
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
