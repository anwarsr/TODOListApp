@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-8">
    <div class="glass-card p-6">
        <h1 class="text-xl font-semibold mb-4">Edit User</h1>

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

            <div class="flex justify-between items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-600">Back to dashboard</a>
                <button type="submit" class="btn-gradient px-4 py-2 rounded-lg text-white">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection
