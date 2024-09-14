<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{

    public function run(): void
    {
        $data = [
            [
                'kategori_id' => 1,
                'kategori_kode' => 'MKN',
                'kategori_nama' => 'Makanan',

            ],
            [
                'kategori_id' => 2,
                'kategori_kode' => 'MNM',
                'kategori_nam' => 'Minuman',
            ]
            ];
            DB::table('kategori')->insert($data);
    }
}
