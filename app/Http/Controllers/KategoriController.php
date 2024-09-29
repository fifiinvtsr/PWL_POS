<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel; 
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    public function index() {
        $breadcrumb = (object)[
            'title' => 'Daftar kategori barang',
            'list' => ['Home', 'kategori']
        ];
        $page = (object)[
            'title' => 'Daftar kategori barang yang terdaftar dalam sistem'
        ];
        $activeMenu = 'kategori';
        $kategori = KategoriModel::all(); 
        return view('kategori.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'kategori' => $kategori
        ]);
    }

    public function list(Request $request) {
        $kategori = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama'); 
        if ($request->kategori_id) {
            $kategori->where('kategori_id', $request->kategori_id);
        }
        return DataTables::of($kategori)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kategori) {
                $btn = '<a href="' . url('/kategori/' . $kategori->kategori_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/kategori/' . $kategori->kategori_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/kategori/' . $kategori->kategori_id) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create() {
        $breadcrumb = (object)[
            'title' => 'Tambah kategori barang',
            'list' => ['Home', 'kategori', 'tambah']
        ];
        $page = (object)[
            'title' => 'Tambah kategori barang baru'
        ];
        $activeMenu = 'kategori';
        return view('kategori.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode',
            'kategori_nama' => 'required|string|max:100'
        ]);
        KategoriModel::create([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
        ]);
        return redirect('/kategori')->with('success', 'Data kategori berhasil disimpan');
    }

    public function show(string $kategori_id) {
        $kategori = KategoriModel::find($kategori_id); 
        $breadcrumb = (object)[
            'title' => 'Detail Kategori',
            'list' => ['Home', 'kategori', 'detail']
        ];
        $page = (object)[
            'title' => 'Detail kategori'
        ];
        $activeMenu = 'kategori';
        return view('kategori.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'kategori' => $kategori
        ]);
    }

    public function edit(string $kategori_id) {
        $kategori = KategoriModel::find($kategori_id); 

        $breadcrumb = (object)[
            'title' => 'Edit kategori',
            'list' => ['Home', 'kategori', 'edit']
        ];
        $page = (object)[
            'title' => 'Edit kategori'
        ];
        $activeMenu = 'kategori';
        return view('kategori.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'kategori' => $kategori
        ]);
    }

    public function update(Request $request, string $kategori_id) {
        $request->validate([
            'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode,' . $kategori_id . ',kategori_id', // Pastikan validasi unik mencakup pengecualian untuk kategori yang sedang diperbarui
            'kategori_nama' => 'required|string|max:100'
        ]);
        $kategori = KategoriModel::find($kategori_id); 
        $kategori->update([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama
        ]);
        return redirect('/kategori')->with('success', 'Data kategori berhasil diperbarui');
    }

    public function destroy(string $kategori_id) {
        $check = KategoriModel::find($kategori_id); 
        if (!$check) {
            return redirect('/kategori')->with('error', 'Data kategori tidak ditemukan');
        }
        try {
            KategoriModel::destroy($kategori_id); 
            return redirect('/kategori')->with('success', 'Data kategori berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/kategori')->with('error', 'Data kategori gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}