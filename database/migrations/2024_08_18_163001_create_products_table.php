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
            $table->decimal('quantity', 8, 2); // Adjust the precision and scale as needed

            $table->decimal('price', 8, 2); // Adjust the precision and scale as needed
            $table->text('description');
            $table->string('Discount')->nullable();

            $table->string('company');
            $table->string('type');
            $table->string('image')->nullable();
            $table->string('warranty');  // Store the image path
            $table->timestamps();
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
