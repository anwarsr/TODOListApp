@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto main-panel p-8 space-y-6">
    <div class="flex items-center justify-between flex-wrap gap-3">
        <div>
            <p class="text-xs uppercase tracking-[0.2em] text-slate-500">New Task</p>
            <h1 class="text-3xl font-bold text-slate-900">Add something important to do</h1>
        </div>
        <a href="{{ route('tasks.index') }}" class="ghost-btn flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i>
            Back to tasks
        </a>
    </div>

    <form method="POST" action="{{ route('tasks.store') }}" class="space-y-5">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="md:col-span-2">
                <label class="text-sm font-semibold text-slate-700">Title</label>
                <input id="title" name="title" type="text" value="{{ old('title') }}" class="input-field mt-1" placeholder="e.g. Finish sprint backlog" required>
                @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="text-sm font-semibold text-slate-700">Description</label>
                <textarea id="description" name="description" rows="4" class="input-field mt-1" placeholder="Add more context...">{{ old('description') }}</textarea>
                @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-700">Deadline</label>
                <input id="deadline" name="deadline" type="datetime-local" value="{{ old('deadline') }}" class="input-field mt-1">
                @error('deadline') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-700">Priority</label>
                <select id="priority" name="priority" class="input-field mt-1" required>
                    <option value="">Select priority</option>
                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                </select>
                @error('priority') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-700">Category</label>
                <select name="category_id" class="input-field mt-1">
                    <option value="">No category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_important" id="is_important" value="1" class="w-5 h-5 rounded border-slate-300" {{ old('is_important') ? 'checked' : '' }}>
                <label for="is_important" class="text-sm font-semibold text-slate-700">Mark as important</label>
            </div>
        </div>

        <div class="flex items-center gap-3 pt-4">
            <button type="submit" class="primary-btn flex items-center gap-2">
                <i class="fa-solid fa-plus"></i>
                Create Task
            </button>
            <a href="{{ route('tasks.index') }}" class="ghost-btn">Cancel</a>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deadlineInput = document.getElementById('deadline');
        const now = new Date();
        const localDateTime = now.toISOString().slice(0, 16);
        if (deadlineInput) deadlineInput.min = localDateTime;
    });
</script>
@endsection