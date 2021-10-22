<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswodController extends Controller
{
    public function show (Request $q)
    {
        return view('auth.passwords.reset');
    }
    public function change (Request $q)
    {
        try
        {
         User::find(Auth::guard('change_password')->id())->update(['password' =>  Hash::make($q -> password)]);
         DB::statement ('DELETE FROM users_verification_code WHERE user_id='. Auth::guard('change_password')-> id ());
         Auth::guard('site') -> loginUsingId( Auth::guard('change_password')-> id ());
         Auth::guard('change_password')-> logout ();
         return redirect()->route('home');
        }
        catch (Exception $er)
        {
            return redirect()->back()->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);

        }

    }
    public function logout (Request $q)
    {
        DB::statement ('DELETE FROM users_verification_code WHERE user_id='. Auth::guard('change_password')-> id ());
        Auth::guard('change_password')-> logout ();
        return redirect() -> route('home');
    }
}

