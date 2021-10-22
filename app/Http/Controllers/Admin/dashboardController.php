<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Http\Enumrations\CategoryType;
use App\Models\Rule;

class dashboardController extends Controller
{
			public function dashboard ()
			{
               // return auth('admin')->user()->rule_id;
                $permissions =  Rule::where('id' , auth('admin')->user()->rule_id) ->get('permissions')[0];
              //  return v $permission->permissions;
                return view('admin.dashboard');

			}
			public function logout ()
			{

				Auth('admin') -> logout ();
				return redirect()->route('admin.login') ;
			}
}
