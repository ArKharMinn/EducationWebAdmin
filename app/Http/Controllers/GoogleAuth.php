<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuth extends Controller
{
    //
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $user = Socialite::driver('google')->user();
        $existingUser = User::where('email', $user->email)->first();

        if ($existingUser) {
            auth()->login($existingUser);
        } else {
            if (empty($user->email) || !filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
                return redirect('/')->with('error', 'Invalid email format');
            }

            $newUser = new User();
            $newUser->name = $user->name;
            $newUser->email = $user->email;
            $newUser->phone = '';
            $newUser->address = '';
            $newUser->gender = '';
            $newUser->admin_id = rand(100000, 999999);
            $newUser->password = '';
            $newUser->save();
            auth()->login($newUser);
        }

        return redirect('/dashboard');
    }
}
