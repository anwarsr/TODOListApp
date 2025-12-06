<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Task;
use App\Models\Category;
use App\Models\Subtask;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * DatabaseSeeder
 * 
 * Seeder utama untuk mengisi database dengan data uji
 * Membuat user dan task sampel untuk testing
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Showcase user with rich demo data
        $user = User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Example User',
                'password' => Hash::make('user1234'),
                'email_verified_at' => now(),
                'role' => 'user',
            ]
        );

        // Recreate sample tasks to ensure fresh state
        $user->tasks()->delete();
        $user->ensureDefaultCategories();
        $this->createShowcaseTasks($user);

        // Seed default admin account
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin1234'),
                'email_verified_at' => now(),
                'role' => 'admin',
            ]
        );
    }

    /**
     * Membuat task demo yang menampilkan fitur kategori, prioritas, penting, status, dan subtasks.
     */
    private function createShowcaseTasks(User $user): void
    {
        $categories = [
            'Personal' => ['#16a34a', 'Personal tasks and reminders'],
            'Work' => ['#2563eb', 'Work and professional tasks'],
            'Study' => ['#8b5cf6', 'Study plans and assignments'],
        ];

        $categoryIds = [];

        foreach ($categories as $name => [$color, $description]) {
            $categoryIds[$name] = Category::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'name' => $name,
                ],
                [
                    'description' => $description,
                    'color' => $color,
                    'is_system' => false,
                ]
            )->id;
        }

        $tasks = [
            [
                'title' => 'Plan sprint backlog',
                'description' => 'Refine user stories, size them, and lock scope for the next sprint.',
                'deadline' => now()->addDays(2),
                'status' => 'pending',
                'priority' => 'high',
                'category' => 'Work',
                'is_important' => true,
                'subtasks' => [
                    ['title' => 'Groom top 10 stories', 'is_completed' => true],
                    ['title' => 'Add acceptance criteria', 'is_completed' => false],
                    ['title' => 'Finalize story points', 'is_completed' => false],
                ],
            ],
            [
                'title' => 'Groceries & meal prep',
                'description' => 'Restock pantry and prep lunches for the week.',
                'deadline' => now()->addDay(),
                'status' => 'completed',
                'priority' => 'medium',
                'category' => 'Personal',
                'is_important' => false,
                'subtasks' => [
                    ['title' => 'Buy veggies and protein', 'is_completed' => true],
                    ['title' => 'Prep 3 lunch boxes', 'is_completed' => true],
                ],
            ],
            [
                'title' => 'Midterm revision: Data Structures',
                'description' => 'Focus on graphs, DP, and complexity trade-offs.',
                'deadline' => now()->addDays(5),
                'status' => 'pending',
                'priority' => 'high',
                'category' => 'Study',
                'is_important' => true,
                'subtasks' => [
                    ['title' => 'Revisit graph traversals', 'is_completed' => true],
                    ['title' => 'Solve 5 DP problems', 'is_completed' => false],
                    ['title' => 'Complexity flashcards review', 'is_completed' => false],
                ],
            ],
            [
                'title' => 'Workspace reset',
                'description' => 'Clear desk, archive notes, and clean device storage.',
                'deadline' => now()->addDays(3),
                'status' => 'pending',
                'priority' => 'low',
                'category' => 'Personal',
                'is_important' => false,
                'subtasks' => [
                    ['title' => 'Declutter desk surface', 'is_completed' => false],
                    ['title' => 'Organize cables', 'is_completed' => false],
                ],
            ],
            [
                'title' => 'Inbox zero sweep',
                'description' => 'Archive newsletters and respond to pending messages.',
                'deadline' => now()->addDays(1),
                'status' => 'pending',
                'priority' => 'medium',
                'category' => null,
                'is_important' => false,
                'subtasks' => [
                    ['title' => 'Archive promos/newsletters', 'is_completed' => true],
                    ['title' => 'Reply to action items', 'is_completed' => false],
                ],
            ],
        ];

        foreach ($tasks as $taskData) {
            $task = Task::create([
                'user_id' => $user->id,
                'category_id' => $taskData['category'] ? ($categoryIds[$taskData['category']] ?? null) : null,
                'title' => $taskData['title'],
                'description' => $taskData['description'] ?? null,
                'deadline' => $taskData['deadline'] ?? null,
                'status' => $taskData['status'] ?? 'pending',
                'priority' => $taskData['priority'] ?? 'medium',
                'is_important' => $taskData['is_important'] ?? false,
            ]);

            foreach ($taskData['subtasks'] as $subtask) {
                Subtask::create([
                    'task_id' => $task->id,
                    'title' => $subtask['title'],
                    'is_completed' => $subtask['is_completed'] ?? false,
                ]);
            }
        }
    }
}
