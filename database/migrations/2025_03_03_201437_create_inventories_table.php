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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_id')->constrained('category_inventories')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('warehouse_id')->constrained('warehouses')->cascadeOnDelete()->cascadeOnUpdate();

            $table->string('serial_number')->nullable();
            $table->date('purchase_date')->nullable();
            $table->enum('condition', ['New', 'Used', 'Broken'])->nullable();

            $table->decimal('price', 10, 2)->nullable();
            $table->string('image_path')->nullable();
            $table->string('image_url')->nullable();

            $table->enum('type', ['Asset', 'Consumable', 'Service'])->nullable();

            $table->text('description')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
