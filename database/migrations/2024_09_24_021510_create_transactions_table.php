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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('no_transaksi')->primary();
            $table->date('tgl_transaksi');
            $table->string('kode_customer');
            $table->float('total');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('kode_customer')->references('kode_customer')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
