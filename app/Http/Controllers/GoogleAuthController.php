<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        // return Socialite::driver('google')->redirect();

        return Socialite::driver('google')
        ->stateless()
        ->scopes(['openid', 'profile', 'email']) // Request specific scopes
        ->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();

            $findUser = User::where('email', $user->email)->first();

            if ($findUser) {
                // Update Google ID if not already set
            if (is_null($findUser->google_id)) {
                $findUser->google_id = $user->id;
                $findUser->save();
            }
    
                Auth::login($findUser);

                return redirect()->intended('account/dashboard'); // Change to your intended route
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => encrypt('dummy_password') // Use a secure alternative
                ]);

                Auth::login($newUser);

                return redirect()->intended('account/dashboard'); // Change to your intended route
            }
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Something went wrong.');
        }
    }
}
