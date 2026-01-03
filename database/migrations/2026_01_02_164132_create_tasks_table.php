<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('project_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');
            $table->unsignedInteger('priority')->nullable();

            $table->timestamps();

            $table->index('project_id', 'idx_tasks_project');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
