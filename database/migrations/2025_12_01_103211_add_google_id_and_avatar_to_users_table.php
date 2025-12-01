<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration untuk menambahkan kolom google_id dan avatar
 * untuk mendukung Google OAuth login
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Google ID - unique identifier dari Google
            $table->string('google_id')->nullable()->unique()->after('id');
            
            // Avatar URL dari Google profile picture
            $table->string('avatar')->nullable()->after('email');
            
            // Make password nullable untuk user yang login dengan Google
            $table->string('password')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['google_id', 'avatar']);
            
            // Kembalikan password menjadi required
            $table->string('password')->nullable(false)->change();
        });
    }
};
