@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-20">
    <div class="glass-card p-8">
        <h1 class="text-2xl font-bold mb-4">Admin Login</h1>

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg mb-4">
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Adminname</label>
                <input type="text" name="adminname" value="" required class="w-full px-3 py-2 border rounded-lg" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required class="w-full px-3 py-2 border rounded-lg" />
            </div>

            <div class="flex justify-end">
                <a href="{{ route('login') }}" class="btn-secondary px-4 py-2 rounded-lg mr-3" aria-label="Back to user login">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <button type="submit" class="btn-gradient px-4 py-2 text-white rounded-lg">Login as Admin</button>
            </div>
        </form>
    </div>
</div>
@endsection
