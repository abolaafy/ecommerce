<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\models\Wishlist;
use Illuminate\Http\Request;
use DB;

class WishlistController extends Controller
{

    public function index (Request $q)
    {
       

        $data['products']=auth('site')->user() ->wishlist ()-> latest()->get();
        $data['sliders'] = Slider:: get ();
       return  view('site.wishlists' ,$data) ;
    }

    public function store (Request $q)
    {
        try
        {
            if (!auth('site')->user() -> wishlistIsset($q -> item_id))
            {
                auth('site')->user() ->wishlist() -> attach($q -> item_id);
                return response() -> json(['sataus' => true , 'wishlist' => true]);
            }
            return response() -> json(['sataus' => true , 'wishelist' => false]);
         }
        catch(\Exception $er)
        {
            return response() -> json(['sataus' => false]);
        }

    }
    public function destroy (Request $q)
    {
        try
        {
             auth('site')->user() ->wishlist() -> detach($q-> item_id);
             return response() -> json(['sataus' => true]);
        }
        catch(\Exception $er)
        {
            return response() -> json(['sataus' => false]);
        }
    }
}
