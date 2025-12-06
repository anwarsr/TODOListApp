@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mt-10">
    <div class="glass-card p-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-indigo-700">Admin</p>
                <h1 class="text-2xl font-bold text-slate-900">Create Account</h1>
                <p class="text-slate-600 text-sm">Create a new user or admin without logging into it.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-slate-600 hover:text-slate-800">Back</a>
        </div>

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg mb-4">
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-3 py-2 border rounded-lg" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-3 py-2 border rounded-lg" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required class="w-full px-3 py-2 border rounded-lg" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" required class="w-full px-3 py-2 border rounded-lg" />
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <select name="role" class="w-full px-3 py-2 border rounded-lg" required>
                    <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-700">Cancel</a>
                <button type="submit" class="px-4 py-2 rounded-lg bg-gradient-to-r from-indigo-500 to-sky-500 text-white shadow hover:shadow-lg">Create Account</button>
            </div>
        </form>
    </div>
</div>
@endsection
