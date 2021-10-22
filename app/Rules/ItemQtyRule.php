<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ItemQtyRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
	 private $mange_stock;
    public function __construct($mange_stock)
    {
       $this -> mange_stock = $mange_stock;
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
        if( $this -> mange_stock == 1 &&  $value == null )
			return false ;
		else
			return true ;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'يجب تحديد كمية المنتج';
    }
}
