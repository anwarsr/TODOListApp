@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-10 space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-sm uppercase tracking-[0.35em] text-indigo-700">GenzTask</p>
            <h1 class="text-3xl font-bold text-slate-900">Admin Dashboard</h1>
            <p class="text-slate-600">Focus on what matters — manage users and roles.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.users.create') }}" class="px-4 py-2 rounded-lg bg-gradient-to-r from-indigo-500 to-sky-500 text-white shadow hover:shadow-lg transition">Create account</a>
            <a href="{{ route('profile.edit') }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-700 hover:bg-white shadow-sm">Edit my profile</a>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-700 hover:bg-white shadow-sm">Logout Admin</button>
            </form>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 p-3 rounded">{{ session('success') }}</div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-700 p-3 rounded">{{ session('error') }}</div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="p-4 rounded-xl bg-white/70 shadow border border-white/60">
            <p class="text-xs uppercase tracking-wide text-slate-500">Total Users</p>
            <p class="text-3xl font-bold text-slate-900">{{ $users->total() }}</p>
        </div>
        <div class="p-4 rounded-xl bg-white/70 shadow border border-white/60">
            <p class="text-xs uppercase tracking-wide text-slate-500">Admins</p>
            <p class="text-3xl font-bold text-indigo-600">{{ $adminCount }}</p>
        </div>
        <div class="p-4 rounded-xl bg-white/70 shadow border border-white/60">
            <p class="text-xs uppercase tracking-wide text-slate-500">Users</p>
            <p class="text-3xl font-bold text-sky-600">{{ $users->total() - $adminCount }}</p>
        </div>
    </div>

    <div class="glass-card p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold">Users</h2>
            <span class="text-sm text-slate-500">Role-aware management</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="text-left text-sm text-gray-600">
                        <th class="py-2">#</th>
                        <th class="py-2">Name</th>
                        <th class="py-2">Email</th>
                        <th class="py-2">Role</th>
                        <th class="py-2 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr class="border-t">
                        <td class="py-3">{{ $user->id }}</td>
                        <td class="py-3 font-medium text-slate-900">{{ $user->name }}</td>
                        <td class="py-3 text-slate-700">{{ $user->email }}</td>
                        <td class="py-3">
                            <span class="px-3 py-1 text-xs rounded-full {{ $user->role === 'admin' ? 'bg-indigo-100 text-indigo-700' : 'bg-sky-100 text-sky-700' }}">{{ ucfirst($user->role ?? 'user') }}</span>
                        </td>
                        <td class="py-3 text-right space-x-3">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-800 text-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.users.delete', $user) }}" 
                                  class="delete-user-form inline-block"
                                  data-user-name="{{ $user->name }}"
                                  data-user-email="{{ $user->email }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-800 text-sm"
                                        title="Delete User">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>

<!-- Delete User Confirmation Modal -->
<div id="deleteUserModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-xl w-11/12 sm:w-96 p-6">
        <h3 class="text-lg font-semibold mb-2 text-red-600">Delete User?</h3>
        <p id="deleteUserMessage" class="text-sm text-gray-600 mb-4">Are you sure you want to delete this user?</p>
        <div class="flex justify-end gap-3">
            <button id="cancelDeleteUserBtn" class="px-4 py-2 rounded-lg btn-secondary">Cancel</button>
            <button id="confirmDeleteUserBtn" class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">Delete User</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteUserForms = document.querySelectorAll('.delete-user-form');
        if (deleteUserForms.length === 0) return;

        const deleteUserModal = document.getElementById('deleteUserModal');
        const deleteUserMessage = document.getElementById('deleteUserMessage');
        const cancelDeleteUserBtn = document.getElementById('cancelDeleteUserBtn');
        const confirmDeleteUserBtn = document.getElementById('confirmDeleteUserBtn');

        let activeForm = null;

        deleteUserForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                activeForm = this;
                const userName = this.dataset.userName || 'this user';
                const userEmail = this.dataset.userEmail || '';
                deleteUserMessage.textContent = `Are you sure you want to delete user "${userName}" (${userEmail})? This action cannot be undone. All their tasks and data will be permanently deleted.`;
                deleteUserModal.classList.remove('hidden');
            });
        });

        cancelDeleteUserBtn.addEventListener('click', function () {
            deleteUserModal.classList.add('hidden');
            activeForm = null;
        });

        confirmDeleteUserBtn.addEventListener('click', function () {
            if (activeForm) {
                activeForm.submit();
            }
        });

        // close modal on outside click
        deleteUserModal.addEventListener('click', function (e) {
            if (e.target === deleteUserModal) {
                deleteUserModal.classList.add('hidden');
                activeForm = null;
            }
        });
    });
</script>
@endsection
