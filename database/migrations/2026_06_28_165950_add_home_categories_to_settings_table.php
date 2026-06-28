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
        Schema::table('settings', function (Blueprint $table) {
            $table->foreignId('travel_category_id')->nullable()->after('hero_image');

            $table->foreignId('destination_category_id')->nullable();

            $table->foreignId('lifestyle_category_id')->nullable();

            $table->foreignId('photography_category_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'travel_category_id',
                'destination_category_id',
                'lifestyle_category_id',
                'photography_category_id'
            ]);
        });
    }
};
