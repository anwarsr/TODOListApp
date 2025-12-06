<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

/**
 * AuthController
 * 
 * Controller untuk mengelola autentikasi user
 * Termasuk login, register, logout, dan manajemen profile
 * 
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    /**
     * Menampilkan halaman login
     * 
     * @return \Illuminate\View\View
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Memproses login user
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Cek apakah user login dengan Google (password null)
        $user = User::where('email', $request->email)->first();
        if ($user && $user->password === null) {
            return back()->withErrors([
                'email' => 'This account uses Google Sign-In. Please use "Sign in with Google" button.',
            ]);
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Redirect based on role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->intended('/tasks');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Menampilkan halaman register
     * 
     * @return \Illuminate\View\View
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Memproses registrasi user baru
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'user',
        ]);

        $user->ensureDefaultCategories();

        Auth::login($user);

        return redirect('/tasks')->with('success', 'Registration successful!');
    }

    /**
     * Memproses logout user
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    /**
     * Update authenticated user's email and/or password.
     * Minimal validation per user request (no old password required).
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed'
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];

        if (!empty($data['password'])) {
            $user->password = bcrypt($data['password']);
        }
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Show profile edit form.
     */
    public function editProfile()
    {
        return view('profile.edit');
    }

    /**
     * Delete user's own account.
     */
    public function deleteAccount(Request $request)
    {
        $user = Auth::user();
        
        // Delete all user's tasks first (cascade delete)
        $user->tasks()->delete();
        
        // Logout user
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Delete the user
        $user->delete();
        
        return redirect('/login')->with('success', 'Your account has been deleted successfully.');
    }
}