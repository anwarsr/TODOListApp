<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_tasks_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration untuk membuat tabel tasks
 * 
 * Tabel ini menyimpan semua task yang dibuat oleh user
 * dengan informasi title, description, deadline, status, dan priority
 */
class CreateTasksTable extends Migration
{
    /**
     * Jalankan migration untuk membuat tabel tasks
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ID user pemilik task
            $table->string('title'); // Judul task
            $table->text('description')->nullable(); // Deskripsi detail task (opsional)
            $table->dateTime('deadline')->nullable(); // Batas waktu pengerjaan (opsional)
            $table->enum('status', ['pending', 'completed'])->default('pending'); // Status task
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium'); // Prioritas task
            $table->timestamps(); // created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}