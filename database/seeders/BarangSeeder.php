<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // Kategori 1: Makanan
            [
                'barang_id' => 1,
                'kategori_id' => 1,
                'barang_kode' => 'BRK001',
                'barang_nama' => 'Indomie Goreng',
                'harga_beli' => 2200,
                'harga_jual' => 2500,
            ],
            [
                'barang_id' => 2,
                'kategori_id' => 1,
                'barang_kode' => 'BRK002',
                'barang_nama' => 'Roti Bakar',
                'harga_beli' => 1500,
                'harga_jual' => 2000,
            ],
            [
                'barang_id' => 3,
                'kategori_id' => 1,
                'barang_kode' => 'BRK003',
                'barang_nama' => 'Mie Instan',
                'harga_beli' => 2500,
                'harga_jual' => 3000,
            ],
            [
                'barang_id' => 4,
                'kategori_id' => 1,
                'barang_kode' => 'BRK004',
                'barang_nama' => 'Snack Keripik',
                'harga_beli' => 3000,
                'harga_jual' => 3500,
            ],
            [
                'barang_id' => 5,
                'kategori_id' => 1,
                'barang_kode' => 'BRK005',
                'barang_nama' => 'Susu UHT',
                'harga_beli' => 4000,
                'harga_jual' => 4500,
            ],
            // Kategori 2: Minuman
            [
                'barang_id' => 6,
                'kategori_id' => 2,
                'barang_kode' => 'BRK006',
                'barang_nama' => 'Teh Botol',
                'harga_beli' => 2500,
                'harga_jual' => 3000,
            ],
            [
                'barang_id' => 7,
                'kategori_id' => 2,
                'barang_kode' => 'BRK007',
                'barang_nama' => 'Air Mineral',
                'harga_beli' => 1000,
                'harga_jual' => 1500,
            ],
            [
                'barang_id' => 8,
                'kategori_id' => 2,
                'barang_kode' => 'BRK008',
                'barang_nama' => 'Jus Jeruk',
                'harga_beli' => 5000,
                'harga_jual' => 6000,
            ],
            [
                'barang_id' => 9,
                'kategori_id' => 2,
                'barang_kode' => 'BRK009',
                'barang_nama' => 'Kopi Instan',
                'harga_beli' => 3000,
                'harga_jual' => 3500,
            ],
            [
                'barang_id' => 10,
                'kategori_id' => 2,
                'barang_kode' => 'BRK010',
                'barang_nama' => 'Soda',
                'harga_beli' => 4000,
                'harga_jual' => 4500,
            ],
            // Kategori 3: Pakaian
            [
                'barang_id' => 11,
                'kategori_id' => 3,
                'barang_kode' => 'BRK011',
                'barang_nama' => 'Kaos Polos',
                'harga_beli' => 30000,
                'harga_jual' => 35000,
            ],
            [
                'barang_id' => 12,
                'kategori_id' => 3,
                'barang_kode' => 'BRK012',
                'barang_nama' => 'Jaket',
                'harga_beli' => 70000,
                'harga_jual' => 80000,
            ],
            [
                'barang_id' => 13,
                'kategori_id' => 3,
                'barang_kode' => 'BRK013',
                'barang_nama' => 'Celana Jeans',
                'harga_beli' => 50000,
                'harga_jual' => 60000,
            ],
            [
                'barang_id' => 14,
                'kategori_id' => 3,
                'barang_kode' => 'BRK014',
                'barang_nama' => 'Kemeja',
                'harga_beli' => 45000,
                'harga_jual' => 50000,
            ],
            [
                'barang_id' => 15,
                'kategori_id' => 3,
                'barang_kode' => 'BRK015',
                'barang_nama' => 'Dress',
                'harga_beli' => 60000,
                'harga_jual' => 70000,
            ],
        ];

        DB::table('m_barang')->insert($data);
    }
}
