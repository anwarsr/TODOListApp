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
                    <td class="py-3 flex items-center gap-3">
                        <a href="{{ route('admin.users.edit', $user) }}" 
                           class="text-indigo-600 hover:text-indigo-800 transition-colors"
                           title="Edit User">
                            <i class="fa-regular fa-pen-to-square"></i> Edit
                        </a>
                        <form method="POST" action="{{ route('admin.users.delete', $user) }}" 
                              class="delete-user-form inline-block"
                              data-user-name="{{ $user->name }}"
                              data-user-email="{{ $user->email }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="text-red-600 hover:text-red-800 transition-colors"
                                    title="Delete User">
                                <i class="fa-regular fa-trash-can"></i> Delete
                            </button>
                        </form>
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
