<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

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

    public function logout(Request $request)
    {
        $request->session()->forget('is_admin');
        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        $users = User::paginate(15);
        return view('admin.dashboard', compact('users'));
    }

    public function editUser(User $user)
    {
        return view('admin.edit_user', compact('user'));
    }

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
}
