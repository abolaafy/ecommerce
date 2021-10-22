<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Item;
use DB;
class ItemOptionUnique implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $item_id;
    public function __construct($item_id)
    {
        $this -> item_id = $item_id;
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
      
         $option = DB::select ('select COUNT(*) AS count from option_translations INNER JOIN item_attribute_options ON item_attribute_options.option_id = option_translations.id WHERE item_attribute_options.item_id = '. $this -> item_id.' AND option_translations.name ="'.$value .'"' ); 

      if ($option [0]->count == 0)
           return true;
        else {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ' عفوا هذه الخاصة تم اضافتها من قبل';
    }
}
