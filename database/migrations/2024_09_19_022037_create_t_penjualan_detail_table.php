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
        Schema::create('t_penjualan_detail', function (Blueprint $table) {
            $table->bigIncrements('detail_id'); // Menambahkan kolom detail_id
            $table->bigInteger('penjualan_id')->unsigned(); // Menambahkan kolom penjualan_id
            $table->bigInteger('barang_id')->unsigned(); // Menambahkan kolom barang_id
            $table->integer('harga'); // Menambahkan kolom harga
            $table->integer('jumlah'); // Menambahkan kolom jumlah
            $table->timestamps(); // Menambahkan kolom created_at dan updated_at

            $table->foreign('barang_id')->references('barang_id')->on('m_barang');
            $table->foreign('penjualan_id')->references('penjualan_id')->on('t_penjualan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_penjualan_detail', function (Blueprint $table) {
            //
        });
    }
};