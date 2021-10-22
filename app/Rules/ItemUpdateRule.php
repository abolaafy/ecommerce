<?php

namespace App\Rules;

use App\Models\Item;
use App\Models\ItemTranslation;
use Illuminate\Contracts\Validation\Rule;

class ItemUpdateRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $table;

    public $item_id;
    public function __construct($table ,$item_id )
    {
         $this -> table = $table;
         $this -> item_id = $item_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value  )
    {
      //  echo "$value";
        if ($this -> table  == 'items')
            $item = Item::whereNotIn('id' , [   $this -> item_id ])-> where('slug'  ,  $value) -> count ();
        else if ($this -> table  == 'item_translations')
             $item = ItemTranslation::whereNotIn('item_id' , [   $this -> item_id ])-> where('name'  ,  $value) -> count ();
        if ($item == 0)
            return true;
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
        return $this -> table  == 'item_translations' ?  ' هذا المنتج مضاف من قبل':

              ' هذا الربط تم استخدامه من قبل لاحدا لمنتجات';
    }
}
