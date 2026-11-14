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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('background_path')->nullable();
            $table->boolean('status')->default(false);
            $table->foreignId('id_categories')
                ->nullable()
                ->constrained('categories')
                ->cascadeOnDelete();
            $table->foreignId('id_user')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->timestamp('create_at');
            $table->timestamp('update_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('notes');
    }
};
