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

        // Feature-rich demo user for QA: anwar.saipul120305@gmail.com / 12345678
        $anwar = User::updateOrCreate(
            ['email' => 'anwar.saipul120305@gmail.com'],
            [
                'name' => 'Anwar Saipul',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
                'role' => 'user',
            ]
        );

        $anwar->tasks()->delete();
        $anwar->ensureDefaultCategories();
        $this->createFeatureRichTasks($anwar);

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

    /**
     * Task khusus untuk user anwar.saipul120305@gmail.com yang menampilkan variasi fitur.
     */
    private function createFeatureRichTasks(User $user): void
    {
        $categories = [
            'Pekerjaan' => ['#1d4ed8', 'Rilis dan rapat'],
            'Kesehatan' => ['#0ea5e9', 'Kesehatan dan janji temu'],
            'Keperluan' => ['#f97316', 'Tagihan, pembayaran, dan pekerjaan rumah'],
            'Belajar' => ['#8b5cf6', 'Kursus dan latihan'],
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
                'title' => 'Rilis sprint ke staging',
                'description' => 'Potong branch rilis, perbarui changelog, dan deploy ke staging.',
                'deadline' => now()->addDay(),
                'status' => 'pending',
                'priority' => 'high',
                'category' => 'Pekerjaan',
                'is_important' => true,
                'subtasks' => [
                    ['title' => 'Finalisasi catatan rilis', 'is_completed' => true],
                    ['title' => 'Checklist regresi QA', 'is_completed' => false],
                    ['title' => 'Jadwalkan waktu deploy', 'is_completed' => false],
                ],
            ],
            [
                'title' => 'Buat janji kontrol dokter',
                'description' => 'Booking kontrol dan konfirmasi dengan lampiran hasil lab.',
                'deadline' => now()->addDays(3),
                'status' => 'pending',
                'priority' => 'medium',
                'category' => 'Kesehatan',
                'is_important' => false,
                'subtasks' => [
                    ['title' => 'Unggah hasil lab terbaru', 'is_completed' => true],
                    ['title' => 'Telepon klinik cari jadwal', 'is_completed' => false],
                ],
            ],
            [
                'title' => 'Bayar tagihan bulanan',
                'description' => 'Listrik, air, dan internet bulan ini.',
                'deadline' => now()->subDays(1), // overdue example
                'status' => 'pending',
                'priority' => 'medium',
                'category' => 'Keperluan',
                'is_important' => true,
                'subtasks' => [
                    ['title' => 'Tagihan listrik', 'is_completed' => false],
                    ['title' => 'Tagihan air', 'is_completed' => false],
                    ['title' => 'Tagihan internet', 'is_completed' => true],
                ],
            ],
            [
                'title' => 'Latihan course TypeScript',
                'description' => 'Selesaikan latihan generics dan utility types.',
                'deadline' => now()->addDays(7),
                'status' => 'pending',
                'priority' => 'low',
                'category' => 'Belajar',
                'is_important' => false,
                'subtasks' => [
                    ['title' => 'Latihan mapped types', 'is_completed' => true],
                    ['title' => 'Kuis utility types', 'is_completed' => false],
                ],
            ],
            [
                'title' => 'Bersih-bersih rumah besar',
                'description' => 'Reset akhir pekan: dapur, ruang tamu, dan meja kerja.',
                'deadline' => null, // no date case
                'status' => 'completed',
                'priority' => 'medium',
                'category' => 'Keperluan',
                'is_important' => false,
                'subtasks' => [
                    ['title' => 'Vakum & pel lantai', 'is_completed' => true],
                    ['title' => 'Lap permukaan meja', 'is_completed' => true],
                ],
            ],
            [
                'title' => 'Rapikan inbox email',
                'description' => 'Arsipkan promo dan balas email penting.',
                'deadline' => now()->addHours(6),
                'status' => 'pending',
                'priority' => 'low',
                'category' => null,
                'is_important' => false,
                'subtasks' => [
                    ['title' => 'Arsipkan newsletter', 'is_completed' => true],
                    ['title' => 'Tandai email aksi', 'is_completed' => false],
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
