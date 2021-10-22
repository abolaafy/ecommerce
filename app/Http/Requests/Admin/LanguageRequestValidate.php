<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LanguageRequestValidate extends FormRequest
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
		
            'name' => 'required|string|max:100|min:3',
            'abbr' => 'required|string|max:10|min:2',
          //  'active' => 'required|in:1',
            'direction' => 'required|in:rtl,ltr',
        ];
    }


    public function messages()
    {
        return [
            'required' => 'هذا الحقل مطلوب',
            'in' => 'القيم المدخلة غير صحيحة ',
            'name.string' => 'اسم اللغة لابد ان يكون احرف',
			'name.min' => 'هذا الحقل لابد الا يقل عن 3 احرف',
            'abbr.max' => 'هذا الحقل لابد الا يزيد عن 10 احرف ',
			'abbr.min' => 'هذا الحقل لابد الا يقل عن حرفان',
            'abbr.string' => 'هذا الحقل لابد ان يكون احرف ',
            'name.max' => 'اسم اللغة لابد الا يزيد عن 100 احرف ',
        
        ];
    }
}
