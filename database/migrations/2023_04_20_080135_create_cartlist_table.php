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
        Schema::create('cartlist', function (Blueprint $table) {
            $table->id();
            $table->foreignId('products_id')->references('id')->on('products')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('stocks_id')->references('id')->on('stocks')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_id')->references('id')->on('users')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cartlist');
    }
};
