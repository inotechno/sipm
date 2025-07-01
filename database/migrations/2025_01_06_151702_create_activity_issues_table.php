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
        Schema::create('activity_issues', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('activity_id')->constrained('activities')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('category_dependency_id')->constrained('category_dependencies')->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('percentage_dependency')->default(0);
            $table->text('description')->nullable();
            $table->integer('percentage_solution')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_issues');
    }
};
