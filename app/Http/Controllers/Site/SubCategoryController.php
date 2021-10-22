<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Slider;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index ($slug)
     {
        $parent_sub_category = SubCategory::select(get_default_lang() == 'ar' ? 'id':'translation_of AS id' , 'name')-> where('translation_lang' , get_default_lang()) ->where('slug' ,$slug)-> get();
        if ( $parent_sub_category ->count() == 0)
        {
            return 'لم نتمكن من العثور على الصفحة التي تبحث عنه   ';
        }
        $sub_categories = SubCategory:: select(get_default_lang() == 'ar' ? 'id':'translation_of AS id' )-> where('translation_lang' , get_default_lang()) ->where('parent_id' ,$parent_sub_category[0] ->id)-> get();
        foreach ($sub_categories as $sub_categ)
        {
            $sub_categories_id [] =  $sub_categ ->id;
        }
         $sub_categories_id[] = $parent_sub_category[0] ->id;

          $data['products']= Item::select('items.id' , 'items.price','items.slug' , 'items.in_stock', 'items.discount_price') -> join('item_categories' , function ($q)
        {
                $q -> on('items.id' ,'=' ,'item_categories.item_id');
        })->whereIn('item_categories.category_id' ,$sub_categories_id) -> get();
        $data['sliders'] = Slider:: get ();
        $data['category'] =$parent_sub_category[0] -> name;
      //  return  $data['products'];
       return  view('site.products' ,$data) ;

     }
}
