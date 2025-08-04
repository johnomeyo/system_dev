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
        Schema::table('transactions', function (Blueprint $table) {
            // This adds a column called 'user_id' that will store numbers
            // It also makes sure this number always matches an 'id' in the 'users' table
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // This removes the 'user_id' column if we ever need to go back
            $table->dropForeign(['user_id']); // First remove the special link
            $table->dropColumn('user_id');    // Then remove the column
        });
    }
};
