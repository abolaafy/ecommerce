<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public  function index ( $var = null)
    {
        return "Hallo Abolafy To Yuo Profile";
    }
}
