<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('user.auth.login'); // Ensure you have a Blade template at resources/views/auth/login.blade.php
    }

    /**
     * Handle the login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            switch ($user->user_type) {
                case 'admin':
                    return redirect()->route('admin.home');
                default:
                    return redirect()->route('user.home');
            }
        }


        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'confirmpassword' => 'required|min:8',
        ]);

        if ($request->confirmpassword !== $request->password) {
            return back()->withErrors([
                'confirmpassword' => 'The provided passwords do not match.',
            ]);
        }

        $user = User::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        // Redirect users based on their user type
        switch ($user->user_type) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            default:
                return redirect()->route('user.home');
        }
    }


    /**
     * Log the user out.
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
