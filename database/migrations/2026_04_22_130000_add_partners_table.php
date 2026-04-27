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
        if (! Schema::hasTable('partners')) {
            Schema::create('partners', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('name_fr')->nullable();
                $table->string('tagline')->nullable();
                $table->string('tagline_fr')->nullable();
                $table->string('website_url')->nullable();
                $table->string('logo_path')->nullable();
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('is_published')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};

