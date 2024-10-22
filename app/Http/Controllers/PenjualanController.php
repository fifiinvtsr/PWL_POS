<?php

namespace App\Http\Controllers;

use App\Models\PenjualanModel;
use App\Models\PenjualanDetailModel;
use App\Models\UserModel;
use App\Models\BarangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
class PenjualanController extends Controller
{
    public function index() {
        $breadcrumb = (object) [
           'title' => 'Data Transaksi Penjualan',
           'list' => ['Home','Penjualan']
        ];

        $page = (object) [
           'title' => 'Detail transaksi penjualan.'
        ];

        $activeMenu = 'penjualan'; //set menu yang sedang aktif

        $user = UserModel::all(); //ambil data user untuk filter

        return view('penjualan.index', ['breadcrumb' => $breadcrumb, 'page' => $page,'user' => $user, 'activeMenu' => $activeMenu]);
   }
   public function list(Request $request)
{
    $penjualans = PenjualanModel::select('penjualan_id', 'user_id', 'pembeli', 'penjualan_kode', 'penjualan_tanggal')
        ->with(['user', 'penjualan_detail']);

    if ($request->user_id) {
        $penjualans->where('user_id', $request->user_id);
    }

    return DataTables::of($penjualans)
        ->addIndexColumn()
        
        ->addColumn('jumlah_barang', function ($penjualan) { //fungsi utk menghitung jumlah jenis
            return $penjualan->penjualan_detail->count();
        })

        ->addColumn('total_harga', function ($penjualan) { //fungsi utk menghitung total harga
            $total = 0;
            foreach ($penjualan->penjualan_detail as $detail) {
                $total += $detail->harga * $detail->jumlah;
            }
            return number_format($total, 0, ',', '.');
        })
        ->addColumn('aksi', function ($penjualan) {
            $btn = '<button onclick="modalAction(\''.url('/penjualan/' . $penjualan->penjualan_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
            $btn .= '<button onclick="modalAction(\''.url('/penjualan/' . $penjualan->penjualan_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
            $btn .= '<button onclick="modalAction(\''.url('/penjualan/' . $penjualan->penjualan_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';
            return $btn;
        })
        ->rawColumns(['aksi'])
        ->make(true);
    } 
    
    public function create_ajax() {
        $barang = BarangModel::select('barang_id', 'barang_nama','harga_jual') -> get();
        $user = UserModel::select('user_id', 'nama') -> get();
    

        return view('penjualan.create_ajax') -> with([ 'barang' => $barang, 'user' =>$user]);
    }

    public function store_ajax(Request $request) {

    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'user_id'        => 'required|integer',
            'penjualan_tanggal'   => 'required|date',
            'pembeli'    => 'required|string',
            'items'          => 'required|array', 
            'items.*.barang_id' => 'required|integer', 
            'items.*.jumlah'    => 'required|integer|min:1', 
            'items.*.harga'     => 'required|numeric|min:0',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors()
            ]);
        }

        $penjualan = PenjualanModel::create($request->only(['user_id','pembeli','penjualan_kode', 'penjualan_tanggal', 'penjualan_jumlah']));

        foreach ($request->items as $item) {
            PenjualanDetailModel::create([
                'penjualan_id'    => $penjualan->penjualan_id,
                'barang_id'  => $item['barang_id'],
                'jumlah'     => $item['jumlah'],
                'harga'      => $item['harga'],
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil disimpan!'
        ]);
    }
}
        public function confirm_ajax(string $id) {
        $penjualan = PenjualanModel::find($id);

        return view('penjualan.confirm_ajax', ['penjualan' => $penjualan]);
    } 

