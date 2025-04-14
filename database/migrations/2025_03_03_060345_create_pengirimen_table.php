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
        Schema::create('pengiriman', function (Blueprint $table) {
            $table->id('id_kirim');
            $table->string('kode_kirim');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id_user')->on('user');
            $table->unsignedBigInteger('transaksi_id');
            $table->foreign('transaksi_id')->references('id_transaksi')->on('catatan_transaksi');
            $table->string('tujuan'); // Tujuan pengiriman
            $table->enum('status', ['PENDING', 'VERIFIED','REJECTED'])->default('PENDING'); // Status pengiriman
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengiriman');
    }
};
