<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class OffersRequest extends FormRequest
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
		[	//|unique:offer_translations,name
      
            'name' => 'required|min:2|max:150',
            'discount' => 'required|min:1|max:10',
            'description' => 'required|min:3|max:150',
            'special_price_type' => 'required|in:fixed,percent',
            'special_price_start' => 'required|date',
            'special_price_end' => 'required|date',
			'active' => 'sometimes|in:1',
            
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
