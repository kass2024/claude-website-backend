<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Hostinger/shared hosting deployments can have pre-created tables.
        // Make this migration idempotent.
        if (! Schema::hasTable('board_members')) {
            Schema::create('board_members', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('name_fr')->nullable();
                $table->string('role');
                $table->string('role_fr')->nullable();
                $table->text('bio')->nullable();
                $table->text('bio_fr')->nullable();
                $table->string('email')->nullable();
                $table->string('phone')->nullable();
                $table->string('linkedin_url')->nullable();
                $table->string('image_path')->nullable();
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('is_published')->default(true);
                $table->timestamps();
            });
        }

        Schema::table('services', function (Blueprint $table) {
            if (! Schema::hasColumn('services', 'title_fr')) {
                $table->string('title_fr')->nullable()->after('title');
            }
            if (! Schema::hasColumn('services', 'short_description_fr')) {
                $table->string('short_description_fr', 500)->nullable()->after('short_description');
            }
            if (! Schema::hasColumn('services', 'full_description_fr')) {
                $table->longText('full_description_fr')->nullable()->after('full_description');
            }
            if (! Schema::hasColumn('services', 'sections')) {
                $table->json('sections')->nullable()->after('full_description_fr');
            }
        });

        Schema::table('projects', function (Blueprint $table) {
            if (! Schema::hasColumn('projects', 'title_fr')) {
                $table->string('title_fr')->nullable()->after('title');
            }
            if (! Schema::hasColumn('projects', 'category_fr')) {
                $table->string('category_fr')->nullable()->after('category');
            }
            if (! Schema::hasColumn('projects', 'short_description_fr')) {
                $table->string('short_description_fr', 500)->nullable()->after('short_description');
            }
            if (! Schema::hasColumn('projects', 'full_description_fr')) {
                $table->longText('full_description_fr')->nullable()->after('full_description');
            }
        });

        Schema::table('posts', function (Blueprint $table) {
            if (! Schema::hasColumn('posts', 'title_fr')) {
                $table->string('title_fr')->nullable()->after('title');
            }
            if (! Schema::hasColumn('posts', 'excerpt_fr')) {
                $table->string('excerpt_fr', 500)->nullable()->after('excerpt');
            }
            if (! Schema::hasColumn('posts', 'content_fr')) {
                $table->longText('content_fr')->nullable()->after('content');
            }
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['title_fr', 'excerpt_fr', 'content_fr']);
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['title_fr', 'category_fr', 'short_description_fr', 'full_description_fr']);
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['title_fr', 'short_description_fr', 'full_description_fr', 'sections']);
        });

        Schema::dropIfExists('board_members');
    }
};
