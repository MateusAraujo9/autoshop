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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();

            $table->string('provider', 30);                 // ex.: mercadopago, stripe, pix
            $table->string('method', 20)->nullable();       // ex.: card, pix, boleto
            $table->string('status', 20)->default('created')->index(); // created|authorized|captured|failed|refunded|canceled

            $table->char('currency', 3)->default('BRL')->index();
            $table->unsignedInteger('amount');              // valor pretendido (centavos)
            $table->unsignedInteger('authorized_amount')->default(0);
            $table->unsignedInteger('captured_amount')->default(0);
            $table->unsignedInteger('refunded_amount')->default(0);

            $table->string('external_id', 100)->nullable();     // id no PSP
            $table->string('idempotency_key', 120)->nullable(); // p/ replays seguros

            $table->json('raw_payload')->nullable();
            $table->string('error_code', 60)->nullable();
            $table->string('error_message', 255)->nullable();

            $table->dateTime('authorized_at')->nullable()->index();
            $table->dateTime('captured_at')->nullable()->index();
            $table->dateTime('failed_at')->nullable()->index();
            $table->dateTime('refunded_at')->nullable()->index();
            $table->dateTime('canceled_at')->nullable()->index();

            $table->timestamps();

            $table->unique(['provider','external_id']);     // evita duplicar a mesma transação
            $table->unique('idempotency_key');              // previne replays
            $table->index(['order_id','status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
