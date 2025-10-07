<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::where('user_id', Auth::id());

        // Filter berdasarkan status
        if ($request->has('status') && in_array($request->status, ['pending', 'completed'])) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tanggal
        if ($request->has('date_filter') && $request->date_filter) {
            $this->applyDateFilter($query, $request->date_filter);
        }

        // Pencarian
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        // Sorting
        $sortBy = $request->input('sort_by', 'deadline'); // default sort by deadline
        $sortDirection = $request->input('sort_direction', 'asc'); // default sort direction asc

        if ($sortBy === 'priority') {
            // Custom order for priority: high -> medium -> low
            $query->orderByRaw("
                CASE 
                    WHEN priority = 'high' THEN 1 
                    WHEN priority = 'medium' THEN 2 
                    WHEN priority = 'low' THEN 3 
                END {$sortDirection}
            ");
        } else {
            // Default to sorting by deadline or any other column
            $query->orderBy('deadline', $sortDirection);
        }

        $tasks = $query->orderBy('created_at', 'desc')->get();
        
        return view('tasks.index', compact('tasks', 'sortBy', 'sortDirection'));
    }

    /**
     * Apply date filter to query
     */
    private function applyDateFilter($query, $dateFilter)
    {
        $today = Carbon::today();
        
        switch ($dateFilter) {
            case 'today':
                $query->whereDate('deadline', $today);
                break;
                
            case 'tomorrow':
                $query->whereDate('deadline', $today->copy()->addDay());
                break;
                
            case 'this_week':
                $query->whereBetween('deadline', [
                    $today->copy()->startOfWeek(),
                    $today->copy()->endOfWeek()
                ]);
                break;
                
            case 'next_week':
                $query->whereBetween('deadline', [
                    $today->copy()->addWeek()->startOfWeek(),
                    $today->copy()->addWeek()->endOfWeek()
                ]);
                break;
                
            case 'this_month':
                $query->whereBetween('deadline', [
                    $today->copy()->startOfMonth(),
                    $today->copy()->endOfMonth()
                ]);
                break;
                
            case 'overdue':
                $query->whereDate('deadline', '<', $today)
                      ->where('status', 'pending');
                break;
                
            case 'no_date':
                $query->whereNull('deadline');
                break;
        }
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'priority' => 'required|in:low,medium,high'
            // category_id dihapus dari validation
        ]);

        Task::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'priority' => $request->priority
            // category_id dihapus
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function edit(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'priority' => 'required|in:low,medium,high'
            // category_id dihapus dari validation
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'priority' => $request->priority
            // category_id dihapus
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }
        
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    public function toggleStatus(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }
        
        $task->update([
            'status' => $task->status === 'completed' ? 'pending' : 'completed'
        ]);

        return redirect()->back()->with('success', 'Task status updated.');
    }
}