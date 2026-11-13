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
        Schema::create('notes_task', function (Blueprint $table) {
            $table->id();
            $table->string('task_name');
            $table->boolean('status')->default(false);
            $table->foreignId('notes_id')
                ->constrained('notes')
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('notes_task');
    }
};
