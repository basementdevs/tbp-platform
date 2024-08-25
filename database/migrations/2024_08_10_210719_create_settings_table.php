<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('occupation_id')->constrained('occupations');
            $table->boolean('enabled')->default(true);
            $table->string('channel_id')->default('global');
            $table->string('pronouns')->nullable();
            $table->string('timezone')->nullable();
            $table->string('locale')->nullable();
            $table->boolean('is_developer')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
