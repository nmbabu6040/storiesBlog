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
            $table->string('phone')->nullable()->after('youtube_url');

            $table->string('email')->nullable()->after('phone');

            $table->text('address')->nullable()->after('email');

            $table->longText('google_map')->nullable()->after('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'email',
                'address',
                'google_map'
            ]);
        });
    }
};
