<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class log9inDdminReaquestValidate extends FormRequest
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
     * Get the validation rules  apply to the request.
     *
     * @return array
     */
	public function rules()
	{
		return 
		[
            'email' => 'required|min:7|max:100',
			'password' => 'required|min:3|max:200',
        ];
    }
	
	public function messages()
    {
        return 
		[
            'email.required' => 'حقل الايميل فارغ !', 
			'email.min' => 'عفوا يجب ان يكون الايميل اكبر من 7 حرووف',
			'email.max' => 'عفوا يجب ان يكون الايميل اقل من 100 حرف',
			
			'password.required' => 'حقل الرقم السري فارغ !', 
			'password.min' => 'عفوا يجب ان يكون الرقم لسري اكبر من 3 حرووف',	
			'password.max' => 'عفوا يجب ان يكون الرقم لسري اقل من 200  حرف',
			
			
			
        ];
    }
	
}
