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
        Schema::create('penerimaan_detail', function (Blueprint $table) {
            $table->id('id_terima_detail');
            $table->string('kode_terima_detail');
            $table->unsignedBigInteger('barang_id');
            $table->foreign('barang_id')->references('id_barang')->on('barang');
            $table->unsignedBigInteger('terima_id');
            $table->foreign('terima_id')->references('id_terima')->on('penerimaan');
            $table->integer('jumlah'); // Jumlah barang yang diterima
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerimaan_detail');
    }
};
