<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class vendorValidateReuest extends FormRequest
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

    /*
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return
		[
             'img' => 'required_without:update|mimes:jpg,png,jpeg|max:3000', 
			'name' => 'required_without:update|min:2|string|max:100|unique:vendors,name',		
			'nameUpdate' => 'required:create|min:2|string|max:100|sometimes',
			'mobile' => 'required|string|min:0|max:100',
			'email' => 'required|email|min:5|max:150|unique:vendors,email,'.$this -> id,
			'category_id' => 'required|exists:main_categories,id',
			'password' => 'required_without:update|min:0|max:150',
			'active' => 'min:0|max:2',
			'address' => 'required|min:4|max:200',
      ];
    }
	public function messages()
    {
        return 
		[
			'img.required_without' => ' يجب اختيار صورة للتجر ', 
			'required' => 'هذا الحقل مطلوب ',
			'min' => 'هذا الحقل يجب الا يقل عن حرفان', 
			'max' => 'هذا الحقل يجب الا يزيد عن 150 حرف', 
			'unique' => '  عفوا هذا القسم موجود بالفعل  ', 
			'email.unique' => '  عفوا هذا لاميل موجود بالفعل  ', 
			'exists' => '  عفوا هذا القسم غير موجود  ',
			'email' => ' يجب ادخال لميل صحيح  ', 
			
        ];
	}
	
}

