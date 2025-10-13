@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="text-center mb-8 animate-fade-in-up">
        <h1 class="text-4xl font-bold text-gray-800 mb-3">Create New Task</h1>
        <p class="text-gray-600 text-lg">Add a new task to your todo list</p>
    </div>

    <!-- Form Card -->
    <div class="glass-card p-8 animate-slide-in-left">
        <form method="POST" action="{{ route('tasks.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Title Input -->
                <div class="lg:col-span-2 animate-fade-in-up" style="animation-delay: 0.1s;">
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                        Task Title <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <i class="fa-solid fa-heading absolute left-4 top-4 text-gray-400"></i>
                        <input id="title" name="title" type="text" 
                               value="{{ old('title') }}"
                               class="w-full pl-12 pr-4 py-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 bg-white/60 backdrop-blur-sm transition-all duration-300 hover:shadow-md"
                               placeholder="Enter task title"
                               required>
                    </div>
                    @error('title')
                        <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description Input -->
                <div class="lg:col-span-2 animate-fade-in-up" style="animation-delay: 0.2s;">
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                        Description
                    </label>
                    <div class="relative">
                        <i class="fa-solid fa-align-left absolute left-4 top-4 text-gray-400"></i>
                        <textarea id="description" name="description" rows="4"
                                  class="w-full pl-12 pr-4 py-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 bg-white/60 backdrop-blur-sm transition-all duration-300 hover:shadow-md resize-none"
                                  placeholder="Describe your task...">{{ old('description') }}</textarea>
                    </div>
                    @error('description')
                        <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deadline Input -->
                <div class="animate-fade-in-up" style="animation-delay: 0.3s;">
                    <label for="deadline" class="block text-sm font-semibold text-gray-700 mb-2">
                        Deadline
                    </label>
                    <div class="relative">
                        <i class="fa-regular fa-calendar absolute left-4 top-4 text-gray-400"></i>
                        <input id="deadline" name="deadline" type="datetime-local" 
                               value="{{ old('deadline') }}"
                               class="w-full pl-12 pr-4 py-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 bg-white/60 backdrop-blur-sm transition-all duration-300 hover:shadow-md">
                    </div>
                    @error('deadline')
                        <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Priority Input -->
                <div class="animate-fade-in-up" style="animation-delay: 0.4s;">
                    <label for="priority" class="block text-sm font-semibold text-gray-700 mb-2">
                        Priority <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <i class="fa-solid fa-flag absolute left-4 top-4 text-gray-400"></i>
                        <select id="priority" name="priority" 
                                class="w-full pl-12 pr-4 py-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 bg-white/60 backdrop-blur-sm transition-all duration-300 hover:shadow-md appearance-none"
                                required>
                            <option value="">Select Priority</option>
                            <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }} class="text-green-600">Low</option>
                            <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }} class="text-yellow-600">Medium</option>
                            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }} class="text-red-600">High</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-4 top-4 text-gray-400 pointer-events-none"></i>
                    </div>
                    @error('priority')
                        <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Priority Indicator -->
            <div class="animate-fade-in-up" style="animation-delay: 0.5s;">
                <div class="flex items-center gap-4 mt-2 text-sm text-gray-600">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <span>Low - Normal priority tasks</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                        <span>Medium - Important tasks</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                        <span>High - Urgent tasks</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-end pt-6 border-t border-gray-200 mt-8 animate-fade-in-up" style="animation-delay: 0.6s;">
                <a href="{{ route('tasks.index') }}" 
                   class="btn-secondary px-8 py-4 rounded-xl font-semibold text-gray-700 flex items-center justify-center gap-2 transition-all duration-300 hover:shadow-lg transform hover:scale-105 order-2 sm:order-1">
                    <i class="fa-solid fa-arrow-left"></i>
                    Back to Tasks
                </a>
                <button type="submit" 
                        class="btn-gradient text-white px-8 py-4 rounded-xl font-semibold flex items-center justify-center gap-2 transition-all duration-300 hover:shadow-lg transform hover:scale-105 order-1 sm:order-2">
                    <i class="fa-solid fa-plus"></i>
                    Create Task
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add real-time priority indicator
        const prioritySelect = document.getElementById('priority');
        const priorityIndicator = document.createElement('div');
        priorityIndicator.className = 'absolute right-12 top-4 w-3 h-3 rounded-full';
        prioritySelect.parentElement.appendChild(priorityIndicator);

        function updatePriorityIndicator() {
            const value = prioritySelect.value;
            if (value === 'low') {
                priorityIndicator.className = 'absolute right-12 top-4 w-3 h-3 rounded-full bg-green-500';
            } else if (value === 'medium') {
                priorityIndicator.className = 'absolute right-12 top-4 w-3 h-3 rounded-full bg-yellow-500';
            } else if (value === 'high') {
                priorityIndicator.className = 'absolute right-12 top-4 w-3 h-3 rounded-full bg-red-500';
            } else {
                priorityIndicator.className = 'absolute right-12 top-4 w-3 h-3 rounded-full bg-gray-400';
            }
        }

        prioritySelect.addEventListener('change', updatePriorityIndicator);
        updatePriorityIndicator(); // Initial update

        // Add focus effects
        const inputs = document.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('ring-2', 'ring-indigo-200', 'rounded-xl');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('ring-2', 'ring-indigo-200', 'rounded-xl');
            });
        });

        // Set min datetime for deadline to current time
        const now = new Date();
        const localDateTime = now.toISOString().slice(0, 16);
        document.getElementById('deadline').min = localDateTime;
    });
</script>
@endsection