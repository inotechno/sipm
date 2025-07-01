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
        Schema::create('monitoring_presents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('shift_id')->constrained('shifts')->cascadeOnDelete()->cascadeOnUpdate();
            $table->dateTime('datetime');
            $table->enum('type', ['in', 'in_break', 'out'])->default('in');
            $table->foreignId('group_id')->nullable()->constrained('groups')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('role', 100)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring_presents');
    }
};
