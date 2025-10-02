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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();

            $table->string('carrier', 40);          // correios, jadlog, ...
            $table->string('service', 40)->nullable(); // PAC, SEDEX, etc.
            $table->string('tracking_code', 80)->nullable()->index();

            $table->string('status', 20)->default('pending')->index(); // pending|ready|in_transit|delivered|returned|canceled
            $table->char('currency', 3)->default('BRL');
            $table->unsignedInteger('cost_amount')->default(0);

            $table->string('location', 50)->default('default'); // origem (caso multi-warehouse)

            $table->json('metadata')->nullable();   // url etiqueta, pdf, obs etc.

            $table->dateTime('shipped_at')->nullable()->index();
            $table->dateTime('delivered_at')->nullable()->index();
            $table->dateTime('returned_at')->nullable()->index();
            $table->dateTime('canceled_at')->nullable()->index();

            $table->timestamps();
            $table->index(['order_id','status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
