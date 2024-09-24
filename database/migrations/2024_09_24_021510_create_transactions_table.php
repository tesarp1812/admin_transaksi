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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->string('no_transaksi', 5);
            $table->date('tgl_transaksi');
            $table->string('kode_customer', 5)->nullable();
            $table->float('total')->nullable();
            $table->string('keterangan', 200)->nullable();
            $table->timestamps();
        
            $table->primary(['no_transaksi', 'tgl_transaksi']); 
            $table->foreign('kode_customer')->references('kode_customer')->on('customer')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            // Hapus kunci asing sebelum menghapus tabel
            $table->dropForeign(['kode_customer']);
        });

        Schema::dropIfExists('transaksi');
    }
};
