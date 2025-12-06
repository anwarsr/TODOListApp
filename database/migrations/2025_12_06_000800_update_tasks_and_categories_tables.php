<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained()->onDelete('cascade');
            }
            if (!Schema::hasColumn('categories', 'description')) {
                $table->string('description', 160)->nullable()->after('name');
            }
            if (!Schema::hasColumn('categories', 'is_system')) {
                $table->boolean('is_system')->default(false)->after('color');
            }
            if (!Schema::hasColumn('categories', 'created_at')) {
                $table->timestamps();
            }
        });

        Schema::table('tasks', function (Blueprint $table) {
            if (!Schema::hasColumn('tasks', 'category_id')) {
                $table->foreignId('category_id')->nullable()->after('user_id')->constrained()->nullOnDelete();
            }
            if (!Schema::hasColumn('tasks', 'is_important')) {
                $table->boolean('is_important')->default(false)->after('priority');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            if (Schema::hasColumn('tasks', 'category_id')) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            }
            if (Schema::hasColumn('tasks', 'is_important')) {
                $table->dropColumn('is_important');
            }
        });

        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
            if (Schema::hasColumn('categories', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('categories', 'is_system')) {
                $table->dropColumn('is_system');
            }
        });
    }
};
