<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\Models\users_verification_code;
use Auth;
use Ramsey\Uuid\Codec\TimestampLastCombCodec;

class VerificationCodeController extends Controller
{
    protected  function verify(Request $q)
    {
        $q -> validate(['code' => 'numeric|digits:5|exists:users_verification_code,code'] ,['digits' => 'يجب ان يحتوي الكود علي 5 حروف فقط' ,'exists' => 'هذا الكود غير صالح']);
       // return $q;
       return $this ->CheckCodeIsset ($q -> code , $q -> link);
    }
    private function CheckCodeIsset ($code , $link)
    {
        $check =users_verification_code:: where ('code' ,$code) -> where ( 'user_id',Auth::guard('site') -> id ()) -> count();
        if ($check == 1)
        {
            Auth::user() -> mobile_verified_at	= NOW();
            Auth::user() -> save ();
            return redirect($link);
        }

        else
        {
            return redirect()->back() ->withErrors(['code'  =>'هذا الكود غير صالح'] );


        }
    }
}
