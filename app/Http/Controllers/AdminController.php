<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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
     * Menampilkan halaman login admin
     * 
     * @return \Illuminate\View\View
     */
    public function showLogin()
    {
        return view('admin.login');
    }

    /**
     * Memproses login admin dengan kredensial hardcoded
     * Username: admin, Password: admin
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'adminname' => 'required|string',
            'password' => 'required|string',
        ]);

        // Simple hardcoded admin credentials as requested
        if ($data['adminname'] === 'admin' && $data['password'] === 'admin') {
            // mark session as admin
            session(['is_admin' => true]);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['adminname' => 'Invalid admin credentials']);
    }

    /**
     * Memproses logout admin
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $request->session()->forget('is_admin');
        return redirect()->route('admin.login');
    }

    /**
     * Menampilkan dashboard admin dengan daftar semua user
     * 
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $users = User::paginate(15);
        return view('admin.dashboard', compact('users'));
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
            'password' => 'nullable|min:6|confirmed'
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        if (!empty($data['password'])) {
            $user->password = bcrypt($data['password']);
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
        // Delete all user's tasks first (cascade delete)
        $user->tasks()->delete();
        
        // Delete the user
        $user->delete();
        
        return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully.');
    }
}
