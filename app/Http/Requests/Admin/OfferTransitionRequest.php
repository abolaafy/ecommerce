<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class OfferTransitionRequest extends FormRequest
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
            'offers' => 'required|array|min:1|max:170',
            'offers.*.name' => 'required|min:2|max:117',
            'offers.*.description' => 'required|min:5|max:200',
            'item_id' => 'required|exists:offers,id',
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
			
        ];
    }
}
