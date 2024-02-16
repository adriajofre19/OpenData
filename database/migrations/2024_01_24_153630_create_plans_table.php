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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->tinyInteger('status')->default(0);
            $table->date('start_date');
            $table->date('end_date');
            $table->foreignId('id_category')->nullable()->constrained('categories');
            $table->foreignId('id_user')->nullable()->constrained('users');
            $table->timestamps();
            $table->string('image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
