<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('board_members') && !Schema::hasColumn('board_members', 'deleted_at')) {
            Schema::table('board_members', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        if (Schema::hasTable('partners') && !Schema::hasColumn('partners', 'deleted_at')) {
            Schema::table('partners', function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('board_members') && Schema::hasColumn('board_members', 'deleted_at')) {
            Schema::table('board_members', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }

        if (Schema::hasTable('partners') && Schema::hasColumn('partners', 'deleted_at')) {
            Schema::table('partners', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
    }
};

