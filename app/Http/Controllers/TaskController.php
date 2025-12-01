<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

/**
 * TaskController
 * 
 * Controller untuk mengelola semua operasi CRUD task
 * Termasuk filtering, sorting, dan pencarian task
 * 
 * @package App\Http\Controllers
 */
class TaskController extends Controller
{
    /**
     * Menampilkan daftar task milik user yang sedang login
     * dengan fitur filtering, sorting, dan pencarian
     * 
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Ambil task hanya milik user yang login
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
     * Menerapkan filter tanggal pada query task
     * 
     * @param mixed $query - Query builder instance
     * @param string $dateFilter - Opsi: today, tomorrow, this_week, next_week, this_month, overdue, no_date
     * @return void
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

    /**
     * Menampilkan form untuk membuat task baru
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Menyimpan task baru ke database
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input dari user
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

    /**
     * Menampilkan form untuk mengedit task
     * 
     * @param Task $task
     * @return \Illuminate\View\View
     */
    public function edit(Task $task)
    {
        // Cek apakah user berhak mengedit task ini
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('tasks.edit', compact('task'));
    }

    /**
     * Mengupdate data task yang ada
     * 
     * @param Request $request
     * @param Task $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Task $task)
    {
        // Cek apakah user berhak mengupdate task ini
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

    /**
     * Menghapus task dari database
     * 
     * @param Task $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Task $task)
    {
        // Cek apakah user berhak menghapus task ini
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }
        
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    /**
     * Toggle status task antara pending dan completed
     * 
     * @param Task $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleStatus(Task $task)
    {
        // Cek apakah user berhak mengubah status task ini
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }
        
        $task->update([
            'status' => $task->status === 'completed' ? 'pending' : 'completed'
        ]);

        return redirect()->back()->with('success', 'Task status updated.');
    }
}