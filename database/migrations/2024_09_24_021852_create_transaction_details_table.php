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
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->string('no_transaksi',5);
            $table->date('tgl_transaksi');
            $table->string('kode_barang',);
            $table->integer('urut');
            $table->integer('qty')->nullable();
            $table->float('harga')->nullable();
            $table->timestamps();

            $table->primary(['no_transaksi', 'tgl_transaksi','kode_barang', 'urut']); 
            $table->foreign('no_transaksi')->references('no_transaksi')->on('transaksi')->onDelete('cascade');
            $table->foreign('kode_barang')->references('kode_barang')->on('barang')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi');
    }
};
