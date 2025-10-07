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
        <form method="GET" action="{{ route('tasks.index') }}">
            <div class="flex flex-col md:flex-row gap-4">
                <!-- Search -->
                <div class="flex-1">
                    <div class="flex gap-2">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Search tasks..." 
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <!-- Filters -->
                <div class="flex flex-wrap gap-2">
                    <!-- Status Filter -->
                    <select name="status" onchange="this.form.submit()" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Tasks</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>

                    <!-- Date Filter (REPLACED Category Filter) -->
                    <select name="date_filter" onchange="this.form.submit()" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Dates</option>
                        <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Today</option>
                        <option value="tomorrow" {{ request('date_filter') == 'tomorrow' ? 'selected' : '' }}>Tomorrow</option>
                        <option value="this_week" {{ request('date_filter') == 'this_week' ? 'selected' : '' }}>This Week</option>
                        <option value="next_week" {{ request('date_filter') == 'next_week' ? 'selected' : '' }}>Next Week</option>
                        <option value="this_month" {{ request('date_filter') == 'this_month' ? 'selected' : '' }}>This Month</option>
                        <option value="overdue" {{ request('date_filter') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                        <option value="no_date" {{ request('date_filter') == 'no_date' ? 'selected' : '' }}>No Date</option>
                    </select>

                    <!-- Sort By Filter -->
                    <select name="sort_by" onchange="this.form.submit()" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="deadline" {{ $sortBy == 'deadline' ? 'selected' : '' }}>Sort by Deadline</option>
                        <option value="priority" {{ $sortBy == 'priority' ? 'selected' : '' }}>Sort by Priority</option>
                    </select>

                    <!-- Sort Direction Filter -->
                    <select name="sort_direction" onchange="this.form.submit()" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="asc" {{ $sortDirection == 'asc' ? 'selected' : '' }}>Ascending</option>
                        <option value="desc" {{ $sortDirection == 'desc' ? 'selected' : '' }}>Descending</option>
                    </select>


                    <a href="{{ route('tasks.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center gap-2">
                        <i class="fas fa-plus"></i> New Task
                    </a>
                </div>
            </div>
        </form>
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
                    <form method="POST" action="{{ route('tasks.toggle-status', $task) }}" class="m-0">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-6 h-6 border-2 rounded-full flex items-center justify-center 
                            {{ $task->status == 'completed' ? 'bg-green-500 border-green-500 text-white' : 'border-gray-300' }} hover:border-green-500 transition-colors">
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
                        <p class="text-gray-600 mt-1 {{ $task->status == 'completed' ? 'line-through' : '' }}">
                            {{ $task->description }}
                        </p>
                        @endif
                        
                        <div class="flex items-center gap-4 mt-2 text-sm text-gray-500">
                            <!-- Deadline with better styling -->
                            @if($task->deadline)
                                @php
                                    $deadline = \Carbon\Carbon::parse($task->deadline);
                                    $today = \Carbon\Carbon::today();
                                    $isOverdue = $deadline->lt($today) && $task->status == 'pending';
                                @endphp
                                <span class="flex items-center gap-1 {{ $isOverdue ? 'text-red-600 font-semibold' : '' }}">
                                    <i class="fas fa-calendar {{ $isOverdue ? 'text-red-500' : '' }}"></i>
                                    {{ $deadline->format('M d, Y') }}
                                    @if($isOverdue)
                                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs ml-2">
                                            Overdue
                                        </span>
                                    @endif
                                </span>
                            @else
                                <span class="flex items-center gap-1 text-gray-400">
                                    <i class="fas fa-calendar-times"></i>
                                    No deadline
                                </span>
                            @endif

                            <!-- Priority -->
                            <span class="capitalize px-2 py-1 rounded-full text-xs 
                                @if($task->priority == 'high') bg-red-100 text-red-800
                                @elseif($task->priority == 'medium') bg-yellow-100 text-yellow-800
                                @else bg-green-100 text-green-800 @endif">
                                {{ $task->priority }} priority
                            </span>

                            <!-- Status -->
                            <span class="text-xs {{ $task->status == 'completed' ? 'text-green-600' : 'text-blue-600' }}">
                                {{ $task->status == 'completed' ? 'Completed' : 'Pending' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center space-x-3">
                    <!-- Edit Button -->
                    <a href="{{ route('tasks.edit', $task) }}" 
                       class="text-blue-600 hover:text-blue-800 transition-colors"
                       title="Edit Task">
                        <i class="fas fa-edit"></i>
                    </a>
                    
                    <!-- Delete Button -->
                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" 
                          class="m-0" 
                          onsubmit="return confirm('Are you sure you want to delete this task?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="text-red-600 hover:text-red-800 transition-colors"
                                title="Delete Task">
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
            <p class="text-gray-500 mt-2">
                @if(request()->has('date_filter') && request('date_filter'))
                    No tasks found for the selected date filter.
                @else
                    Get started by creating your first task!
                @endif
            </p>
            <a href="{{ route('tasks.create') }}" class="inline-block mt-4 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                Create Task
            </a>
        </div>
        @endforelse
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div id="success-message" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transition-opacity duration-300">
        <div class="flex items-center gap-2">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    </div>
    @endif
</div>

<script>
    // Auto-hide success message after 3 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            setTimeout(() => {
                successMessage.style.opacity = '0';
                setTimeout(() => successMessage.remove(), 300);
            }, 3000);
        }
    });
</script>
@endsection