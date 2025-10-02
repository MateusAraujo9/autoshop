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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 60)->nullable();
            $table->string('recipient', 150);
            $table->string('line1', 120);
            $table->string('number', 20)->nullable();
            $table->string('complement', 60)->nullable();
            $table->string('district', 80)->nullable();
            $table->string('city', 80);
            $table->string('region', 2);
            $table->string('postal_code', 12);
            $table->string('contry', 2)->default('BR');
            $table->timestamps();

            $table->index('postal_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
