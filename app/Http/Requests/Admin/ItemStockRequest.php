<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ItemQtyRule;

class ItemStockRequest extends FormRequest
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
            'item_id' => 'required|exists:items,id',
            'sku' => 'nullable|required|min:2|max:150',
            'manage_stock' => 'required|in:1,0',
            'in_stock' => 'required|in:1,0',
            //'qty' => 'required_if:manage_stock,== ,1|min:0|max:1000000000',
            'qty' => [new ItemQtyRule ($this -> manage_stock)],
			
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
