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
        Schema::table('advertisements', function (Blueprint $table) {
            $table->enum('type', [
                'adsense',
                'html',
                'image'
            ])->default('adsense')->after('position');

            $table->string('image')->nullable()->after('code');

            $table->string('url')->nullable()->after('image');

            $table->integer('sort_order')->default(0)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('advertisements', function (Blueprint $table) {
            $table->dropColumn([
                'type',
                'image',
                'url',
                'sort_order'
            ]);
        });
    }
};
