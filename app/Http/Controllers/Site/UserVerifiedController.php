<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserVerifiedController extends Controller
{
    public function  verified()
    {
        // Auth()->logout();
        return view('auth.passwords.confirm');
    }
}
