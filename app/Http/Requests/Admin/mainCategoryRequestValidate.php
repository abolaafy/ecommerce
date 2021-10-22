<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class mainCategoryRequestValidate extends FormRequest
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
			'category' => 'required|array|min:1|max:150',
			'category.*.name' => 'required|min:2|max:150|unique:main_categories,name',//|unique:main_categories,name',
            'slug' => 'required|regex:/^\S*$/u|min:2|max:150|unique:main_categories,slug',//|unique:main_categories,name',

            'category.*.abbr' => 'required|min:2|max:150',
			'category.*.active' => 'min:0|max:150',
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
