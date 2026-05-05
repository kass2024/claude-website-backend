<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title_fr')->nullable();
            $table->string('slug')->unique();
            $table->string('excerpt', 500);
            $table->string('excerpt_fr', 500)->nullable();
            $table->longText('description')->nullable();
            $table->longText('description_fr')->nullable();
            $table->string('benefit')->nullable(); // e.g. "20% off", "Free audit"
            $table->string('benefit_fr')->nullable();
            $table->string('badge')->nullable(); // New, Featured, Limited Offer
            $table->boolean('featured')->default(false);
            $table->string('image_path')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->timestamp('starts_at')->nullable()->index();
            $table->timestamp('expires_at')->nullable()->index();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title_fr')->nullable();
            $table->string('slug')->unique();
            $table->string('excerpt', 500);
            $table->string('excerpt_fr', 500)->nullable();
            $table->longText('description')->nullable();
            $table->longText('description_fr')->nullable();
            $table->string('badge')->nullable(); // Event, Workshop, Webinar
            $table->boolean('featured')->default(false);
            $table->string('image_path')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->timestamp('starts_at')->index();
            $table->timestamp('ends_at')->nullable()->index();
            $table->string('location')->nullable(); // or platform name
            $table->boolean('is_online')->default(false);
            $table->string('registration_url')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title_fr')->nullable();
            $table->string('message', 500)->nullable();
            $table->string('message_fr', 500)->nullable();
            $table->string('badge')->nullable(); // Announcement
            $table->string('cta_label')->nullable();
            $table->string('cta_label_fr')->nullable();
            $table->string('cta_url')->nullable();
            $table->string('image_path')->nullable();
            $table->boolean('featured')->default(false);
            $table->unsignedInteger('priority')->default(0);
            $table->timestamp('starts_at')->nullable()->index();
            $table->timestamp('ends_at')->nullable()->index();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('interest_leads', function (Blueprint $table) {
            $table->id();
            $table->string('source_type')->nullable(); // post|offer|event|banner|other
            $table->unsignedBigInteger('source_id')->nullable();
            $table->string('source_slug')->nullable();
            $table->string('source_title')->nullable();
            $table->string('interest_type'); // offer|event|service|training|consultation|other

            $table->string('full_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('company_name')->nullable();
            $table->longText('message')->nullable();
            $table->boolean('consent')->default(false);

            $table->string('status')->default('new'); // new|contacted|qualified|closed
            $table->timestamp('submitted_at')->useCurrent()->index();
            $table->timestamps();

            $table->index(['status', 'interest_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interest_leads');
        Schema::dropIfExists('banners');
        Schema::dropIfExists('events');
        Schema::dropIfExists('offers');
    }
};

