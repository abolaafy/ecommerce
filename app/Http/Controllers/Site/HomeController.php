<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\MainCategory;
use App\Models\Slider;
use App\Models\SubCategory;
use App\Models\User as ModelsUser;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Facades\Auth;
//use App\User;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index ()
    {
        if (get_default_lang() =='ar')
        {

        $categories = MainCategory::select ('id' , 'slug' ,'name' ,'img') ->with(['sub_categories' => function ($q)
        {
            $q -> select('id' , 'slug' ,'name' ,'category_id')->where('parent_id' , 0)-> where('active' , 1)->where('status' , 1)->where('translation_lang' ,get_default_lang()) -> get ();
        }]) -> where('translation_lang' ,get_default_lang())
        -> where('active' , 1)->get();
    }
    else
    {
        $categories =MainCategory::select ('id' , 'slug' ,'name' ,'translation_of' ,'img') -> where('translation_lang' ,get_default_lang())
        -> where('active' , 1)->get();
        foreach ($categories as $main_category)
        {
            $main_category ['sub_categories'] =SubCategory::select ('id' , 'slug' ,'name','translation_of') ->where ('translation_lang' ,get_default_lang())
            -> where('active' , 1)-> where('status' , 1)->where('parent_id' , 0)->where('category_id' , $main_category ->translation_of)-> get ();

        }

     }
      //  return $categories;
       $data['categories']= $categories;
        $data['sliders'] = Slider:: get ();
        //return $categories[0]['sub_categories'];
       return view('site.index' , $data);
    }
    public function logout ()
    {

      Auth()->logout();
      return redirect() -> route('home');
    }
}
