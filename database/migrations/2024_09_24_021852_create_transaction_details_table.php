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
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->uuid('id_transaksi');
            $table->string('no_transaksi');
            $table->date('tgl_transaksi');
            $table->string('kode_barang');
            $table->integer('urut');
            $table->integer('qty');
            $table->float('harga');
            $table->timestamps();

            $table->foreign('no_transaksi')->references('no_transaksi')->on('transactions')->onDelete('cascade');
            $table->foreign('kode_barang')->references('kode_barang')->on('items')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_details');
    }
};
