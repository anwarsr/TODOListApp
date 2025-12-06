@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto main-panel p-8 space-y-6">
    <div class="flex items-center justify-between flex-wrap gap-3">
        <div>
            <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Edit Task</p>
            <h1 class="text-3xl font-bold text-slate-900">Update details and keep on track</h1>
        </div>
        <a href="{{ route('tasks.index') }}" class="ghost-btn flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i>
            Back to tasks
        </a>
    </div>

    <form method="POST" action="{{ route('tasks.update', $task) }}" class="space-y-5">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="md:col-span-2">
                <label class="text-sm font-semibold text-slate-700">Title</label>
                <input id="title" name="title" type="text" value="{{ old('title', $task->title) }}" class="input-field mt-1" required>
                @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="text-sm font-semibold text-slate-700">Description</label>
                <textarea id="description" name="description" rows="4" class="input-field mt-1">{{ old('description', $task->description) }}</textarea>
                @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-700">Deadline</label>
                <input id="deadline" name="deadline" type="datetime-local" value="{{ old('deadline', $task->deadline ? $task->deadline->format('Y-m-d\TH:i') : '') }}" class="input-field mt-1">
                @error('deadline') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-700">Priority</label>
                <select id="priority" name="priority" class="input-field mt-1" required>
                    <option value="">Select priority</option>
                    <option value="low" {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ old('priority', $task->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ old('priority', $task->priority) == 'high' ? 'selected' : '' }}>High</option>
                </select>
                @error('priority') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-700">Category</label>
                <select name="category_id" class="input-field mt-1">
                    <option value="">No category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $task->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_important" id="is_important" value="1" class="w-5 h-5 rounded border-slate-300" {{ old('is_important', $task->is_important) ? 'checked' : '' }}>
                <label for="is_important" class="text-sm font-semibold text-slate-700">Mark as important</label>
            </div>
        </div>

        <div class="flex items-center gap-3 pt-4">
            <button type="submit" class="primary-btn flex items-center gap-2">
                <i class="fa-solid fa-save"></i>
                Update Task
            </button>
            <a href="{{ route('tasks.index') }}" class="ghost-btn">Cancel</a>
        </div>
    </form>

    <div class="pt-6 border-t border-red-200">
        <div class="p-5 rounded-2xl bg-red-50 border border-red-200">
            <h3 class="text-lg font-semibold text-red-800 mb-2 flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation"></i>
                Danger Zone
            </h3>
            <p class="text-red-600 mb-4">Once you delete a task, there is no going back.</p>
            <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="delete-task-form" data-task-title="{{ addslashes($task->title) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-xl font-semibold flex items-center gap-2">
                    <i class="fa-solid fa-trash-can"></i>
                    Delete Task
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deadlineInput = document.getElementById('deadline');
        if (deadlineInput && !deadlineInput.value) {
            const now = new Date();
            deadlineInput.min = now.toISOString().slice(0, 16);
        }
    });
</script>
@endsection