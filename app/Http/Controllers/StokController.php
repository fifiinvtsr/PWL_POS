<?php
namespace App\Http\Controllers;
use App\Models\BarangModel;
use App\Models\SupplierModel;
use App\Models\StokModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;

class StokController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Stok',
            'list' => ['Home', 'Stok']
        ];

        $page = (object) [
            'title' => 'Daftar stok yang terdaftar dalam sistem'
        ];

        $activeMenu = 'stok';

        $supplier = SupplierModel::all();
        $barang = BarangModel::all();
        $user = UserModel::all();

        return view('stok.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'supplier' => $supplier, 'barang' => $barang, 'user' => $user, 'activeMenu' => $activeMenu]);
    }
    
    //Ambil data stok dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $user = UserModel::all();
        $stok = StokModel::select('stok_id', 'supplier_id', 'barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah')
            ->with('supplier')
            ->with('barang')
            ->with('user');
            
        // filter data stok
        if ($request->supplier_id) {
            $stok->where('supplier_id', $request->supplier_id);
        }
        if ($request->barang_id) {
            $stok->where('barang_id', $request->barang_id);
        }
        if ($request->user_id) {
            $stok->where('user_id', $request->user_id);
        }
        
        return DataTables::of($stok)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($stok) { // menambahkan kolom aksi
                $btn = '<button onclick="modalAction(\''.url('/stok/' . $stok->stok_id .'/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/stok/' . $stok->stok_id .'/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/stok/' . $stok->stok_id .'/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    //Menampilkan laman tambah stok 
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Stok',
            'list' => ['Home', 'Stok', 'Tambah']
        ];
        $page = (object) [
            'title' => 'Tambah Stok Baru'
        ];
        $supplier = SupplierModel::select('supplier_id', 'supplier_nama')->get();
        $barang = BarangModel::select('barang_id', 'barang_nama')->get();
        $user = UserModel::select('user_id', 'nama')->get();
        $activeMenu = 'stok';
        return view('stok.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'supplier' => $supplier, 'barang' => $barang, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    //Menyimpan data stok baru
    public function store(Request $request)
    {
        $request->validate([
            'stok_tanggal'  => 'required|date', 
            'stok_jumlah'   => 'required|integer',
            'supplier_id'   => 'required|integer',
            'barang_id'     => 'required|integer',
            'user_id'       => 'required|integer'
        ]);
        StokModel::create([
            'stok_tanggal'  => $request-> stok_tanggal,
            'stok_jumlah'   => $request-> stok_jumlah,
            'supplier_id'   => $request-> supplier_id,
            'barang_id'     => $request-> barang_id,
            'user_id'       => $request-> user_id,
        ]);
        return redirect('/stok')->with('success', 'Data stok berhasil disimpan!');
    }

    //Menampilkan laman detil stok
    public function show(string $id)
    {
        $stok = StokModel::with('supplier')->find($id);
        $breadcrumb = (object) [
            'title' => 'Detail Stok', 
            'list' => ['Home', 'Stok', 'Detail']];
        $page = (object) [
            'title' => 'Detail Stok'];
        $activeMenu = 'stok'; // set menu yang sedang aktif
        return view('stok.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'stok' => $stok, 'activeMenu' => $activeMenu]);
    }

    //Menampilkan laman edit stok 
    public function edit(string $id)
    {
        $stok = StokModel::find($id);
        $supplier = SupplierModel::all();
        $barang = BarangModel::all();
        $user = UserModel::all();
        $breadcrumb = (object) [
            'title' => 'Edit Stok',
            'list' => ['Home', 'Stok', 'Edit']
        ];
        $page = (object) [
            "title" => 'Edit Stok'
        ];
        $activeMenu = 'stok'; // set menu yang sedang aktif
        return view('stok.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'stok'=> $stok, 'supplier' => $supplier, 'barang' => $barang, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    //Menyimpan perubahan data stok
    public function update(Request $request, string $id)
    {
        $request->validate([
            'stok_tanggal'  => 'required|date',
            'stok_jumlah'   => 'required|integer',
            'supplier_id'   => 'required|integer',
            'barang_id'     => 'required|integer',
            'user_id'       => 'required|integer'
        ]);
        StokModel::find($id)->update([
            'stok_tanggal'  => $request-> stok_tanggal,
            'stok_jumlah'   => $request-> stok_jumlah,
            'supplier_id'   => $request-> supplier_id,
            'barang_id'     => $request-> barang_id,
            'user_id'       => $request-> user_id,
        ]);
        return redirect('/stok')->with("success", "Data stok berhasil diubah!");
    }

    //Menghapus data stok 
    public function destroy(string $id)
    {
        $check = StokModel::find($id);
        if (!$check) {
            return redirect('/stok')->with('error', 'Data stok tidak ditemukan!');
        }
        try {
            StokModel::destroy($id); // Hapus data supplier
            return redirect('/stok')->with('success', 'Data stok berhasil dihapus!');
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/stok')->with('error', 'Data stok gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini.');
        }
    }

    //Menampilkan form tambah data stok AJAX
    public function create_ajax()
    {
        $supplier = SupplierModel::select('supplier_id', 'supplier_nama')->get();
        $barang = BarangModel::select('barang_id', 'barang_nama')->get();
        $user = UserModel::select('user_id', 'nama')->get();

        return view('stok.create_ajax')
            ->with('supplier', $supplier)
            ->with('barang', $barang)
            ->with('user', $user);
    }
    

    //Menyimpan data baru stok AJAX
    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'supplier_id'   => 'required|integer',
                'barang_id'     => 'required|integer',
                'user_id'       => 'required|integer',
                'stok_tanggal'  => 'required|date', 
                'stok_jumlah'    => 'required|integer'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Validasi Gagal!',
                    'msgField'  => $validator->errors(),
                ]);
            }

            StokModel::create($request->all());

            return response()->json([
                'status'    => true,
                'message'   => 'Data stok berhasil disimpan!'
            ]);
        }

        return redirect('/');
    }

    //Menampilkan form edit data stok AJAX
    public function edit_ajax(string $id)
    {
        $stok = StokModel::find($id);
        $supplier = SupplierModel::select('supplier_id', 'supplier_nama')->get();
        $barang = BarangModel::select('barang_id', 'barang_nama')->get();
        $user = UserModel::select('user_id', 'nama')->get();

        return view('stok.edit_ajax', ['stok' => $stok, 'barang' => $barang, 'supplier' => $supplier, 'user' => $user]);
    }

    //Menyimpan perubahan data stok AJAX
    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'supplier_id'   => 'required|integer',
                'barang_id'     => 'required|integer',
                'user_id'       => 'required|integer',
                'stok_tanggal'  => 'required|date',
                'stok_jumlah'   => 'required|integer'
            ];
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal!',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = StokModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diperbarui!'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan!'
                ]);
            }
        }

        return redirect('/');
    }

    //Menampilkan form konfirmasi hapus data stok AJAX
    public function confirm_ajax(string $id)
    {
        $stok = StokModel::with(['supplier', 'barang', 'user'])->find($id);
        return view('stok.confirm_ajax', ['stok' => $stok]);
    }

    //Menghapus data stok AJAX
    public function delete_ajax(Request $request, string $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $stok = StokModel::find($id);
            if ($stok) {
                $stok->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus!'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan!'
                ]);
            }
        }

        return redirect('/');
    }

    //Menampilkan detil data stok AJAX
    public function show_ajax(string $id)
    {
        $stok = StokModel::find($id);

        $supplier = SupplierModel::find($stok->supplier_id);
        $barang = BarangModel::find($stok->barang_id);
        $user = UserModel::find($stok->user_id);

        return view('stok.show_ajax', ['stok' => $stok, 'supplier' => $supplier, 'barang' => $barang, 'user' => $user]);
    }

    public function import()
    {
        return view('stok.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_stok' => ['required', 'mimes:xlsx', 'max:1024'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal!',
                    'msgField' => $validator->errors(),
                ]);
            }

            $file = $request->file('file_stok');

            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();

            $data = $sheet->toArray(null, false, true, true);

            $insert = [];
            if (count($data) > 1) {
                foreach ($data as $baris => $value) {
                    if ($baris > 1) {
                        $insert[] = [
                            'supplier_id'   => $value['A'],
                            'barang_id'     => $value['B'],
                            'user_id'       => $value['C'],
                            'stok_tanggal'  => $value['F'],
                            'stok_jumlah'   => $value['G'],
                            'created_at'    => now(),
                        ];
                    }
                }
            }

            if (count($insert) > 0) {
                StokModel::insertOrIgnore($insert);
            }

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diimpor!',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada data yang diimpor!',
            ]);
        }

        return redirect('/');
    }

    public function export_excel()
    {
        $stok = StokModel::select('supplier_id', 'barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah')
            ->orderBy('stok_tanggal')
            ->with(['supplier', 'barang', 'user'])
            ->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No.');
        $sheet->setCellValue('B1', 'ID Supplier');
        $sheet->setCellValue('C1', 'ID Barang');
        $sheet->setCellValue('D1', 'ID User');
        $sheet->setCellValue('E1', 'Tanggal Stok');
        $sheet->setCellValue('F1', 'Jumlah Stok');

        $sheet->getStyle('A1:F1')->getFont()->setBold(true);

        $no = 1;
        $baris = 2;

        foreach ($stok as $key => $value) {
            $sheet->setCellValue('A'.$baris, $no);
            $sheet->setCellValue('B'.$baris, $value->supplier->supplier_nama);
            $sheet->setCellValue('C'.$baris, $value->barang->barang_nama);
            $sheet->setCellValue('D'.$baris, $value->user->nama);
            $sheet->setCellValue('E'.$baris, $value->stok_tanggal);
            $sheet->setCellValue('F'.$baris, $value->stok_jumlah);
            $baris++;
            $no++;
        }

        foreach(range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Stok');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Stok ' . date('Y-m-d H:i:s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }

    public function export_pdf()
    {
        $stok = StokModel::select('supplier_id', 'barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah')
            ->with('supplier')
            ->with('barang')
            ->with('user')
            ->get();

        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = Pdf::loadView('stok.export_pdf', ['stok' => $stok]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption('isRemoteEnabled', true); // set true jika ada gambar dari url
        $pdf->render();

        return $pdf->stream('Data Stok ' . date('Y-m-d H:i:s') . '.pdf');
    }
}