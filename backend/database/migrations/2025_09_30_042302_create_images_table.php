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
        Schema::create('images', function (Blueprint $table) {
            $table->id();

            //polimórfico
            $table->string('imageable_type', 100);
            $table->unsignedBigInteger('imageable_id');

            //arquivo
            $table->string('disk', 50)->default('public');
            $table->string('path', 2048);

            //metadados
            $table->unsignedSmallInteger('position')->default(0);
            $table->string('alt', 255)->nullable();

            $table->timestamps();

            $table->index(['imageable_type', 'imageable_id', 'position'], 'idx_image_owner_pos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
