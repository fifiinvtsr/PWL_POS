<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{

    public function run(): void
    {
        $data = [
            [
                'barang_id' => 1,
                'kategori_id' => 1,
                'barang_kode' => 'INDOFOO001',
                'barang_nama' => 'Indomie Goreng',
                'harga_beli' => 2200,
                'harga_jual' => 2500,
            ]
            ];
            DB::table('barang')->insert($data);
    }
}
