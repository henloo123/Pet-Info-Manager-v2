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
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Pet's name
            $table->string('species'); // Pet's species (e.g., dog, cat)
            $table->string('breed')->nullable(); // Pet's breed
            $table->date('date_of_birth')->nullable(); // Pet's date of birth
            $table->decimal('weight', 5, 2)->nullable(); // Pet's weight in kg

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
