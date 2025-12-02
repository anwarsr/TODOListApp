<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

/**
 * SetupPasswordController
 * 
 * Controller untuk mengelola setup password user baru dari Google OAuth
 * User yang register via Google perlu setup password untuk keamanan account
 * 
 * @package App\Http\Controllers
 */
class SetupPasswordController extends Controller
{
    /**
     * Tampilkan halaman setup password
     * 
     * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
     */
    public function show()
    {
        $user = auth()->user();
        
        // Redirect jika user tidak perlu setup password
        if (!$user->needs_password_setup) {
            return redirect('/tasks');
        }
        
        return Inertia::render('auth/setup-password');
    }
    
    /**
     * Proses setup password baru
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        
        // Validasi request
        $request->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);
        
        // Update password dan set flag needs_password_setup menjadi false
        $user->update([
            'password' => Hash::make($request->password),
            'needs_password_setup' => false,
        ]);
        
        return redirect('/tasks')
            ->with('success', 'Password has been set successfully! You can now login with email and password.');
    }
    
    /**
     * User skip setup password (nanti saja)
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
}
