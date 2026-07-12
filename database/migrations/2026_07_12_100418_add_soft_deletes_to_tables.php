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
        Schema::table('posts', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('galleries', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('menus', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('advertisements', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('subscribers', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', fn(Blueprint $table) => $table->dropSoftDeletes());
        Schema::table('categories', fn(Blueprint $table) => $table->dropSoftDeletes());
        Schema::table('pages', fn(Blueprint $table) => $table->dropSoftDeletes());
        Schema::table('galleries', fn(Blueprint $table) => $table->dropSoftDeletes());
        Schema::table('menus', fn(Blueprint $table) => $table->dropSoftDeletes());
        Schema::table('advertisements', fn(Blueprint $table) => $table->dropSoftDeletes());
        Schema::table('subscribers', fn(Blueprint $table) => $table->dropSoftDeletes());
    }
};
