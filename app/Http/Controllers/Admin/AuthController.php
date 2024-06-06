<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function getLoginPage() 
    {
        // return view(''); - admin login page
    }

    public function login(Request $request) 
    {
        //
    }
}
