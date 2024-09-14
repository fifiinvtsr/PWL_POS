<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 

class PenjualanSeeder extends Seeder
{

    public function run(): void
    {
        $data = [
            [
                'penjualan_id' => 1,
                'user_id' => 3,
                'pembeli' => 'Adam',
                'penjualan_kode' => 'TRS001',
                'tanggal' => Carbon::create(2024, 9, 12)
            ],
            [
                'penjualan_id' => 2,
                'user_id' => 3,
                'pembeli' => 'Eve',
                'penjualan_kode' => 'TRS002',
                'tanggal' => Carbon::create(2024, 9, 13)
            ]
        ]; 

        DB::table('penjualan')->insert($data); 
    }
}