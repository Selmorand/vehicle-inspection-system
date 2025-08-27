<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Redirect based on role
            if ($user->isUser()) {
                return redirect()->route('reports.index');
            } elseif ($user->isInspector() || $user->isAdmin()) {
                return redirect()->route('dashboard');
            }
            
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login');
    }

    // Admin-only user registration
    public function showRegister()
    {
        // Only allow admin users to access registration
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('login')->with('error', 'Only administrators can register new users.');
        }
        
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Only allow admin users to register new users
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('login')->with('error', 'Only administrators can register new users.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:user,inspector,admin',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users')->with('success', 'User registered successfully!');
    }
}