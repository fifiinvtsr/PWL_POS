<?php

namespace App\Http\Controllers;

use App\Models\PenjualanDetailModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PenjualanDetailController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar penjualan_detail',
            'list' => ['Home', 'penjualan_detail']
        ];

        $page = (object)[
            'title' => 'Daftar penjualan_detail yang terdaftar dalam sistem'
        ];

        $activeMenu = 'penjualan_detail';

        $penjualan_detail = PenjualanDetailModel::all();

        return view('penjualan_detail.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'penjualan_detail' => $penjualan_detail, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $penjualan_details = PenjualanDetailModel::select('detail_id','harga','jumlah','penjualan_id','barang_id')
        ->with(['penjualan, barang']);

        if ($request->penjualan_id) {
            $penjualan_details->where('penjualan_id', $request->penjualan_id);
        }

        return DataTables::of($penjualan_details)
            ->addIndexColumn()
            ->addColumn('action', function ($penjualan_detail) {
                $btn  = '<a href="' . url('/penjualan_detail/' . $penjualan_detail->penjualan_detail_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/penjualan_detail/' . $penjualan_detail->penjualan_detail_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/penjualan_detail/' . $penjualan_detail->penjualan_detail_id) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah penjualan_detail',
            'list' => ['Home', 'penjualan_detail', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah penjualan_detail baru'
        ];

        $penjualan_detail = PenjualanDetailModel::all();
        $activeMenu = 'penjualan_detail';

        return view('penjualan_detail.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'penjualan_detail' => $penjualan_detail, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'penjualan_id' => 'required|integer',
            'barang_id' => 'required|integer',
            'harga' => 'required|numeric',
            'jumlah' => 'required|numeric'
        ]);

        PenjualanDetailModel::create([
            'penjualan_id' => $request->penjualan_id,
            'barang_id' => $request->barang_id,
            'harga' => $request->harga,
            'jumlah' => $request->jumlah,
        ]);

        return redirect('/penjualan_detail')->with('success', 'Data penjualan_detail berhasil ditambahkan');
    }

    public function show($id)
    {
        $penjualan_detail = PenjualanDetailModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail penjualan_detail',
            'list' => ['Home', 'penjualan_detail', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail penjualan_detail'
        ];

        $activeMenu = 'penjualan_detail';

        return view('penjualan_detail.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'penjualan_detail' => $penjualan_detail, 'activeMenu' => $activeMenu]);
    }

    public function edit($id)
    {
        $penjualan_detail = PenjualanDetailModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit penjualan_detail',
            'list' => ['Home', 'penjualan_detail', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit penjualan_detail'
        ];

        $activeMenu = 'penjualan_detail';

        return view('penjualan_detail.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'penjualan_detail' => $penjualan_detail, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'penjualan_id' => 'required|integer',
            'barang_id' => 'required|integer',
            'harga' => 'required|numeric',
            'jumlah' => 'required|numeric'
        ]);

        PenjualanDetailModel::find($id)->update([
            'penjualan_id' => $request->penjualan_id,
            'barang_id' => $request->barang_id,
            'harga' => $request->harga,
            'jumlah' => $request->jumlah,
        ]);
        return redirect('/penjualan_detail')->with('success', 'Data penjualan_detail berhasil diubah');
    }

    public function destroy($id)
    {
        $check = PenjualanDetailModel::find($id);

        if (!$check) {
            return redirect('/penjualan_detail')->with('error', 'Data penjualan_detail tidak ditemukan');
        }

        try {
            PenjualanDetailModel::destroy($id);

            return redirect('/penjualan_detail')->with('success', 'Data penjualan_detail berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/penjualan_detail')->with('error', 'Data penjualan_detail gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}