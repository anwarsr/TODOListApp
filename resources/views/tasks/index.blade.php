@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8 text-center animate-fade-in-up">
        <h1 class="text-4xl font-bold text-gray-800 mb-3">My Tasks</h1>
        <p class="text-gray-600 text-lg">Stay organized and get things done</p>
    </div>

    

    <!-- Search and Filters -->
    <div class="glass-card p-6 mb-8 animate-slide-in-left">
        <form method="GET" action="{{ route('tasks.index') }}">
            <div class="flex flex-col lg:flex-row gap-6 items-start lg:items-center">
                <!-- Search -->
                <div class="flex-1 w-full">
                    <div class="relative">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-3.5 text-gray-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search tasks..."
                            class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 bg-white/60 backdrop-blur-sm transition-all duration-300 hover:shadow-md">
                    </div>
                </div>

                <!-- Filters -->
                <div class="flex flex-wrap gap-3 w-full lg:w-auto">
                    <!-- Status Filter -->
                    <select name="status" onchange="this.form.submit()"
                        class="px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-white/60 backdrop-blur-sm transition-all duration-300 hover:shadow-md">
                        <option value="">All Tasks</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed
                        </option>
                    </select>

                    <!-- Date Filter -->
                    <select name="date_filter" onchange="this.form.submit()"
                        class="px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-white/60 backdrop-blur-sm transition-all duration-300 hover:shadow-md">
                        <option value="">All Dates</option>
                        <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Today</option>
                        <option value="tomorrow" {{ request('date_filter') == 'tomorrow' ? 'selected' : '' }}>Tomorrow
                        </option>
                        <option value="this_week" {{ request('date_filter') == 'this_week' ? 'selected' : '' }}>This
                            Week</option>
                        <option value="next_week" {{ request('date_filter') == 'next_week' ? 'selected' : '' }}>Next
                            Week</option>
                        <option value="this_month" {{ request('date_filter') == 'this_month' ? 'selected' : '' }}>This
                            Month</option>
                        <option value="overdue" {{ request('date_filter') == 'overdue' ? 'selected' : '' }}>Overdue
                        </option>
                        <option value="no_date" {{ request('date_filter') == 'no_date' ? 'selected' : '' }}>No Date
                        </option>
                    </select>

                    <!-- Sort By Filter -->
                    <select name="sort_by" onchange="this.form.submit()"
                        class="px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-white/60 backdrop-blur-sm transition-all duration-300 hover:shadow-md">
                        <option value="deadline" {{ request('sort_by', 'deadline') == 'deadline' ? 'selected' : '' }}>
                            Sort by Deadline</option>
                        <option value="priority" {{ request('sort_by') == 'priority' ? 'selected' : '' }}>Sort by
                            Priority</option>
                        <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Sort by
                            Created</option>
                    </select>

                    <!-- Sort Direction Filter -->
                    <select name="sort_direction" onchange="this.form.submit()"
                        class="px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-white/60 backdrop-blur-sm transition-all duration-300 hover:shadow-md">
                        <option value="asc" {{ request('sort_direction', 'asc') == 'asc' ? 'selected' : '' }}>Ascending
                        </option>
                        <option value="desc" {{ request('sort_direction') == 'desc' ? 'selected' : '' }}>Descending
                        </option>
                    </select>

                    <!-- New Task Button -->
                    <a href="{{ route('tasks.create') }}"
                        class="btn-gradient text-white px-6 py-3.5 rounded-xl font-medium flex items-center gap-2 transition-all duration-300 hover:shadow-lg transform hover:scale-105">
                        <i class="fa-solid fa-plus"></i> New Task
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Tasks List -->
    <div class="space-y-4">
        @forelse($tasks as $index => $task)
        <div class="glass-card p-6 task-item animate-fade-in-up hover-lift"
            style="animation-delay: {{ $index * 0.1 }}s;
                    border-left: 4px solid @if($task->priority == 'high') #ef4444 @elseif($task->priority == 'medium') #f59e0b @else #10b981 @endif">

            <div class="flex items-center justify-between">
                <div class="flex items-start space-x-4 flex-1">
                    <!-- Checkbox -->
                    <form method="POST" action="{{ route('tasks.toggle-status', $task) }}" class="m-0 mt-1">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="w-6 h-6 border-2 rounded-full flex items-center justify-center transition-all duration-300 transform hover:scale-110
                                    {{ $task->status == 'completed' ? 'bg-green-500 border-green-500 text-white shadow-md' : 'border-gray-300 hover:border-green-400 hover:shadow-sm' }}">
                            @if($task->status == 'completed')
                            <i class="fa-solid fa-check text-xs"></i>
                            @endif
                        </button>
                    </form>

                    <!-- Task Details -->
                    <div class="flex-1">
                        <h3
                            class="text-xl font-semibold {{ $task->status == 'completed' ? 'line-through text-gray-500' : 'text-gray-800' }} mb-2">
                            {{ $task->title }}
                        </h3>

                        @if($task->description)
                        <p
                            class="text-gray-600 text-sm {{ $task->status == 'completed' ? 'line-through' : '' }} mb-3 leading-relaxed">
                            {{ $task->description }}
                        </p>
                        @endif

                        <div class="flex items-center gap-4 flex-wrap">
                            <!-- Deadline -->
                            @if($task->deadline)
                            @php
                            $deadline = \Carbon\Carbon::parse($task->deadline);
                            $today = \Carbon\Carbon::today();
                            $isOverdue = $deadline->lt($today) && $task->status == 'pending';
                            @endphp
                            <span
                                class="flex items-center gap-2 text-sm font-medium {{ $isOverdue ? 'text-red-500' : 'text-gray-600' }}">
                                <i class="fa-regular fa-calendar {{ $isOverdue ? 'text-red-400' : '' }}"></i>
                                {{ $deadline->format('M d, Y') }}
                                @if($isOverdue)
                                <span class="bg-red-100 text-red-700 px-2.5 py-1 rounded-full text-xs font-semibold">
                                    Overdue
                                </span>
                                @endif
                            </span>
                            @else
                            <span class="flex items-center gap-2 text-sm text-gray-400 font-medium">
                                <i class="fa-regular fa-calendar-times"></i>
                                No deadline
                            </span>
                            @endif

                            <!-- Priority -->
                            <span class="px-3 py-1.5 rounded-full text-xs font-semibold
                                @if($task->priority == 'high') bg-red-100 text-red-700 border border-red-200
                                @elseif($task->priority == 'medium') bg-yellow-100 text-yellow-700 border border-yellow-200
                                @else bg-green-100 text-green-700 border border-green-200 @endif">
                                <i class="fa-solid fa-flag mr-1"></i>
                                {{ $task->priority }} priority
                            </span>

                            <!-- Status -->
                            <span
                                class="px-3 py-1.5 rounded-full text-xs font-semibold
                                {{ $task->status == 'completed' ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-blue-100 text-blue-700 border border-blue-200' }}">
                                <i
                                    class="fa-solid {{ $task->status == 'completed' ? 'fa-check-circle' : 'fa-clock' }} mr-1"></i>
                                {{ $task->status == 'completed' ? 'Completed' : 'Pending' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center space-x-4 ml-4">
                    <!-- Edit Button -->
                    <a href="{{ route('tasks.edit', $task) }}"
                        class="text-indigo-500 hover:text-indigo-700 transition-all duration-200 transform hover:scale-125 p-2 rounded-lg hover:bg-indigo-50"
                        title="Edit Task">
                        <i class="fa-regular fa-pen-to-square text-lg"></i>
                    </a>

                    <!-- Delete Button -->
                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="m-0 delete-task-form"
                        data-task-title="{{ addslashes($task->title) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="text-red-500 hover:text-red-700 transition-all duration-200 transform hover:scale-125 p-2 rounded-lg hover:bg-red-50"
                            title="Delete Task">
                            <i class="fa-regular fa-trash-can text-lg"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="glass-card p-12 text-center animate-fade-in-up">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                <i class="fa-regular fa-clipboard text-4xl text-gray-400"></i>
            </div>
            <h3 class="text-2xl font-semibold text-gray-700 mb-3">No tasks found</h3>
            <p class="text-gray-500 mb-8 text-lg">
                @if(request()->has('date_filter') && request('date_filter'))
                No tasks found for the selected date filter.
                @else
                Get started by creating your first task!
                @endif
            </p>
            <a href="{{ route('tasks.create') }}"
                class="btn-gradient text-white px-8 py-4 rounded-xl font-semibold text-lg inline-flex items-center gap-3 transition-all duration-300 hover:shadow-xl transform hover:scale-105">
                <i class="fa-solid fa-plus"></i> Create Your First Task
            </a>
        </div>
        @endforelse
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div
        class="fixed bottom-6 right-6 glass-card px-6 py-4 text-green-700 font-semibold animate-fade-in-up border-l-4 border-green-400">
        <div class="flex items-center gap-3">
            <i class="fa-solid fa-check-circle text-green-500 text-xl"></i>
            <span>{{ session('success') }}</span>
        </div>
    </div>
    @endif
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {

        if (window.tasksPageInitialized) return;
        window.tasksPageInitialized = true;

    const successMessages = document.querySelectorAll('.fixed.bottom-4, .fixed.bottom-6');
    if (successMessages.length > 1) {
        for (let i = 1; i < successMessages.length; i++) {
            successMessages[i].remove();
        }
    }

        // Add interactive hover effects to task cards
        const taskCards = document.querySelectorAll('.task-item');
        taskCards.forEach(card => {
            card.addEventListener('mouseenter', function () {
                this.style.transform = 'translateY(-4px)';
                this.style.boxShadow = '0 12px 40px rgba(0, 0, 0, 0.15)';
            });

            card.addEventListener('mouseleave', function () {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '';
            });
        });

        // Auto-hide success message after 5 seconds - IMPROVED
        if (successMessages.length > 0) {
        const message = successMessages[0];
        if (!message.dataset.autoHidden) {
            message.dataset.autoHidden = 'true';
            
            setTimeout(() => {
                message.style.transition = 'opacity 0.3s ease';
                message.style.opacity = '0';
                setTimeout(() => {
                    if (message.parentNode) {
                        message.remove();
                    }
                }, 300);
            }, 5000);
        }
    }
        });

        // Add focus effects to form elements
        const inputs = document.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.addEventListener('focus', function () {
                if (this.parentElement) this.parentElement.classList.add('ring-2', 'ring-indigo-200', 'rounded-xl');
            });

            input.addEventListener('blur', function () {
                if (this.parentElement) this.parentElement.classList.remove('ring-2', 'ring-indigo-200', 'rounded-xl');
            });
        });

        // (No modal handlers needed; profile editing moved to dedicated page)

        // Delete confirmation UI is provided by a shared partial included in the main layout.

</script>
@endsection
