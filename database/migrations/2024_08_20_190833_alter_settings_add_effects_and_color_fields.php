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
            $table->foreignId('effect_id')
                ->after('occupation_id')
                ->nullable()
                ->constrained('settings_effects')
                ->onDelete('set null');

            $table->foreignId('color_id')
                ->after('occupation_id')
                ->nullable()
                ->constrained('settings_colors')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropForeign(['effect_id']);
            $table->dropForeign(['color_id']);
            $table->dropColumn('effect_id');
            $table->dropColumn('color_id');
        });
    }
};
