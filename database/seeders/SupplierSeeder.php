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
                'supplier_kode' => 'MLG001',
                'supplier_nama' => 'Serba Guna Malang',
                'supplier_alamat' => 'Jalan Dr Cipto, Malang',
            ],
            [
                'supplier_id' => 2,
                'supplier_kode' => 'MLG002',
                'supplier_nama' => 'Serba Malang',
                'supplier_alamat' => 'Jalan Dr Cipto, Malang',
            ]
        ]; 

        DB::table('supplier')->insert($data);
    }
}