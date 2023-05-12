<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showSignupForm()
    {
        return view('auth.signup');
    }

    public function login(Request $request)
    {
        // Validate the login form data
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // Authentication successful
            // You can add additional logic here, such as redirecting to a dashboard page

            return redirect()->intended('/dashboard');
        } else {
            // Authentication failed
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }
    }

    public function signup(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        // Create a new user
        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = bcrypt($validatedData['password']);
        $user->save();

        // You can add additional logic here, such as sending a welcome email, logging in the user, etc.

        // Redirect the user to a success page or any other page you prefer
        return redirect()->route('signup.success');
    }


    // Add logic for handling login and signup requests if needed
}
