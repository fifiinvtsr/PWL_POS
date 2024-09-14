<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StokSeeder extends Seeder
{

    public function run(): void
    {
        $data = [
            [
                'stok_id' => 1,
                'supplier_id' => 1,
                'barang_id' => 1,
                'user_id' => 2,
                'stok_tanggal' => Carbon::create('2024', '9', '12'),
                'stok_jumlah' => 1000
            ],
            [
                'stok_id' => 2,
                'supplier_id' => 2,
                'barang_id' => 1,
                'user_id' => 2,
                'stok_tanggal' => Carbon::create('2024', '9', '12'),
                'stok_jumlah' => 2000
            ]
        ]; // Close the $data array with a semicolon

        DB::table('stok')->insert($data); // Insert data into the stok table
    }
}