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
        Schema::create('gambar_varians', function (Blueprint $table) {
    $table->id();

    $table->foreignId('id_varian')
        ->constrained('varians')
        ->cascadeOnDelete();

    $table->string('path_gambar');
    $table->boolean('is_primary')->default(false);

    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gambar_varians');
    }
};
