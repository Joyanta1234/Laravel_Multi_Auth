<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //this method will show dasboard page for customer
    public function index(){
        // $user = Auth::user();
        // return view('dashboard', compact('user'));
        return view('dashboard');

    }
}
