<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'likes')) {
                $table->json('likes')->nullable()->after('views');
            }
            if (!Schema::hasColumn('users', 'comments')) {
                $table->json('comments')->nullable()->after('likes');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'comments')) {
                $table->dropColumn('comments');
            }
            if (Schema::hasColumn('users', 'likes')) {
                $table->dropColumn('likes');
            }
        });
    }
};
