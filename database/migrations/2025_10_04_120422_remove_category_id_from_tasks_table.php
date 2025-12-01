<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration ini dibuat untuk menghapus category_id dari tasks
 * Namun karena kolom tersebut tidak pernah ada, migration ini dikosongkan
 * Disimpan untuk menjaga konsistensi riwayat migration
 */
class RemoveCategoryIdFromTasksTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Cek apakah kolom category_id ada sebelum drop
        if (Schema::hasColumn('tasks', 'category_id')) {
            Schema::table('tasks', function (Blueprint $table) {
                // Hapus foreign key constraint dulu
                $table->dropForeign(['category_id']);
                // Hapus kolom category_id
                $table->dropColumn('category_id');
            });
        }
        // Jika tidak ada, skip (no-op)
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Hanya tambahkan kembali jika kolom belum ada
        if (!Schema::hasColumn('tasks', 'category_id')) {
            Schema::table('tasks', function (Blueprint $table) {
                $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            });
        }
    }
}