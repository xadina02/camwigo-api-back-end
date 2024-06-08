<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getHomePage(Request $request) 
    {
        // Gather stuff here before returning with it
        
        return view('admin.index');
    }
}
