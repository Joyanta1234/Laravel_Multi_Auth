<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //this method will show login page
    public function index(){
        return view('login');
    }

    //this method will authenticate user
    public function authenticate(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'

        ]);

        if ($validator->passes()){
            if (Auth::attempt (['email' => $request-> email ,'password'=> $request->password]))
            {
                return redirect()-> route('account.dashboard');

            }

            else {
                return redirect () 
                -> route('account.login')
                -> with('error','Either Email or Password is incorrect.'); 
            }

        }


        else{
            return redirect()-> route('account.login')
            ->withInput()
            ->withErrors($validator);
        }
    }

    //this method will show register page
    public function register(){

        return view('register');

    }

    public function processRegister(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required',
        ],

        );

        if ($validator->passes()){

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = 'customer';
            $user -> save();

            return redirect()-> route('account.login')->with('success','You have registered Successfully!');


        }


        else{
            return redirect()-> route('account.register')
            ->withInput()
            ->withErrors($validator);
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()-> route('account.login');
    }

}