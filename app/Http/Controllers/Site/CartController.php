<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use App\Basket\Basket;
use App\Models\Item  ;
use App\Models\Slider;
use Illuminate\Contracts\Session\Session as SessionSession;
use Session;
use DB;
class CartController extends Controller
{
    private $basket;

    public function  index()

    {
         
       // return Session::forget('items');
        $sliders = Slider:: get ();
        if (Auth::guard('site') -> check())
        {
            $items = Auth::guard('site') ->user() -> carts()->with('images') -> get();
            for ($x=0; $x <  $items->count()  ;$x++ )
            {
              $items[$x]->quantity = Cart::where('item_id', $items[$x]->id)->get('quantity')[0]->quantity;
             $items[$x]->selling_price = Cart::where('item_id', $items[$x]->id)->get('selling_price')[0]->selling_price;
            }
        //    return
            //return $items;
            return view('site.cart.index-where-login',compact('items','sliders'));
        }

        else if (Session::exists('items'))
            $items =array_values( Session::get('items'));
        else
             $items =null;

        return view('site.cart.index',compact('items','sliders'));
    }

    public function  store (Request $q)
    {
        if (Auth::guard('site') -> check())
        {

            if (auth('site')->user() -> cartIsset($q -> item_id))
            {
                return response() -> json(['sataus' => true , 'cart' => false]);
            }

            DB::statement(' insert into `carts` (`item_id`,`selling_price`,`quantity`, `user_id`) values (?,?,?,?)',[$q->item_id ,$q->selling_price,$q->quantity, auth('site') -> id() ]);
            return response() -> json(['sataus' => true,'cart' => true]);
        }

    }
    public function  store_session (Request $q)
    {
            $item = Item::find($q -> item_id);
            $item['quantity'] = $q ->quantity ?? 1;
            $item['selling_price'] = $q ->selling_price ?? $item ->price;
              if (session()->exists('items'))
            {
                if (Session::exists('items.'.$q -> item_id))
                {
                    return response() -> json(['sataus' => true , 'cart' => false]);
                }
                Session::push('items.'.$q -> item_id ,$item );
                return response() -> json(['sataus' => true,'cart' => true]);
            }
            else
            {
                Session::put('items.'.$q -> item_id  ,[$item] );
                 return response() -> json(['sataus' => true,'cart' => true]);
            }



    }
    public function  delete(Request $q)
    {
        if (Auth::guard('site') -> check())
        {
             Auth::guard('site') ->user() -> carts()->detach($q ->item_id);
            return response() -> json(['sataus' => true,'cart' => true]);
        }
        else if (Session::exists('items'))
        {

        }
    }
    public function  delete_session(Request $q)
    {

         if (Session::exists('items.'.$q-> item_id))
        {
            Session::forget('items.'.$q-> item_id);
            return response() -> json(['sataus' => true,'cart' => true]);
        }
    }
}
