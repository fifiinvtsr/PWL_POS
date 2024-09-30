<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'supplier_id' => 1,
                'supplier_kode' => 'SPR001',
                'supplier_nama' => 'Serba Guna Malang',
                'supplier_alamat' => 'Jalan Dr Cipto, Malang',
            ],
            [
                'supplier_id' => 2,
                'supplier_kode' => 'SPR002',
                'supplier_nama' => 'Serba Malang',
                'supplier_alamat' => 'Jalan Dr Cipto, Malang',
            ],
            [
                'supplier_id' => 3,
                'supplier_kode' => 'SPR003',
                'supplier_nama' => 'Surabaya Perkasa',
                'supplier_alamat' => 'Jalan Ahmad Yani, Surabaya',
            ],
            [
                'supplier_id' => 4,
                'supplier_kode' => 'SPR004',
                'supplier_nama' => 'Karya Sejahtera Surabaya',
                'supplier_alamat' => 'Jalan Basuki Rahmat, Surabaya',
            ],
            [
                'supplier_id' => 5,
                'supplier_kode' => 'SPR005',
                'supplier_nama' => 'Jakarta Supplier Jaya',
                'supplier_alamat' => 'Jalan Thamrin, Jakarta',
            ],
        ]; 

        DB::table('m_supplier')->insert($data);
    }
}
