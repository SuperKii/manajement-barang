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
        Schema::create('pengiriman_detail', function (Blueprint $table) {
            $table->id('id_kirim_detail');
            $table->string('kode_kirim_detail');
            $table->unsignedBigInteger('barang_id');
            $table->foreign('barang_id')->references('id_barang')->on('barang');
            $table->unsignedBigInteger('kirim_id');
            $table->foreign('kirim_id')->references('id_kirim')->on('pengiriman');
            $table->integer('jumlah'); // Jumlah barang yang dikirim
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengiriman_detail');
    }
};
