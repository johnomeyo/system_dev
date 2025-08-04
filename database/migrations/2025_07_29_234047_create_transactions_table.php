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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); // A unique number for each transaction
            $table->string('description'); // What the transaction is for (e.g., "Buying candy")
            $table->decimal('amount', 8, 2); // How much money (e.g., 5.00)
            $table->enum('type', ['income', 'expense']); // Is it money coming in or going out?
            $table->timestamps(); // When you added it and when it was changed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
