<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class DashboardController extends Controller
{
    //show index page
    public function index(){
        return view('dashboard/index');
    }

    //logout
    public function custom_logout(){
        Auth::logout();
        return view('auth.login');
    }
}
