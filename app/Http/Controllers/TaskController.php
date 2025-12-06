<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

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
        $userId = Auth::id();

        // Ambil task hanya milik user yang login
        $query = Task::where('user_id', $userId);

        $selectedCategory = $request->input('category', 'all');

        // Filter kategori: important (bawaan sistem) atau kategori user
        if ($selectedCategory === 'important') {
            $query->where('is_important', true);
        } elseif ($selectedCategory && $selectedCategory !== 'all') {
            $query->where('category_id', $selectedCategory);
        }

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
        $sortBy = $request->input('sort_by', 'deadline');
        $sortDirection = $request->input('sort_direction', 'asc');

        if ($sortBy === 'priority') {
            $query->orderByRaw("
                CASE 
                    WHEN priority = 'high' THEN 1 
                    WHEN priority = 'medium' THEN 2 
                    WHEN priority = 'low' THEN 3 
                END {$sortDirection}
            ");
        } else {
            $column = $sortBy === 'created_at' ? 'created_at' : 'deadline';
            $query->orderBy($column, $sortDirection);
        }

        $tasksQuery = $query->with(['category', 'subtasks']);

        if ($sortBy !== 'created_at') {
            $tasksQuery->orderBy('created_at', 'desc');
        }

        $tasks = $tasksQuery->get();

        $categories = Category::where('user_id', $userId)
            ->orderBy('name')
            ->withCount(['tasks' => function ($q) use ($userId) {
                $q->where('user_id', $userId);
            }])
            ->get();

        $counts = [
            'all' => Task::where('user_id', $userId)->count(),
            'important' => Task::where('user_id', $userId)->where('is_important', true)->count(),
        ];

        $selectedCategoryName = 'All Tasks';
        $selectedCategoryDescription = null;

        if ($selectedCategory === 'important') {
            $selectedCategoryName = 'Important';
        } elseif ($selectedCategory && $selectedCategory !== 'all') {
            $found = $categories->firstWhere('id', (int) $selectedCategory);
            if ($found) {
                $selectedCategoryName = $found->name;
                $selectedCategoryDescription = $found->description;
            }
        }
        
        return view('tasks.index', compact('tasks', 'sortBy', 'sortDirection', 'categories', 'selectedCategory', 'counts', 'selectedCategoryName', 'selectedCategoryDescription'));
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
        $categories = Category::where('user_id', Auth::id())->orderBy('name')->get();

        return view('tasks.create', compact('categories'));
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
            'priority' => 'required|in:low,medium,high',
            'category_id' => [
                'nullable',
                Rule::exists('categories', 'id')->where(fn ($q) => $q->where('user_id', Auth::id()))
            ],
            'is_important' => 'nullable|boolean'
        ]);

        Task::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'priority' => $request->priority,
            'is_important' => $request->boolean('is_important')
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

        $categories = Category::where('user_id', Auth::id())->orderBy('name')->get();
        
        return view('tasks.edit', compact('task', 'categories'));
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
            'priority' => 'required|in:low,medium,high',
            'category_id' => [
                'nullable',
                Rule::exists('categories', 'id')->where(fn ($q) => $q->where('user_id', Auth::id()))
            ],
            'is_important' => 'nullable|boolean'
        ]);

        $task->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'priority' => $request->priority,
            'is_important' => $request->boolean('is_important')
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
        
        $newStatus = $task->status === 'completed' ? 'pending' : 'completed';

        $task->update(['status' => $newStatus]);

        // Jika task selesai, tandai semua subtask sebagai selesai juga.
        if ($newStatus === 'completed') {
            $task->subtasks()->where('is_completed', false)->update(['is_completed' => true]);
        }

        return redirect()->back()->with('success', 'Task status updated.');
    }

    /**
     * Toggle status penting (bintang) pada task.
     */
    public function toggleImportant(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $task->update([
            'is_important' => ! $task->is_important
        ]);

        return redirect()->back()->with('success', $task->is_important ? 'Marked as important.' : 'Removed from important.');
    }
}