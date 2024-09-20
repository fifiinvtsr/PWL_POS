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
        Schema::create('t_penjualan', function (Blueprint $table) {
            $table->bigIncrements('penjualan_id'); // Menambahkan kolom penjualan_id
            $table->bigInteger('user_id')->unsigned(); // Menambahkan kolom user_id
            $table->string('pembeli', 50); // Menambahkan kolom pembeli
            $table->string('penjualan_kode', 20); // Menambahkan kolom penjualan_kode
            $table->dateTime('penjualan_tanggal'); // Menambahkan kolom penjualan_tanggal
            $table->timestamps(); // Menambahkan kolom created_at dan updated_at

            $table->foreign('user_id')->references('user_id')->on('m_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_penjualan', function (Blueprint $table) {
            //
        });
    }
};