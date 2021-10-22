<?php

namespace App\Http\Services;

use App\Models\users_verification_code;

class CreateVerificationCode
{
    public function saveverificationCode ($user_id)
    {
        $code = mt_rand(10000 ,99999);

        users_verification_code::where('user_id' ,$user_id ) -> delete ();
        users_verification_code::create(['user_id' => $user_id , 'code' => $code]);
        return $code;
     }
       function SMSMessageSenderTitle ($code)
     {
            return  " This Code Verifed Register Shop : ". $code ;
     }
}
