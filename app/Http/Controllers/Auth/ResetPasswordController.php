<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Http\Services\CreateVerificationCode;
use Illuminate\Http\Request;
use App\User;
use App\Http\Services\SMSGetways\nexmoSMS;
use Exception;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\users_verification_code;

class ResetPasswordController extends Controller
{
    public $code_created;
    public function __construct(CreateVerificationCode $code_created)
    {
        $this -> code_created = $code_created;
    }

    public function verify (Request $q)
    {
           return $this -> CheckMobileIsset ($q -> mobile);
    }
    private function CheckMobileIsset ($mobile  )
    {
        $user =User::where('mobile' , $mobile)->get();
        if ( $user  -> count () != 0)
        {
            try
            {
                Auth::guard('reset') ->loginUsingId($user[0] -> id);
                $code = $this -> code_created ->saveverificationCode($user[0] -> id);
                $message = $this -> code_created ->SMSMessageSenderTitle($code);
                nexmoSMS::sendSMS($mobile ,$message);
                return response() -> json(['status' => 'success']);
            }
            catch (Exception $er)
            {
                return response() -> json(['status' => 'error']);
            }
        }
        else {
            return response() -> json(['status' => 'error']);
        }

    }
    public function logout ()
    {
       DB::statement ('DELETE FROM users_verification_code WHERE user_id='. Auth::guard('reset')-> id ());
        Auth::guard('reset')-> logout ();
        return redirect() -> route('home');
    }

    public function verifyCode (Request $q)
    {
           return $this -> CheckCodeIsset ($q -> code);
    }
    private function CheckCodeIsset ($code  )
    {
        $verify_code =users_verification_code::where('code' , $code)-> where('user_id' , Auth::guard('reset') -> id ())->get();
        if ( $verify_code  -> count () != 0)
        {
            Auth::guard('reset') ->logout ();
            Auth::guard('change_password') ->loginUsingId($verify_code[0] -> user_id);
              return response() -> json(['status' => 'success']);
       }
        else {

            return response() -> json(['status' => 'error']);
        }

    }
}
