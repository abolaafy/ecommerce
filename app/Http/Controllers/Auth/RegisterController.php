<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Rules\IsNumberRule;
use  App\Http\Services\CreateVerificationCode;
use App\Models\users_verification_code;
use DB;
use App\Http\Services\SMSGetways\nexmoSMS;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::PROFILE;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $sms_services;

    public function __construct(CreateVerificationCode $sms_services)
    {
        $this->middleware('guest');
        $this -> sms_services = $sms_services;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data,
        [
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'numeric|digits_between:10,13', 'max:255', 'unique:users,mobile'],
            'mobile' => new IsNumberRule (),
            'password' => ['required', 'string', 'min:2'],
        ],
         [
             'required' => 'هذا الحقل مطلوب ',
			'min' => 'هذا الحقل يجب الا يقل عن حرفان',
			'max' => 'هذا الحقل يجب الا يزيد عن 150 حرف',
			'unique' => '  عفوا هذا الرقم موجود بالفعل ',
         ],
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array
     *  $data
     * return \App\User
     */
    protected function create(array $data)
    {
        DB::beginTransaction();
        $data = User::create([
            'name' => $data['name'],
            'mobile' => $data['mobile'],
            'password' => Hash::make($data['password']),
        ]);
            # save Code In Table
        $code = $this -> sms_services -> saveverificationCode($data['id']);

        $message = $this -> sms_services -> SMSMessageSenderTitle($code);
            # send GetWay

         nexmoSMS ::  sendSMS ($data['mobile'] , $message);
        DB::commit();
        return $data;
    }
}
