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
        Schema::create('varians', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_produk')
            ->constrained('produks')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

        $table->string('nama_varian');
        $table->decimal('harga', 15, 2);
        $table->integer('stok');

    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('varians');
    }
};
