@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Admin Dashboard</h1>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="btn-secondary px-4 py-2 rounded-lg">Logout Admin</button>
        </form>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="glass-card p-6">
        <h2 class="text-lg font-semibold mb-4">Users</h2>
        <table class="w-full table-auto">
            <thead>
                <tr class="text-left text-sm text-gray-600">
                    <th class="py-2">#</th>
                    <th class="py-2">Name</th>
                    <th class="py-2">Email</th>
                    <th class="py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="border-t">
                    <td class="py-3">{{ $user->id }}</td>
                    <td class="py-3">{{ $user->name }}</td>
                    <td class="py-3">{{ $user->email }}</td>
                    <td class="py-3">
                        <a href="{{ route('admin.users.edit', $user) }}" class="text-indigo-600 hover:underline">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
