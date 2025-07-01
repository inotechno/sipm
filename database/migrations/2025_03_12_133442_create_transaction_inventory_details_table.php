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
        Schema::create('transaction_inventory_details', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('transaction_inventory_id')->constrained('transaction_inventories')->cascadeOnDelete();
            $table->foreignId('inventory_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity')->default(1);
            $table->enum('condition', ['good', 'bad', 'broken'])->default('good');

            $table->date('borrow_date')->nullable();
            $table->date('return_date')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_inventory_details');
    }
};
