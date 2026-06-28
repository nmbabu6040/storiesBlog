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
        Schema::table('menus', function (Blueprint $table) {
            $table->string('type')->default('custom')->after('name');
            // custom | page | category

            $table->string('menu_location')->default('header')->after('type');
            // header | footer_1 | footer_2 | footer_3 | footer_4

            $table->foreignId('category_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete()
                ->after('url');

            $table->string('page_slug')
                ->nullable()
                ->after('category_id');

            $table->string('target')
                ->default('_self')
                ->after('menu_location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');

            $table->dropColumn([
                'type',
                'menu_location',
                'page_slug',
                'target'
            ]);
        });
    }
};
