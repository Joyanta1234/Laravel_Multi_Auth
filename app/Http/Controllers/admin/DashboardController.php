<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        // $user = Auth::user();
        // return view('admin.dashboard', compact('user'));
        return view('admin.dashboard');

    }
}
