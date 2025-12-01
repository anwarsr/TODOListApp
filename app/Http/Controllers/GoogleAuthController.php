<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

/**
 * GoogleAuthController
 * 
 * Controller untuk mengelola autentikasi menggunakan Google OAuth 2.0
 * Menangani redirect ke Google dan callback setelah user login
 * 
 * @package App\Http\Controllers
 */
class GoogleAuthController extends Controller
{
    /**
     * Redirect user ke halaman login Google
     * 
     * Step 1: User klik "Sign in with Google"
     * Step 2: Redirect ke Google OAuth dengan client_id dan scope
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback dari Google setelah user login
     * 
     * Step 3: Google redirect back dengan authorization code
     * Step 4: Exchange code untuk access token
     * Step 5: Get user info dari Google
     * Step 6: Create atau update user di database
     * Step 7: Login user ke aplikasi
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback()
    {
        try {
            // Get user info from Google (id, name, email, avatar)
            $googleUser = Socialite::driver('google')->user();
            
            // Cek apakah user sudah pernah login dengan Google (by google_id)
            $user = User::where('google_id', $googleUser->id)->first();
            
            if ($user) {
                // User sudah ada, update info jika ada perubahan
                $user->update([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'avatar' => $googleUser->avatar,
                ]);
            } else {
                // Cek apakah email sudah terdaftar (user register normal)
                $user = User::where('email', $googleUser->email)->first();
                
                if ($user) {
                    // Link Google account ke existing user
                    $user->update([
                        'google_id' => $googleUser->id,
                        'avatar' => $googleUser->avatar,
                    ]);
                } else {
                    // Create new user dari Google
                    $user = User::create([
                        'name' => $googleUser->name,
                        'email' => $googleUser->email,
                        'google_id' => $googleUser->id,
                        'avatar' => $googleUser->avatar,
                        'password' => null, // No password untuk Google users
                        'email_verified_at' => now(), // Auto verified by Google
                    ]);
                }
            }
            
            // Login user ke aplikasi
            Auth::login($user);
            
            return redirect('/tasks')->with('success', 'Successfully logged in with Google!');
            
        } catch (Exception $e) {
            // Handle error (network, invalid token, etc)
            return redirect('/login')->with('error', 'Failed to login with Google: ' . $e->getMessage());
        }
    }
}
