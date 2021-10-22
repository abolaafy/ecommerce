<?php
//use DB;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

define ('COIN' , ' جنيه ');

function total_price()
{
    if(Auth::guard('site') -> check ())
    {
        $price =0;
        $prices = Cart::where('user_id' ,Auth::guard('site') -> id () ) -> get('selling_price');
        for ($x =0 ; $x < $prices -> count(); $x++)
        {
            $price += $prices[$x]->selling_price;
        }
        return $price;
    }
//	return Illuminate\Support\Facades\Config::get('app.locale');
}

function get_langs_active()
{
	return App\Models\Language::where('active' ,1) -> selects() -> get();
}

function select_css_dir()
{
    if  ( App::getLocale() == 'ar')
    echo '-rtl';
    else
    echo null;
}

function get_default_lang()
{
	return Illuminate\Support\Facades\Config::get('app.locale');
}
function move_img ($path  , $img)
{
	$file_name	 = $img -> getClientOriginalName();
	 $img -> move ( $path ,$file_name);
	return $file_name;
}
function move_img_by_Hash ($path  , $img)
{
	$img_name = $img -> store('/' , $path);

	return $path.'/'.$img_name;
}
function delete_file ($path , $name = null)
{
	//if (is_file("C:/xampp/htdocs/shop7/publics/".$path))
		try {
		unlink ("C:/xampp/htdocs/shop7/public/".$path);
		echo "success Delete File ";
		}
		catch (Exception $er){
	echo "THe File Not Exists ";

		}
}
function check_item_offers ($offer_id , $item_id)
{

		try
		{

			DB::table ("select * from item_offers");
		}
		catch (Exception $er){
	echo "THe File Not Exists ";

		}
}

