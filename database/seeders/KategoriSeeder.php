<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder{
    public function run(): void
    {
        $data = [
            [
                'kategori_id' => 1,
                'kategori_kode' => 'KD001',
                'kategori_nama' => 'Minuman',
            ],
            [
                'kategori_id' => 2,
                'kategori_kode' => 'KD002',
                'kategori_nama' => 'Makanan',
            ],
            [
                'kategori_id' => 3,
                'kategori_kode' => 'KD003',
                'kategori_nama' => 'Pakaian',
            ],
            [
                'kategori_id' => 4,
                'kategori_kode' => 'KD004',
                'kategori_nama' => 'Kendaraan',
            ],
            [
                'kategori_id' => 5,
                'kategori_kode' => 'KD005',
                'kategori_nama' => 'Peralatan',
            ],
        ];
        DB::table('m_kategori') -> insert($data);
    }
}