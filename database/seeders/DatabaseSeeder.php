<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Task;
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

        // Buat user testing pertama
        $testUser = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Buat user testing kedua
        $demoUser = User::firstOrCreate(
            ['email' => 'demo@example.com'],
            [
                'name' => 'Demo User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Buat user testing ketiga
        $johnDoe = User::firstOrCreate(
            ['email' => 'john@example.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Buat sample tasks untuk test user
        $this->createSampleTasks($testUser);
        
        // Buat sample tasks untuk demo user
        $this->createSampleTasks($demoUser);
        
        // Buat sample tasks untuk john doe
        $this->createSampleTasks($johnDoe);
    }

    /**
     * Membuat sample tasks untuk user
     * 
     * @param User $user
     * @return void
     */
    private function createSampleTasks(User $user): void
    {
        $tasks = [
            [
                'title' => 'Complete Laravel Project',
                'description' => 'Finish the TODO list application with all CRUD features',
                'deadline' => now()->addDays(3),
                'status' => 'pending',
                'priority' => 'high'
            ],
            [
                'title' => 'Study for Exam',
                'description' => 'Review all materials for the upcoming exam',
                'deadline' => now()->addDays(7),
                'status' => 'pending',
                'priority' => 'medium'
            ],
            [
                'title' => 'Buy Groceries',
                'description' => 'Buy milk, eggs, bread, and vegetables',
                'deadline' => now()->addDay(),
                'status' => 'pending',
                'priority' => 'low'
            ],
            [
                'title' => 'Workout',
                'description' => 'Go to the gym for 1 hour',
                'deadline' => now(),
                'status' => 'completed',
                'priority' => 'medium'
            ],
            [
                'title' => 'Read Book',
                'description' => 'Read at least 50 pages of "Clean Code"',
                'deadline' => now()->addDays(5),
                'status' => 'pending',
                'priority' => 'low'
            ],
        ];

        foreach ($tasks as $taskData) {
            Task::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'title' => $taskData['title']
                ],
                $taskData + ['user_id' => $user->id]
            );
        }
    }
}
