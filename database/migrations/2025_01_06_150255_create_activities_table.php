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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scope_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();

            $table->foreignId('group_id')->constrained('groups')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('position_id')->constrained('positions')->cascadeOnDelete()->cascadeOnUpdate();

            $table->integer('total_estimate');
            $table->date('forecast_date')->nullable();
            $table->date('plan_date')->nullable();
            $table->date('actual_date')->nullable();

            $table->foreignId('supervisor_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate()->comment('Get from users table');
            $table->text('description')->nullable();
            $table->integer('progress')->default(0);

            $table->foreignId('status_id')->nullable()->constrained('status_activities')->nullOnDelete()->cascadeOnUpdate();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
