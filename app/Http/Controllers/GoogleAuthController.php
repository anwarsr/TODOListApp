<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Exception;
use App\Models\Category;

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
            /** @var SocialiteUser $googleUser */
            $googleUser = Socialite::driver('google')->user();

            $googleId = $googleUser->getId();
            $googleName = $googleUser->getName();
            $googleEmail = $googleUser->getEmail();
            $googleAvatar = $googleUser->getAvatar();
            
            // Cek apakah user sudah pernah login dengan Google (by google_id)
            $user = User::where('google_id', $googleId)->first();
            
            if ($user) {
                // User sudah ada, update info jika ada perubahan
                $user->update([
                    'name' => $googleName,
                    'email' => $googleEmail,
                    'avatar' => $googleAvatar,
                ]);
            } else {
                // Cek apakah email sudah terdaftar (user register normal)
                $user = User::where('email', $googleEmail)->first();
                
                if ($user) {
                    // Link Google account ke existing user
                    $user->update([
                        'google_id' => $googleId,
                        'avatar' => $googleAvatar,
                    ]);
                } else {
                    // Create new user dari Google
                    $user = User::create([
                        'name' => $googleName,
                        'email' => $googleEmail,
                        'google_id' => $googleId,
                        'avatar' => $googleAvatar,
                        'password' => bcrypt('12345678'), // Default password
                        'email_verified_at' => now(), // Auto verified by Google
                        'role' => 'user',
                    ]);
                }
            }

            // Ensure legacy users without role default to user
            if (!$user->role) {
                $user->role = 'user';
                $user->save();
            }

            $user->ensureDefaultCategories();
            
            // Login user ke aplikasi
            Auth::login($user);
            
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Successfully logged in with Google!');
            }

            return redirect('/tasks')->with('success', 'Successfully logged in with Google!');
            
        } catch (Exception $e) {
            // Handle error (network, invalid token, etc)
            return redirect('/login')->with('error', 'Failed to login with Google: ' . $e->getMessage());
        }
    }
}
