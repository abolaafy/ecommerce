<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\log9inDdminReaquestValidate;
use Auth;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{


			public function getLogin ()
			{
				return view('admin.auth.login');
			}

			public function login (log9inDdminReaquestValidate $request)
			{

                $admin =Admin::where('email', $request->input("email"))-> where ('password' , sha1($request->input("password")))-> get() ;
                if ($admin-> count() == 1)
                {

                    Auth() ->guard('admin') -> loginUsingId($admin[0] ->id);
                    notify()->success('تم الدخول بنجاح  ');
					return redirect() -> route('admin.dashboard');
                }


                else {
				notify()->error('خطا في البيانات  برجاء المجاولة مجدا ');


				return redirect()->back();//->with(['error' => 'هناك خطا بالبيانات']);
                }
			}




}














