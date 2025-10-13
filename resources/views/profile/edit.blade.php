@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="glass-card p-8 mt-8">
        <h1 class="text-2xl font-bold mb-4">Edit Profile</h1>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" name="name" value="{{ auth()->user()->name }}" required
                    class="w-full px-3 py-2 border rounded-lg" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ auth()->user()->email }}" required
                    class="w-full px-3 py-2 border rounded-lg" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                <input type="password" name="password" placeholder="Leave blank to keep current"
                    class="w-full px-3 py-2 border rounded-lg" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" placeholder="Confirm new password"
                    class="w-full px-3 py-2 border rounded-lg" />
            </div>

            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('tasks.index') }}" class="text-sm text-gray-600">Back to Tasks</a>
                <button type="submit" class="btn-gradient px-4 py-2 text-white rounded-lg">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection
