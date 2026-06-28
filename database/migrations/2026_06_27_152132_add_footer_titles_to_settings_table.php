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
            $table->string('footer_title_1')->nullable()->after('copyright_text');

            $table->string('footer_title_2')->nullable()->after('footer_title_1');

            $table->string('footer_title_3')->nullable()->after('footer_title_2');

            $table->string('footer_title_4')->nullable()->after('footer_title_3');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([

                'footer_title_1',

                'footer_title_2',

                'footer_title_3',

                'footer_title_4'

            ]);
        });
    }
};
