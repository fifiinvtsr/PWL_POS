<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BarangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{

    public function index()
    {
        return BarangModel::all();
    }

    public function create() {}

    public function store(Request $request)
    {

        // Validasi data, termasuk validasi untuk gambar
        $validator = Validator::make($request->all(), [
            'barang_kode' => 'required|string|max:50',
            'barang_nama' => 'required|string|max:255',
            'kategori_id' => 'required|integer',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Proses upload gambar
        $image = $request->file('image');
        $imagePath = $image->store('public/posts'); // Simpan gambar di storage

        // Buat barang baru
        $barang = BarangModel::create([
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'kategori_id' => $request->kategori_id,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            // 'image' => $request->image,
            'image' => $image->hashName(),
        ]);

        // Return response JSON jika barang berhasil dibuat
        return response()->json($barang, 201);

        $barang = BarangModel::create($request->all());
        return response()->json($barang, 201);
    }

    public function show(BarangModel $barang)
    {
        return BarangModel::find($barang);
    }

    public function edit(string $id){
        // Cari data barang berdasarkan ID
        $barang = BarangModel::find($id);

        // Jika barang tidak ditemukan, kirimkan respons error
        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Barang not found',
            ], 404);
        }

        // Kembalikan data barang sebagai respons JSON
        return response()->json([
            'success' => true,
            'barang' => $barang,
        ]);
    }

    public function update(Request $request, BarangModel $barang)
    {
        // Set validasi untuk data yang diupdate, termasuk gambar
        $validator = Validator::make($request->all(), [
            'barang_kode' => 'sometimes|string|max:50',
            'barang_nama' => 'sometimes|string|max:255',
            'kategori_id' => 'sometimes|integer',
            'harga_beli' => 'sometimes|numeric',
            'harga_jual' => 'sometimes|numeric',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Proses upload gambar jika ada gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            $oldImage = public_path('posts/' . $barang->image);
            if (file_exists($oldImage)) {
                unlink($oldImage);
            }

            // Upload gambar baru
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('posts'), $imageName);
            $barang->image = $imageName; // Simpan nama file gambar baru
        }

        // Update data barang
        $barang->update($request->except('image'));

        return response()->json([
            'success' => true,
            'barang' => $barang,
        ]);
    }

    public function destroy(BarangModel $barang)
    {
        // Hapus gambar dari storage jika ada
        if ($barang->image) {
            Storage::delete('public/posts/' . $barang->image);
        }
        // Hapus data barang
        $barang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Terhapus',
        ]);
    }
}