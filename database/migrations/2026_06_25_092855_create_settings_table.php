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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            $table->string('site_name')->nullable();

            $table->string('header_logo')->nullable();

            $table->string('footer_logo')->nullable();

            $table->string('favicon')->nullable();

            $table->string('author_name')->nullable();

            $table->string('author_image')->nullable();

            $table->text('author_description')->nullable();

            $table->string('facebook_url')->nullable();

            $table->string('instagram_url')->nullable();

            $table->string('youtube_url')->nullable();

            $table->text('copyright_text')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
