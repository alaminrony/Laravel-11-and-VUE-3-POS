<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {

        Schema::create('supplier_ledgers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade'); // Foreign key to suppliers
            $table->date('transaction_date');
            $table->float('debit', 15, 2)->nullable(); // Amount paid to the supplier
            $table->float('credit', 15, 2)->nullable(); // Amount owed (e.g., cost of a purchase)
            $table->float('balance', 15, 2); // Calculated balance for the supplier
            $table->string('remarks')->nullable();

            // For soft deletes
            $table->softDeletes();
            $table->timestamps();

            // Add indexing
            $table->index('supplier_id');
            $table->index('transaction_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_ledgers');
    }
};
