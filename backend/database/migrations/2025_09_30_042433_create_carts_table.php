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
        Schema::create('carts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->uuid('token')->unique();
            $table->char('currency', 3)->default('BLR')->index();

            $table->unsignedInteger('items_total_amount')->default(0);
            $table->unsignedInteger('discount_total_amount')->default(0);
            $table->unsignedInteger('shipping_total_amount')->default(0);
            $table->unsignedInteger('tax_total_amount')->default(0);
            $table->unsignedInteger('grand_total_amount')->default(0);

            $table->unsignedInteger('items_count')->default(0);
            
            $table->string('status', 20)->default('active')->index();
            $table->dateTime('expires_at')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
