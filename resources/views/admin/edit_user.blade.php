@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-8">
    <div class="glass-card p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-indigo-700">Admin</p>
                <h1 class="text-xl font-semibold">Edit User</h1>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-slate-600 hover:text-slate-800">Back</a>
        </div>

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg mb-4">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" name="name" value="{{ $user->name }}" required class="w-full px-3 py-2 border rounded-lg" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ $user->email }}" required class="w-full px-3 py-2 border rounded-lg" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                <input type="password" name="password" placeholder="Leave blank to keep current" class="w-full px-3 py-2 border rounded-lg" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" placeholder="Confirm new password" class="w-full px-3 py-2 border rounded-lg" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <select name="role" class="w-full px-3 py-2 border rounded-lg" required>
                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div class="flex justify-end items-center gap-3">
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-700">Cancel</a>
                <button type="submit" class="btn-gradient px-4 py-2 rounded-lg text-white">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection
