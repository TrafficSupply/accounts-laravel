<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ts_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('locale');
            $table->string('theme');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ts_users');
    }
};
