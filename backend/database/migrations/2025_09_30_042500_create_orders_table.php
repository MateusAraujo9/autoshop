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

            $table->string('number', 32)->unique();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->foreignUuid('cart_id')->nullable()->constrained()->nullOnDelete();

            $table->char('currency', 3)->default('BLR')->index();

            $table->json('shipping_address_json')->nullable();
            $table->json('billing_address_json')->nullable();

            $table->unsignedInteger('items_total_amount')->default(0);
            $table->unsignedInteger('discount_total_amount')->default(0);
            $table->unsignedInteger('shipping_total_amount')->default(0);
            $table->unsignedInteger('tax_total_amount')->default(0);
            $table->unsignedInteger('grand_total_amount')->default(0);

            $table->string('status', 20)->default('pending')->index();

            $table->dateTime('placed_at')->nullable()->index();
            $table->timestamps();

            $table->index(['customer_id', 'status']);
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
