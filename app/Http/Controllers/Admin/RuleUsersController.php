<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;

class RuleUsersController extends Controller
{

    public function index ()
    {
      $users = Admin::with('rules')->latest()->where('id' , '!=', auth()->id())-> get();
    //  return  $users[0];

        return view('admin.users.index' , compact('users'));
    }

    public function creaate ()
    {
        $rules = Rule::get();
        //return $rules;

        return view('admin.rules.index' , compact('rules'));
    }
}
