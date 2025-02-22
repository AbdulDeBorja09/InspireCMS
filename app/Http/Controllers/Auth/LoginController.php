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
        return view('user.auth.login');
    }

    public function showRegisterForm()
    {
        return view('User.auth.register');
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

            // Redirect to the intended URL if available, otherwise go to their home page
            return redirect()->intended($user->user_type === 'admin' ? route('admin.home') : route('user.home'));
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
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
