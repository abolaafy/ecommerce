<?php

namespace App\Rules;

use App\Models\MainCategory;
use Illuminate\Contracts\Validation\Rule;

class mainCategoryNameUniqueRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $category_id;
    public function __construct($category_id)
    {
        $this -> category_id = $category_id;
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
        $category = MainCategory:: where('id' ,'!=' , $this -> category_id) -> where ('translation_of' ,'!=' , $this -> category_id)
        -> where ('name' , $value) -> count ();
        if ($category == 0)
        {
            return true;
        }
        else
            return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '  عفوا هذا القسم موجود بالفعل.';
    }
}
