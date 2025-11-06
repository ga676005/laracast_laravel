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
        Schema::create('tags', function (Blueprint $table) {
            $table->id('tag_id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('job_listings_to_tags', function (Blueprint $table) {
            $table->id('job_listings_to_tags_id');
            $table->foreignId('job_listing_id')->constrained('job_listings', 'job_listing_id')->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained('tags', 'tag_id')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['job_listing_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_listings_to_tags');
        Schema::dropIfExists('tags');
    }
};
