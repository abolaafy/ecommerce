<?php

namespace App\Http\Services\SMSGetways;

use  Nexmo\Laravel\Facade\Nexmo;

class nexmoSMS
{
    public static function sendSMS($phone , $message)
    {
        try
        {
            Nexmo::message()->send([
                'to'   => '2'.$phone,
                'from' => 'shop',
                'text' => $message
            ]);
        }
        catch (\Exception $er)
        {
            return "حدث خطا في ارسال كود التحقق الي رقمك";
        }
     }
}
