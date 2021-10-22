<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\MainCategory;
use App\Models\Slider;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class MainCategoryController extends Controller
{
     public function index ($slug)
     {

       if (!$main_category =  MainCategory::select ('id','translation_of','name'  ) -> where('translation_lang' , get_default_lang()) ->where('slug' , $slug) -> first ())
       {

            return 'لم نتمكن من العثور على الصفحة التي تبحث عنه   ';
       }
       $sub_categories = SubCategory::select ('id' ,'translation_of' ) -> where('translation_lang' , get_default_lang()) ->where('category_id' , get_default_lang() == 'ar'? $main_category-> id :$main_category-> translation_of) -> get ();
       for ($x = 0 ; $x < $sub_categories -> count () ; $x++ )
       {
        $sub_categories_id[] =  get_default_lang() == 'ar'?$sub_categories[$x] -> id : $sub_categories[$x] ->translation_of;
       }
      // return $sub_categories_id;
       $data['products'] = Item::with('images') /*-> select('items.id')*/ ->join('item_categories' , function ($q)
       {
           $q -> on('items.id' , '=' , 'item_categories.item_id');
       }) ->whereIn('item_categories.category_id',  $sub_categories_id) -> get() ;
        $data['sliders'] = Slider:: get ();
        $data['category'] =$main_category -> name;
      // return  $data['products'][0] -> images[0]->img;

       return  view('site.products' ,$data) ;

     }
}

