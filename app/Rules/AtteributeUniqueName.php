<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Attribute;
use App\Models\AttributeTranslation;

class AtteributeUniqueName implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */ 
	 private $attribute_id;
    public function __construct($attribute_id)
    {
        $this -> attribute_id = $attribute_id;
    }
           
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
		if (AttributeTranslation::where('name' ,  $value ) 
			-> where ('attribute_id' ,'!=' , $this -> attribute_id ) ->count ())
		{
			return false;
		}
		else 
			return  true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'عفوا هذه الخاصية موجدة بالفعل';
    }
}
