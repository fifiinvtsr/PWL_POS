<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\Facades\DataTables;


class BarangController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Barang',
            'list'  => ['Home', 'Barang']
        ];

        $page = (object) [
            'title' => 'Daftar barang yang terdaftar dalam sistem'
        ];

        $activeMenu = 'barang';

        $kategori = KategoriModel::all();

        return view('barang.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request) 
    { 
        $barang = BarangModel::select('barang_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual', 'kategori_id') 
                    ->with('kategori'); 

        if ($request->kategori_id){
            $barang->where('kategori_id', $request->kategori_id);
        }

        return DataTables::of($barang) 
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addIndexColumn()  
            ->addColumn('aksi', function ($barang) {  // menambahkan kolom aksi 
                /*$btn = '<a href="'.url('/barang/' . $barang->barang_id).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/barang/' . $barang->barang_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'.url('/barang/'.$barang->barang_id).'">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';*/
                $btn = '<button onclick="modalAction(\''.url('/barang/' . $barang->barang_id .'/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/barang/' . $barang->barang_id .'/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/barang/' . $barang->barang_id .'/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn; 
            }) 
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true); 
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Barang',
            'list'  => ['Home', 'barang', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Barang Baru'
        ];

        $kategori = KategoriModel::all();
        $activeMenu = 'barang';

        return view('barang.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_kode' => 'required|string|min:3', 
            'barang_nama' => 'required|string|max:100',                    
            'harga_beli'  => 'required|integer',      
            'harga_jual'  => 'required|integer',                         
            'kategori_id' => 'required|integer',                       
        ]);

        BarangModel::create([
            'barang_kode'  => $request->barang_kode,
            'barang_nama'  => $request->barang_nama,
            'harga_beli'   => $request->harga_beli,
            'harga_jual'   => $request->harga_jual,
            'kategori_id'  => $request->kategori_id,
        ]);

        return redirect('/barang')->with('success', 'Data barang berhasil disimpan');
    }

    //Menampilkan laman form tambah barang baru AJAX
    public function create_ajax()
    {
        $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();

        return view('barang.create_ajax')
                    ->with('kategori', $kategori);
    }

    //Menyimpan data barang baru AJAX
    public function store_ajax(Request $request){
        //periksa bila request berupa AJAX atau tidak
        if($request->ajax() || $request->wantsJson()){
            $rules = [
                'kategori_id'   => 'required|integer',
                'barang_kode'   => 'required|string|min:3|unique:m_barangs,barang_kode',
                'barang_nama'   => 'required|string|max:100',
                'harga_beli'    => 'required|integer',
                'harga_jual'    => 'required|integer'
            ];

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()){
                return response()->json([
                    'status'    =>false,    //response status, false: eror/gagal, true:berhasil
                    'message'   => 'Validasi Gagal',
                    'msgField'  => $validator->errors(),    //pesan eror validasi
                ]);
            }

            BarangModel::create($request->all());
            return response()->json([
                'status'    => true,
                'message'   => 'Data barang berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    public function show(string $id)
    {
        $barang = BarangModel::with('kategori')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Barang',
            'list'  => ['Home', 'barang', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Barang'
        ];

        $activeMenu = 'barang';

        return view('barang.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id)
    {
        $barang = BarangModel::find($id);
        $kategori = KategoriModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit barang',
            'list' => ['Home', 'barang', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Barang'
        ];

        $activeMenu = 'barang';

        return view('barang.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'barang_kode' => 'required|string|min:3', 
            'barang_nama' => 'required|string|max:100',                    
            'harga_beli'  => 'required|integer',      
            'harga_jual'  => 'required|integer',                         
            'kategori_id' => 'required|integer',  
        ]);

        BarangModel::find($id)->update([
            'barang_kode'  => $request->barang_kode,
            'barang_nama'  => $request->barang_nama,
            'harga_beli'   => $request->harga_beli,
            'harga_jual'   => $request->harga_jual,
            'kategori_id'  => $request->kategori_id,
        ]);

        return redirect('/barang')->with('success', 'Data barang berhasil diubah');
    }

    //Menampilkan laman form edit barang AJAX
    public function edit_ajax(string $id)
    {
        $barang = BarangModel::find($id);
        $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();

        return view('barang.edit_ajax', ['barang' => $barang, 'kategori' => $kategori]);
    }

    //Menyimpan perubahan data barang AJAX
    public function update_ajax(Request $request, $id){
        //periksa bila request dari ajax atau bukan
        if($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_id'   => 'required|integer',
                'barang_kode'   => 'required|string|min:3|unique:m_barangs,barang_kode',
                'barang_nama'   => 'required|string|max:100',
                'harga_beli'    => 'required|integer',
                'harga_jual'    => 'required|integer'
            ];

            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }

            $check = BarangModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else{
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    //Menampilkan laman form konfirmasi hapus data barang AJAX
    public function confirm_ajax(string $id){
        $barang = BarangModel::find($id);

        return view('barang.confirm_ajax', ['barang' => $barang]);
    }

    //Menghapus data barang AJAX
    public function delete_ajax(Request $request, $id)
    {
        //periksa bila request dari AJAX atau bukan
        if ($request->ajax() || $request->wantsJson()){
            $barang = BarangModel::find($id);
            if ($barang) {
                $barang->delete();
                return response()->json([
                    'status'    => true,
                    'message'   => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function destroy (string  $id)
    {
        $check = BarangModel::find($id);
        if (!$check) {
            return redirect('/barang')->with('error', 'Data barang tidak ditemukan');
        }
        try{
            BarangModel::destroy($id);
            return redirect('/barang')->with('success', 'Data barang berhasil dihapus');
        } catch (\Illuminate\Database\QueryException){
            return redirect('/barang')->with('error', 'Data barang gagal dihapus karena terdapat tabel lain yang terkait dengan data ini');
        }
    }

    // JS 8
    public function import()
    {
        return view('barang.import');
    }

    public function import_ajax(Request $request)
    {
        if($request->ajax() || $request->wantsJson()){
            // Validasi file harus berformat xlsx dan maksimal ukuran 1MB
            $rules = [
                'file_barang' => ['required', 'mimes:xlsx', 'max:1024']
            ];
            $validator = Validator::make($request->all(), $rules);
            
            if($validator->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            try {
                // Ambil file dari request
                $file = $request->file('file_barang'); 
                $reader = IOFactory::createReader('Xlsx'); // Load reader file Excel
                $reader->setReadDataOnly(true); // Hanya membaca data
                $spreadsheet = $reader->load($file->getRealPath()); // Load file excel
                $sheet = $spreadsheet->getActiveSheet(); // Ambil sheet yang aktif
                $data = $sheet->toArray(null, false, true, true); // Ambil data Excel

                // Siapkan array untuk menampung data yang akan diinsert
                $insert = [];
                
                if(count($data) > 1){ // Jika data lebih dari 1 baris
                    foreach ($data as $baris => $value) {
                        if($baris > 1){ // Baris ke-1 adalah header, maka lewati
                            // Pastikan semua kolom tidak kosong sebelum insert
                            if ($value['A'] && $value['B'] && $value['C'] && $value['D'] && $value['E']) {
                                $insert[] = [
                                    'kategori_id' => $value['A'],
                                    'barang_kode' => $value['B'],
                                    'barang_nama' => $value['C'],
                                    'harga_beli' => $value['D'],
                                    'harga_jual' => $value['E'],
                                    'created_at' => now(),
                                ];
                            }
                        }
                    }

                    if(count($insert) > 0){
                        // Insert data ke database, jika data sudah ada, maka diabaikan
                        BarangModel::insertOrIgnore($insert);

                        return response()->json([
                            'status' => true,
                            'message' => 'Data barang berhasil diimpor'
                        ]);
                    } else {
                        return response()->json([
                            'status' => false,
                            'message' => 'Tidak ada data barang yang valid untuk diimpor'
                        ]);
                    }
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'File kosong atau tidak ada data yang diimpor'
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage()
                ]);
            }
        }
        return redirect('/');
    }

    public function export_excel()
    {
        // ambil data barang yang akan di export
        $barang = BarangModel::select('kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual')
            ->orderBy('kategori_id')
            ->with('kategori')
            ->get();

        // load library excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Barang');
        $sheet->setCellValue('C1', 'Nama Barang');
        $sheet->setCellValue('D1', 'Harga Beli');
        $sheet->setCellValue('E1', 'Harga Jual');
        $sheet->setCellValue('F1', 'Kategori');

        $sheet->getStyle('A1:F1')->getFont()->setBold(true);

        $no = 1;        // nomor data dimulai dari 1
        $baris = 2;     // baris data dimulai dari baris ke 2
        foreach ($barang as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->barang_kode);
            $sheet->setCellValue('C' . $baris, $value->barang_nama);
            $sheet->setCellValue('D' . $baris, $value->harga_beli);
            $sheet->setCellValue('E' . $baris, $value->harga_jual);
            $sheet->setCellValue('F' . $baris, $value->kategori->kategori_nama);
            $baris++;
            $no++;
        }

        foreach (range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);  // set auto size untuk kolom
        }

        $sheet->setTitle('Data Barang'); // set title sheet

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Barang ' . date('Y-m-d H:i:s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, dMY H:i:s') . 'GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    } // end function export_excel
    public function export_pdf()
    {
        $barang = BarangModel::select('kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual')
                    ->orderBy('kategori_id')
                    ->orderBy('barang_kode')
                    ->with('kategori')
                    ->get();

        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = Pdf::loadView('barang.export_pdf', ['barang' => $barang]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url
        $pdf->render();

        return $pdf->stream('Data Barang'.date('Y-m-d H:i:s').'.pdf');
    }
}