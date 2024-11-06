<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangModel;

class BarangController extends Controller
{
    public function index()
    {
        return BarangModel::all();
    }

    public function store(Request $request)
    {
        $barang = BarangModel::create($request->all());
        return response()->json($barang, 201);
    }

    public function show($id) 
    {
        $barang = BarangModel::findOrFail($id); // findOrFail akan mencari data dengan ID dan mengembalikan 404 jika tidak ditemukan
        return response()->json($barang, 200);
    }

    // Update data berdasarkan ID yang diberikan
    public function update(Request $request, $id)
    {
        $barang = BarangModel::findOrFail($id);
        $barang->update($request->all());
        return response()->json($barang, 200); // Mengembalikan data setelah diupdate
    }

    public function destroy(BarangModel $barang)
    {
        $barang->delete();
        return response()->json([
            'success' => true,
            'message' => "Data terhapus",
        ]);
    }
}