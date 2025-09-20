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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug');
            $table->string('thumbnail');
            $table->text('description');
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->integer('price');
            $table->boolean('is_promo')->default(false);
            $table->unsignedTinyInteger('percent')->nullable();
            $table->integer('price_after_discount')->nullable();
            $table->unsignedBigInteger('sold_count')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
