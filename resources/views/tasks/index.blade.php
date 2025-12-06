@extends('layouts.app')

@section('content')
<div class="app-shell">
    <aside class="sidebar-panel p-5 space-y-5">
        <div class="space-y-3">
            <div class="px-1 text-[11px] uppercase tracking-[0.2em] text-slate-800 drop-shadow-sm">
                {{ \Carbon\Carbon::now()->isoFormat('dddd, DD MMMM YYYY') }}
            </div>
            <div class="p-4 rounded-2xl bg-white/80 border border-white/60 shadow-inner space-y-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-lg font-bold flex-none overflow-hidden shadow-sm">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0 flex-1 space-y-0.5">
                        <p class="text-base font-bold text-slate-900 leading-tight break-words">{{ Auth::user()->name }}</p>
                        <p class="text-[12px] text-slate-600 leading-snug break-words">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <a href="{{ route('profile.edit') }}" class="ghost-btn flex items-center justify-center text-base py-2" title="Edit Profile">
                        <i class="fa-solid fa-user-gear"></i>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="primary-btn w-full flex items-center justify-center text-base py-2" title="Logout">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="space-y-2">
            <a href="{{ route('tasks.index', array_merge(request()->except('page'), ['category' => 'all'])) }}"
                class="category-item {{ $selectedCategory === 'all' ? 'is-active' : '' }}">
                <div class="flex items-center gap-3">
                    <i class="fa-regular fa-circle-check text-indigo-500"></i>
                    <span class="font-semibold">All Tasks</span>
                </div>
                <span class="text-xs font-bold text-slate-600">{{ $counts['all'] ?? 0 }}</span>
            </a>

            <a href="{{ route('tasks.index', array_merge(request()->except('page'), ['category' => 'important'])) }}"
                class="category-item {{ $selectedCategory === 'important' ? 'is-active' : '' }}">
                <div class="flex items-center gap-3">
                    <i class="fa-regular fa-star text-amber-500"></i>
                    <span class="font-semibold">Important</span>
                </div>
                <span class="text-xs font-bold text-slate-600">{{ $counts['important'] ?? 0 }}</span>
            </a>
        </div>

        <div class="pt-2 space-y-2">
            <p class="text-xs uppercase text-slate-500 tracking-[0.24em]">My Categories</p>
            @forelse($categories as $category)
                <div class="category-item {{ (string)$selectedCategory === (string)$category->id ? 'is-active' : '' }} flex-col items-start">
                    <div class="flex items-center w-full gap-2">
                        <a href="{{ route('tasks.index', array_merge(request()->except('page'), ['category' => $category->id])) }}" class="flex items-center gap-3 flex-1">
                            <span class="w-3 h-3 rounded-full flex-none" style="background: {{ $category->color }}"></span>
                            <span class="font-semibold break-words">{{ $category->name }}</span>
                        </a>
                        <span class="text-xs font-bold text-slate-600 flex-none">{{ $category->tasks_count }}</span>
                        <button type="button" class="text-slate-400 hover:text-indigo-600 flex-none" data-edit-toggle="category-{{ $category->id }}" title="Edit category">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </button>
                        <form method="POST" action="{{ route('categories.destroy', $category) }}" class="m-0 flex-none" data-confirm="Delete category {{ addslashes($category->name) }}? Tasks will stay uncategorized.">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-slate-400 hover:text-red-500" title="Delete category">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                    @if($category->description)
                        <p class="text-xs text-slate-500 mt-1 ml-6 break-words">{{ $category->description }}</p>
                    @endif
                    <form method="POST" action="{{ route('categories.update', $category) }}" class="mt-2 w-full hidden" data-edit-form="category-{{ $category->id }}">
                        @csrf
                        @method('PATCH')
                        <div class="flex flex-col gap-2">
                            <input type="text" name="name" value="{{ $category->name }}" class="input-field text-sm" required>
                            <textarea name="description" rows="2" class="input-field text-sm">{{ $category->description }}</textarea>
                            <div class="flex items-center gap-3">
                                <input type="color" name="color" value="{{ $category->color }}" class="h-9 w-14 rounded-lg border border-slate-200">
                                <div class="flex gap-2">
                                    <button type="submit" class="primary-btn text-sm">Save</button>
                                    <button type="button" class="ghost-btn text-sm" data-edit-cancel="category-{{ $category->id }}">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @empty
                <p class="text-sm text-slate-500">No custom categories yet.</p>
            @endforelse
        </div>

        <div class="pt-2">
            <form method="POST" action="{{ route('categories.store') }}" class="space-y-3">
                @csrf
                <div>
                    <label class="text-xs font-semibold text-slate-600">New Category</label>
                    <input type="text" name="name" class="input-field mt-1" placeholder="e.g. School" required>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600">Short Description (optional)</label>
                    <textarea name="description" rows="2" class="input-field mt-1 text-sm">Short description...</textarea>
                </div>
                <div class="flex items-center gap-3">
                    <label class="text-xs font-semibold text-slate-600">Color</label>
                    <input type="color" name="color" value="#6366f1" class="h-9 w-14 rounded-lg border border-slate-200">
                    <button type="submit" class="primary-btn flex-1 text-center">Add</button>
                </div>
            </form>
        </div>
    </aside>

    <section class="main-panel p-6 md:p-8 space-y-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-slate-900">{{ $selectedCategoryName }}</h1>
                @if($selectedCategoryDescription)
                    <p class="text-slate-500">{{ $selectedCategoryDescription }}</p>
                @elseif($selectedCategoryName === 'All Tasks')
                    <p class="text-slate-500">See everything in one place.</p>
                @elseif($selectedCategoryName === 'Important')
                    <p class="text-slate-500">Star tasks to focus on what matters.</p>
                @endif
            </div>
            <a href="{{ route('tasks.create') }}" class="primary-btn flex items-center gap-2 self-start">
                <i class="fa-solid fa-plus"></i> New Task
            </a>
        </div>

        <form method="GET" action="{{ route('tasks.index') }}" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-3">
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-3 text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search tasks..."
                    class="input-field pl-10" />
            </div>
            <select name="status" class="input-field" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
            <select name="date_filter" class="input-field" onchange="this.form.submit()">
                <option value="">All Dates</option>
                <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Today</option>
                <option value="tomorrow" {{ request('date_filter') == 'tomorrow' ? 'selected' : '' }}>Tomorrow</option>
                <option value="this_week" {{ request('date_filter') == 'this_week' ? 'selected' : '' }}>This Week</option>
                <option value="next_week" {{ request('date_filter') == 'next_week' ? 'selected' : '' }}>Next Week</option>
                <option value="this_month" {{ request('date_filter') == 'this_month' ? 'selected' : '' }}>This Month</option>
                <option value="overdue" {{ request('date_filter') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                <option value="no_date" {{ request('date_filter') == 'no_date' ? 'selected' : '' }}>No Date</option>
            </select>
            <div class="grid grid-cols-2 gap-3">
                <select name="sort_by" class="input-field" onchange="this.form.submit()">
                    <option value="deadline" {{ request('sort_by', 'deadline') == 'deadline' ? 'selected' : '' }}>Sort by Deadline</option>
                    <option value="priority" {{ request('sort_by') == 'priority' ? 'selected' : '' }}>Sort by Priority</option>
                    <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Sort by Created</option>
                </select>
                <select name="sort_direction" class="input-field" onchange="this.form.submit()">
                    <option value="asc" {{ request('sort_direction', 'asc') == 'asc' ? 'selected' : '' }}>Asc</option>
                    <option value="desc" {{ request('sort_direction') == 'desc' ? 'selected' : '' }}>Desc</option>
                </select>
            </div>
            <input type="hidden" name="category" value="{{ $selectedCategory }}">
        </form>

        <div class="space-y-3">
            @forelse($tasks as $task)
            @php
                $deadline = $task->deadline ? \Carbon\Carbon::parse($task->deadline) : null;
                $isOverdue = $deadline && $deadline->lt(\Carbon\Carbon::today()) && $task->status === 'pending';
            @endphp
            <div class="task-card">
                <div class="flex items-start gap-4">
                    <form method="POST" action="{{ route('tasks.toggle-status', $task) }}" class="mt-1">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-6 h-6 rounded-full border flex items-center justify-center {{ $task->status === 'completed' ? 'bg-emerald-500 border-emerald-500 text-white' : 'border-slate-300' }}">
                            @if($task->status === 'completed')
                                <i class="fa-solid fa-check text-xs"></i>
                            @endif
                        </button>
                    </form>

                    <div class="flex-1 space-y-2">
                        <div class="flex items-start justify-between gap-3">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    @if($task->category)
                                        <span class="w-2.5 h-2.5 rounded-full" style="background: {{ $task->category->color }}"></span>
                                    @endif
                                    <p class="text-lg font-semibold {{ $task->status === 'completed' ? 'line-through text-slate-400' : 'text-slate-900' }}">{{ $task->title }}</p>
                                </div>
                                <div class="flex flex-wrap items-center gap-2 text-xs font-bold">
                                    @if($deadline)
                                        <span class="pill {{ $isOverdue ? 'bg-red-50 text-red-700 border border-red-200' : 'bg-slate-100 text-slate-700 border border-slate-200' }}">
                                            <i class="fa-regular fa-calendar"></i>
                                            {{ $deadline->format('M d, Y') }}
                                            @if($isOverdue)
                                                <span class="text-red-600">Overdue</span>
                                            @endif
                                        </span>
                                    @else
                                        <span class="pill bg-slate-50 text-slate-500 border border-slate-200">
                                            <i class="fa-regular fa-calendar-times"></i>
                                            No deadline
                                        </span>
                                    @endif

                                    <span class="pill @if($task->priority === 'high') bg-rose-50 text-rose-700 border border-rose-200 @elseif($task->priority === 'medium') bg-amber-50 text-amber-700 border border-amber-200 @else bg-emerald-50 text-emerald-700 border border-emerald-200 @endif">
                                        <i class="fa-solid fa-flag"></i>
                                        {{ $task->priority }} priority
                                    </span>

                                    <span class="pill {{ $task->status === 'completed' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-blue-50 text-blue-700 border border-blue-200' }}">
                                        <i class="fa-solid {{ $task->status === 'completed' ? 'fa-circle-check' : 'fa-clock' }}"></i>
                                        {{ $task->status }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <button type="button" class="text-slate-400 hover:text-slate-600" data-collapse-toggle="task-body-{{ $task->id }}" aria-expanded="true">
                                    <i class="fa-solid fa-chevron-up" aria-hidden="true"></i>
                                </button>
                                <form method="POST" action="{{ route('tasks.toggle-important', $task) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-lg {{ $task->is_important ? 'text-amber-500' : 'text-slate-300 hover:text-amber-400' }}" title="Mark as important">
                                        <i class="fa{{ $task->is_important ? 's' : 'r' }} fa-star"></i>
                                    </button>
                                </form>
                                <a href="{{ route('tasks.edit', $task) }}" class="text-indigo-500 hover:text-indigo-700" title="Edit">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                                <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="delete-task-form"
                                    data-task-title="{{ addslashes($task->title) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700" title="Delete">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div id="task-body-{{ $task->id }}" class="space-y-3">
                            @if($task->description)
                                <p class="text-sm text-slate-500 {{ $task->status === 'completed' ? 'line-through' : '' }}">{{ $task->description }}</p>
                            @endif

                            @if($task->subtasks->count())
                                <div class="space-y-2">
                                    @foreach($task->subtasks as $subtask)
                                        <div class="flex items-center gap-3 bg-slate-50 border border-slate-100 rounded-xl px-3 py-2">
                                            <form method="POST" action="{{ route('subtasks.toggle', $subtask) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="w-5 h-5 rounded-full border flex items-center justify-center {{ $subtask->is_completed ? 'bg-indigo-500 border-indigo-500 text-white' : 'border-slate-300' }}">
                                                    @if($subtask->is_completed)
                                                        <i class="fa-solid fa-check text-[10px]"></i>
                                                    @endif
                                                </button>
                                            </form>
                                            <p class="flex-1 text-sm {{ $subtask->is_completed ? 'line-through text-slate-400' : 'text-slate-700' }}">{{ $subtask->title }}</p>
                                            <form method="POST" action="{{ route('subtasks.destroy', $subtask) }}" data-confirm="Delete subtask {{ addslashes($subtask->title) }}?">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-slate-300 hover:text-red-500" title="Delete subtask">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <form method="POST" action="{{ route('subtasks.store', $task) }}" class="flex items-center gap-3">
                                @csrf
                                <input type="text" name="title" class="input-field text-sm flex-1" placeholder="Next step" required>
                                <button type="submit" class="ghost-btn text-sm px-4">Add</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="task-card text-center py-12">
                <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mx-auto mb-4">
                    <i class="fa-regular fa-clipboard text-2xl"></i>
                </div>
                <p class="text-lg font-semibold text-slate-700">No tasks yet</p>
                <p class="text-slate-500">Start by adding a new task or changing your filters.</p>
                <a href="{{ route('tasks.create') }}" class="primary-btn inline-flex items-center gap-2 mt-4">
                    <i class="fa-solid fa-plus"></i> Add Task
                </a>
            </div>
            @endforelse
        </div>
    </section>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('[data-edit-toggle]').forEach(btn => {
            btn.addEventListener('click', () => {
                const key = btn.getAttribute('data-edit-toggle');
                const form = document.querySelector(`[data-edit-form="${key}"]`);
                if (form) form.classList.toggle('hidden');
            });
        });

        document.querySelectorAll('[data-edit-cancel]').forEach(btn => {
            btn.addEventListener('click', () => {
                const key = btn.getAttribute('data-edit-cancel');
                const form = document.querySelector(`[data-edit-form="${key}"]`);
                if (form) form.classList.add('hidden');
            });
        });

        document.querySelectorAll('[data-collapse-toggle]').forEach(btn => {
            const targetId = btn.getAttribute('data-collapse-toggle');
            const target = document.getElementById(targetId);
            const icon = btn.querySelector('i');

            btn.addEventListener('click', () => {
                if (!target) return;
                const nowHidden = target.classList.toggle('hidden');
                btn.setAttribute('aria-expanded', (!nowHidden).toString());
                if (icon) {
                    icon.classList.toggle('rotate-180', nowHidden);
                }
            });
        });
    });
</script>
@endsection
