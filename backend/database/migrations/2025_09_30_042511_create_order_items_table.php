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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('product_variant_id')->constrained('products_variants')->restrictOnDelete();

            $table->string('sku', 64)->index();
            $table->string('name', 255);
            $table->json('attributes')->nullable();

            $table->unsignedInteger('qty');
            $table->unsignedInteger('unit_amount');
            $table->unsignedInteger('total_amount');

            $table->timestamps();
            
            $table->index(['order_id', 'product_variant_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
