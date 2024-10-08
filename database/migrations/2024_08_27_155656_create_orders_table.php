<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('order_id')->unique();
        $table->string('address');
        $table->string('phone');
        $table->string('payment_type');
        $table->decimal('total', 10, 2);
        $table->decimal('sgst', 10, 2);
        $table->decimal('cgst', 10, 2);
        $table->decimal('delivery', 10, 2);
        $table->decimal('discount', 10, 2)->nullable();

        $table->decimal('grand_total', 10, 2);
        $table->enum('status', ['pending', 'complete', 'declined', 'running', 'returning', 'returned'])->default('pending');
        $table->string('bank_name')->nullable();
        $table->string('account_number')->nullable();
        $table->string('ifsc_code')->nullable();
        $table->text('return_reason')->nullable();
        $table->timestamps();
    });
    
    
}

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
