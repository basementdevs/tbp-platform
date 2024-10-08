<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings_colors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('translation_key');
            $table->string('hex');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings_colors');
    }
};
