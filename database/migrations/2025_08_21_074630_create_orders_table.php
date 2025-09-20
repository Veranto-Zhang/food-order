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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            // $table->string('name');
            // $table->string('phone_number')->nullable();
            $table->string('table_no');
            $table->enum('payment_method', ['online_payment','pay_at_cashier'])->nullable();
            $table->string('payment_status')->nullable();
            $table->enum('order_status', ['pending','confirmed','processing','completed','canceled'])->default('pending');
            $table->date('transaction_date')->nullable();
            $table->integer('tax');
            $table->integer('total_amount');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
