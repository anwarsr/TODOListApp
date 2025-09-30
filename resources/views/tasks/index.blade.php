@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">My Tasks</h1>
        <p class="text-gray-600">Stay organized and get things done</p>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <form method="GET" class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search tasks..." 
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>

            <!-- Filters -->
            <div class="flex gap-2">
                <select name="status" onchange="this.form.submit()" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Tasks</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>

                <select name="category_id" onchange="this.form.submit()" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>

                <a href="{{ route('tasks.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center gap-2">
                    <i class="fas fa-plus"></i> New Task
                </a>
            </div>
        </div>
    </div>

    <!-- Tasks List -->
    <div class="space-y-4">
        @forelse($tasks as $task)
        <div class="bg-white rounded-lg shadow p-6 border-l-4 
            @if($task->priority == 'high') border-red-500 
            @elseif($task->priority == 'medium') border-yellow-500 
            @else border-green-500 @endif">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4 flex-1">
                    <!-- Checkbox -->
                    <form method="POST" action="{{ route('tasks.toggle-status', $task) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-6 h-6 border-2 rounded-full flex items-center justify-center 
                            {{ $task->status == 'completed' ? 'bg-green-500 border-green-500 text-white' : 'border-gray-300' }}">
                            @if($task->status == 'completed')
                            <i class="fas fa-check text-xs"></i>
                            @endif
                        </button>
                    </form>

                    <!-- Task Details -->
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold {{ $task->status == 'completed' ? 'line-through text-gray-500' : 'text-gray-900' }}">
                            {{ $task->title }}
                        </h3>
                        @if($task->description)
                        <p class="text-gray-600 mt-1">{{ $task->description }}</p>
                        @endif
                        
                        <div class="flex items-center gap-4 mt-2 text-sm text-gray-500">
                            @if($task->deadline)
                            <span class="flex items-center gap-1">
                                <i class="fas fa-calendar"></i>
                                {{ $task->deadline->format('M d, Y') }}
                            </span>
                            @endif
                            
                            @if($task->category)
                            <span class="flex items-center gap-1">
                                <i class="fas fa-tag" style="color: {{ $task->category->color }}"></i>
                                {{ $task->category->name }}
                            </span>
                            @endif

                            <span class="capitalize {{ $task->priority == 'high' ? 'text-red-500' : ($task->priority == 'medium' ? 'text-yellow-500' : 'text-green-500') }}">
                                {{ $task->priority }} priority
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center space-x-2">
                    <a href="{{ route('tasks.edit', $task) }}" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <i class="fas fa-clipboard-list text-4xl text-gray-400 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-600">No tasks found</h3>
            <p class="text-gray-500 mt-2">Get started by creating your first task!</p>
            <a href="{{ route('tasks.create') }}" class="inline-block mt-4 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                Create Task
            </a>
        </div>
        @endforelse
    </div>
</div>
@endsection