<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * AdminController
 * 
 * Controller untuk mengelola fitur admin
 * Termasuk login admin, manajemen user, dan dashboard admin
 * 
 * @package App\Http\Controllers
 */
class AdminController extends Controller
{
    /**
     * Memproses logout admin
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Menampilkan dashboard admin dengan daftar semua user
     * 
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $users = User::orderBy('id')->paginate(15);
        $adminCount = User::where('role', 'admin')->count();

        return view('admin.dashboard', compact('users', 'adminCount'));
    }

    /**
     * Form create user oleh admin.
     */
    public function createUser()
    {
        return view('admin.create_user');
    }

    /**
     * Simpan user baru oleh admin tanpa login ke akun itu.
     */
    public function storeUser(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:user,admin',
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Account created successfully.');
    }

    /**
     * Menampilkan form edit user
     * 
     * @param User $user
     * @return \Illuminate\View\View
     */
    public function editUser(User $user)
    {
        return view('admin.edit_user', compact('user'));
    }

    /**
     * Mengupdate data user oleh admin
     * 
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateUser(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'role' => 'required|in:user,admin',
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->role = $data['role'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'User updated successfully.');
    }

    /**
     * Menghapus user dan semua task yang dimilikinya
     * 
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteUser(User $user)
    {
        $adminCount = User::where('role', 'admin')->count();

        if ($user->id === Auth::id() && $user->role === 'admin' && $adminCount <= 1) {
            return redirect()->route('admin.dashboard')->with('error', 'Cannot delete your own account because it is the only admin account left.');
        }

        // Delete all user's tasks first (cascade delete)
        $user->tasks()->delete();
        
        // Delete the user
        $user->delete();
        
        return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully.');
    }
}
