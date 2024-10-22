<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data=[
            [
                'penjualan_id' => 1,
                'user_id' => 3,
                'pembeli' => 'Andreas',
                'penjualan_kode' => 'TRS001',
                'penjualan_tanggal'=> Carbon::create(2024,7,11)
            ],
            [
                'penjualan_id' => 2,
                'user_id' => 3,
                'pembeli' => 'Afifah',
                'penjualan_kode' => 'TRS002',
                'penjualan_tanggal'=> Carbon::create(2024,7,12)
            ],
            [
                'penjualan_id' => 3,
                'user_id' => 3,
                'pembeli' => 'Dyah',
                'penjualan_kode' => 'TRS003',
                'penjualan_tanggal'=> Carbon::create(2024,7,13)
            ],
            [
                'penjualan_id' => 4,
                'user_id' => 3,
                'pembeli' => 'Rifqi',
                'penjualan_kode' => 'TRS004',
                'penjualan_tanggal'=> Carbon::create(2024,7,14)
            ],
            [
                'penjualan_id' => 5,
                'user_id' => 3,
                'pembeli' => 'Nabila',
                'penjualan_kode' => 'TRS005',
                'penjualan_tanggal'=> Carbon::create(2024,7,15)
            ],
            [
                'penjualan_id' => 6,
                'user_id' => 3,
                'pembeli' => 'Fafa',
                'penjualan_kode' => 'TRS006',
                'penjualan_tanggal'=> Carbon::create(2024,7,16)
            ],
            [
                'penjualan_id' => 7,
                'user_id' => 3,
                'pembeli' => 'Fifi',
                'penjualan_kode' => 'TRS007',
                'penjualan_tanggal'=> Carbon::create(2024,7,17)
            ],
            [
                'penjualan_id' => 8,
                'user_id' => 3,
                'pembeli' => 'Ifa',
                'penjualan_kode' => 'TRS008',
                'penjualan_tanggal'=> Carbon::create(2024,7,18)
            ],
            [
                'penjualan_id' => 9,
                'user_id' => 3,
                'pembeli' => 'Wildan',
                'penjualan_kode' => 'TRS009',
                'penjualan_tanggal'=> Carbon::create(2024,7,19)
            ],
            [
                'penjualan_id' => 10,
                'user_id' => 3,
                'pembeli' => 'Nasywa',
                'penjualan_kode' => 'TRS010',
                'penjualan_tanggal'=> Carbon::create(2024,7,20)
            ]
            
        ];
        DB::table('t_penjualan') -> insert($data);
    }
}