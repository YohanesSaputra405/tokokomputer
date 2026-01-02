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
        Schema::table('varians', function (Blueprint $table) {
        $table->boolean('is_diskon')->default(false)->after('harga');
        $table->enum('diskon_tipe', ['persen', 'nominal'])->nullable();
        $table->integer('diskon_nilai')->nullable();
        $table->dateTime('diskon_mulai')->nullable();
        $table->dateTime('diskon_selesai')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('varians', function (Blueprint $table) {
            $table->dropColumn([
                'is_diskon',
                'diskon_tipe',
                'diskon_nilai',
                'diskon_mulai',
                'diskon_selesai'
            ]);
        });
    }
};
