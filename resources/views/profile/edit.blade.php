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
                <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('tasks.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700 underline">Back to {{ auth()->user()->role === 'admin' ? 'Dashboard' : 'Tasks' }}</a>
                <button type="submit" class="px-5 py-2.5 rounded-lg font-semibold text-white bg-indigo-600 hover:bg-indigo-700 shadow-md transition">Save Changes</button>
            </div>
        </form>

        <!-- Delete Account Section -->
        <div class="mt-8 pt-6 border-t border-red-200">
            <div class="bg-red-50 border border-red-200 rounded-xl p-6">
                <form method="POST" action="{{ route('profile.delete') }}" class="delete-account-form"
                    data-account-name="{{ auth()->user()->name }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="bg-red-600 text-white px-6 py-3 rounded-xl font-semibold flex items-center gap-2 transition-all duration-300 hover:bg-red-700 hover:shadow-lg transform hover:scale-105">
                        <i class="fa-solid fa-user-slash"></i>
                        Delete My Account
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Confirmation Modal -->
<div id="deleteAccountModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-xl w-11/12 sm:w-96 p-6">
        <h3 class="text-lg font-semibold mb-2 text-red-600">Delete Account?</h3>
        <p id="deleteAccountMessage" class="text-sm text-gray-600 mb-4">This action cannot be undone. All your data will be permanently deleted.</p>
        <div class="flex justify-end gap-3">
            <button id="cancelDeleteAccountBtn" class="px-4 py-2 rounded-lg btn-secondary">Cancel</button>
            <button id="confirmDeleteAccountBtn" class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">Delete Account</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteAccountForm = document.querySelector('.delete-account-form');
        if (!deleteAccountForm) return;

        const deleteAccountModal = document.getElementById('deleteAccountModal');
        const deleteAccountMessage = document.getElementById('deleteAccountMessage');
        const cancelDeleteAccountBtn = document.getElementById('cancelDeleteAccountBtn');
        const confirmDeleteAccountBtn = document.getElementById('confirmDeleteAccountBtn');

        let activeForm = null;

        deleteAccountForm.addEventListener('submit', function (e) {
            e.preventDefault();
            activeForm = this;
            const name = this.dataset.accountName || 'your account';
            deleteAccountMessage.textContent = `Are you sure you want to delete your account (${name})? This action cannot be undone. All your tasks and data will be permanently deleted.`;
            deleteAccountModal.classList.remove('hidden');
        });

        cancelDeleteAccountBtn.addEventListener('click', function () {
            deleteAccountModal.classList.add('hidden');
            activeForm = null;
        });

        confirmDeleteAccountBtn.addEventListener('click', function () {
            if (activeForm) {
                activeForm.submit();
            }
        });

        // close modal on outside click
        deleteAccountModal.addEventListener('click', function (e) {
            if (e.target === deleteAccountModal) {
                deleteAccountModal.classList.add('hidden');
                activeForm = null;
            }
        });
    });
</script>
@endsection
