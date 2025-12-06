<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubtaskController;
use Illuminate\Support\Facades\Route;

/**
 * ========================================
 * AUTHENTICATION ROUTES (Public Routes)
 * ========================================
 * Routes untuk autentikasi user (login & register)
 */

// Menampilkan halaman login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

// Memproses login user
Route::post('/login', [AuthController::class, 'login']);

// Menampilkan halaman register
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

// Memproses registrasi user baru
Route::post('/register', [AuthController::class, 'register']);

// Memproses logout user
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/**
 * ========================================
 * GOOGLE OAUTH ROUTES
 * ========================================
 * Routes untuk Google OAuth 2.0 authentication
 */

// Redirect ke Google OAuth
Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');

// Callback dari Google setelah user login
Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);

/**
 * ========================================
 * PROTECTED ROUTES (Requires Authentication)
 * ========================================
 * Routes yang memerlukan autentikasi user
 */
Route::middleware(['auth'])->group(function () {
    // Redirect root ke halaman tasks
    Route::get('/', function () {
        if (auth()->user() && auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect('/tasks');
    });

    /**
     * TASK ROUTES - CRUD untuk task
     */
    // Menampilkan daftar semua task user
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    
    // Menampilkan form create task baru
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    
    // Menyimpan task baru ke database
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    
    // Menampilkan form edit task
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    
    // Mengupdate task yang sudah ada
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    
    // Menghapus task
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    
    // Toggle status task (pending <-> completed)
    Route::patch('/tasks/{task}/toggle-status', [TaskController::class, 'toggleStatus'])->name('tasks.toggle-status');

    // Toggle important (star) task
    Route::patch('/tasks/{task}/toggle-important', [TaskController::class, 'toggleImportant'])->name('tasks.toggle-important');

    // Subtasks
    Route::post('/tasks/{task}/subtasks', [SubtaskController::class, 'store'])->name('subtasks.store');
    Route::patch('/subtasks/{subtask}/toggle', [SubtaskController::class, 'toggle'])->name('subtasks.toggle');
    Route::delete('/subtasks/{subtask}', [SubtaskController::class, 'destroy'])->name('subtasks.destroy');

    // Kategori buatan user
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::patch('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    
    /**
     * PROFILE ROUTES - Manajemen profile user
     */
    // Menampilkan halaman edit profile
    Route::get('/profile/edit', [AuthController::class, 'editProfile'])->name('profile.edit');
    
    // Mengupdate profile user
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    
    // Menghapus akun user
    Route::delete('/profile', [AuthController::class, 'deleteAccount'])->name('profile.delete');
});

/**
 * ========================================
 * ADMIN ROUTES (Role-based)
 * ========================================
 */
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard admin - menampilkan semua user
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Menampilkan form edit user
        Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');

        // Create user (admin can choose role)
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');

        // Mengupdate data user
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');

        // Menghapus user dan semua tasknya
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');

        // Logout admin
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
    });