    public function delete_ajax(Request $request, $id) {
        if ($request -> ajax() || $request -> wantsJson()) {
            $penjualan = PenjualanModel::find($id);

            if ($penjualan) {
                PenjualanDetailModel::where('penjualan_id', $id)->delete();

                $penjualan->delete();
                return response() -> json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus!'
                ]);
            } else {
                return response() -> json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan!'
                ]);
            }
        }
        return redirect('/');
    }

    public function show_ajax(string $id) {
        $penjualan = PenjualanModel::find($id);

        return view('penjualan.show_ajax', ['penjualan' => $penjualan]);
    } 

    public function edit_ajax(string $id) {
        $penjualan = PenjualanModel::find($id);
        $penjualan_detail = PenjualanDetailModel::select('penjualan_id') -> get();
        $barang = BarangModel::select('barang_id', 'barang_nama') -> get();
        $user = UserModel::select('user_id', 'nama') -> get();


        return view('penjualan.edit_ajax') -> with(['penjualan' => $penjualan,'penjualan_detail' => $penjualan_detail, 'barang' => $barang, 'user' =>$user]);
    }
    public function update_ajax(Request $request, $id)
{
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'user_id' => 'required|integer',
            'pembeli' => 'required|string|max:255',
            'penjualan_kode' => 'required|string|max:255',
            'penjualan_tanggal' => 'required|date',
            'items' => 'required|array',
            'items.*.barang_id' => 'required|integer',
            'items.*.jumlah' => 'required|integer',
            'items.*.harga' => 'required|numeric'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }

        $penjualan = PenjualanModel::find($id);
        
        if ($penjualan) {
            $penjualan->update([
                'user_id' => $request->user_id,
                'pembeli' => $request->pembeli,
                'penjualan_kode' => $request->penjualan_kode,
                'penjualan_tanggal' => $request->penjualan_tanggal,
            ]);

            $penjualan->penjualan_detail()->delete();

            foreach ($request->items as $item) {
                $penjualan->penjualan_detail()->create([
                    'barang_id' => $item['barang_id'],
                    'jumlah' => $item['jumlah'],
                    'harga' => $item['harga'],
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diupdate'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    return redirect('/');
    }
    public function export_pdf() {
        $penjualan = PenjualanModel::select('penjualan_id', 'user_id', 'penjualan_kode', 'pembeli', 'penjualan_tanggal') 
                -> orderBy('penjualan_tanggal')
                -> with(['penjualan_detail.barang','user' ])
                -> get();
        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = Pdf::loadView('penjualan.export_pdf', ['penjualan' => $penjualan]);
        $pdf->setPaper('a4', 'landscape'); // set ukuran kertas dan orientasi $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url $pdf->render();
        return $pdf->stream ('Data Penjualan '.date('Y-m-d H:i:s').'.pdf');
    }   
    public function export_excel() {
        $penjualan = PenjualanModel::select('penjualan_id', 'user_id', 'penjualan_kode', 'pembeli', 'penjualan_tanggal')
            ->orderBy('penjualan_tanggal')
            ->with(['user', 'penjualan_detail.barang'])
            ->get();
    
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Penjualan');
        $sheet->setCellValue('C1', 'Pembeli');
        $sheet->setCellValue('D1', 'User');
        $sheet->setCellValue('E1', 'Tanggal Penjualan');
        $sheet->setCellValue('F1', 'Nama Barang');
        $sheet->setCellValue('G1', 'Jumlah Barang');
        $sheet->setCellValue('H1', 'Harga Barang');
    
        $no = 1;
        $baris = 2;
    
        foreach ($penjualan as $key => $p) {
            foreach ($p->penjualan_detail as $detail) {
                $sheet->setCellValue('A' . $baris, $no);
                $sheet->setCellValue('B' . $baris, $p->penjualan_kode);
                $sheet->setCellValue('C' . $baris, $p->pembeli);
                $sheet->setCellValue('D' . $baris, $p->user->nama);
                $sheet->setCellValue('E' . $baris, $p->penjualan_tanggal);
                $sheet->setCellValue('F' . $baris, $detail->barang->barang_nama);
                $sheet->setCellValue('G' . $baris, $detail->jumlah);
                $sheet->setCellValue('H' . $baris, $detail->harga);
                $baris++;
            }
            $no++;
        }
    
        foreach (range('A', 'H') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
    
        $sheet->setTitle('Data Penjualan');
    
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Penjualan ' . date('Y-m-d H:i:s') . '.xlsx';
    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 22 Aug 2025 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
    
        $writer->save('php://output');
        exit;
    }

    public function import() {
        return view('penjualan.import');
    }

    public function import_ajax(Request $request) {
        if ($request->ajax() || $request->wantsJson()) {
            
            $rules = [
                'file_penjualan' => ['required', 'mimes:xlsx', 'max:1024'], // File must be XLSX, max 1MB
            ];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }
    
            $file = $request->file('file_penjualan');
    
            try {
                $reader = IOFactory::createReader('Xlsx');
                $reader->setReadDataOnly(true);
                $spreadsheet = $reader->load($file->getRealPath());
                $sheet = $spreadsheet->getActiveSheet();
    
                $data = $sheet->toArray(null, false, true, true);
    
                $insert = [];
    
                if (count($data) > 1) { 
                    foreach ($data as $baris => $value) {
                        if ($baris > 1) { 

                            $excelDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value['D']);
                        $penjualan_tanggal = $excelDate ? $excelDate->format('Y-m-d H:i:s') : null;

                            $insert[] = [
                                'user_id' => $value['A'], 
                                'penjualan_kode' => $value['B'], 
                                'pembeli' => $value['C'], 
                                'penjualan_tanggal' => $penjualan_tanggal, 
                                'created_at' => now(),
                            ];

                            $insertDetail[] = [
                                'barang_id' => $value['E'],
                                'jumlah' => $value['F'],
                                'harga' => $value['G'],
                                'created_at' => now(),

                            ];
                        }
                    }
    
                    if (count($insert) > 0) {
                        PenjualanModel::insert($insert); 
                    }

                    if (count($insertDetail) > 0) {
                        $penjualanIds = PenjualanModel::orderBy('penjualan_id', 'desc')->take(count($insert))->pluck('penjualan_id')->toArray();
                        
                        foreach ($insertDetail as $index => &$detail) {
                            $detail['penjualan_id'] = $penjualanIds[$index]; 
                        }
                        
                        PenjualanDetailModel::insertOrIgnore($insertDetail); 
                    }
    
                    return response()->json([
                        'status' => true,
                        'message' => 'Data berhasil diimport'
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Tidak ada data yang diimport'
                    ]);
                }
    
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan saat memproses file: ' . $e->getMessage()
                ]);
            }
        }
    
        return redirect('/');
    }
}