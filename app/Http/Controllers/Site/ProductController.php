<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Item_category;
use App\Models\Option;
use App\Models\Slider;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index ($slug)
    {
       if(!$data['item']  = Item::with(['categories'=> function ($q)
       {
           $q -> where('translation_lang' ,get_default_lang());
       }])->where('slug', $slug) -> first())
       {
        return 'لم نتمكن من العثور على الصفحة التي تبحث عنه   ';
       }
       $item_id = $data['item']-> id;
       $data['item_options']  = Option::whereHas('items', function ($q) use( $item_id)
       {
            $q->whereHas('options' , function ($qq) use( $item_id)
            {
                $qq -> where('item_id' , $item_id);
            });
       })-> get();
      // return $data['item_options'];

       $product_categries = Item_category::select('category_id')->where('item_id',$data['item']-> id)-> get();
       foreach ( $product_categries as  $product_categry)
       {
           $product_categries_id[] =   $product_categry ->category_id;
       }
       $data['related_items'] = Item::whereHas('categories' , function ($q) use($product_categries_id)
      {
          $q  ->  whereIn('item_categories.category_id' , $product_categries_id);
      })->where('id','!=',$data['item']-> id)->limit(20) -> latest() -> get();
        for ($x =0; $x < $data['item'] -> attributes ->count() ;$x++)
        {
            $data['item'] -> attributes[$x]['options'] =   Option::where('attribute_id' ,$data['item'] -> attributes[$x]->id)->get();
        }
      //return trans('home');
      $data['sliders'] = Slider:: get ();
       return  view('site.products-details' ,$data) ;
    }
}
