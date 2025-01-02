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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('SKU')->unique(); // Unique index
            $table->float('price', 10, 2); // Default price per unit
            $table->unsignedInteger('initial_stock_quantity')->default(0);
            $table->unsignedInteger('current_stock_quantity')->default(0);
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null'); // Foreign key with cascade on delete

            $table->softDeletes(); // For soft deletes
            $table->timestamps(); // Created at and updated at

            // Additional indexes
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
