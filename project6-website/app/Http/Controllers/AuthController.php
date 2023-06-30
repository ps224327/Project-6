<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function showSignupForm()
    {
        return view('auth.signup');
    }

    public function showLoginForm()
    {
        return view('auth.login');
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

            return redirect()->intended('/');
        } else {
            // Authentication failed
            $message = 'Inloggegevens niet bekend';
            return redirect()->back()->with('alert', ['type' => 'error', 'message' => $message, 'autoClose' => true]);
        }
    }

    public function signup(Request $request)
    {
        try {
            // Validate the form data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users,email',
                'password' => 'required|string|min:6|confirmed',
            ]);

            // Create a new user
            User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
            ]);

            // Redirect the user to a success page or any other page you prefer
            return redirect()->route('signup.success');
        } catch (ValidationException $e) {
            // Handle the validation error
            $message = 'Profiel niet aangemaakt';
            return redirect()->back()->with('alert', ['type' => 'error', 'message' => $message, 'autoClose' => true]);        }
    }

    public function signupSuccess()
    {
        return view('auth.signup_success');
    }

    public function profile()
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Return the profile view with the user data
        return view('auth.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email,' . auth()->id(),
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Update the authenticated user's information
        $user = User::find(auth()->id());
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        if ($validatedData['password']) {
            $user->password = Hash::make($validatedData['password']);
        }
        $user->update();

        // Redirect the user back to the profile page with a success message
        $message = 'Profiel succesvol aangepast';
        return redirect()->back()->with('alert', ['type' => 'message', 'message' => $message, 'autoClose' => true]);
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('home');
    }
}
