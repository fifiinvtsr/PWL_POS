<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenjualanModel;
use App\Models\UserModel;
use App\Models\PenjualanDetailModel;
use App\Models\BarangModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;

class PenjualanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Penjualan',
            'list' => ['Home', 'Penjualan']
        ];

        $page = (object) [
            'title' => 'Daftar penjualan yang terdaftar dalam sistem'
        ];

        $activeMenu = 'penjualan';

        $user = UserModel::all();

        return view('penjualan.index', [
            'activeMenu' => $activeMenu,
            'breadcrumb' => $breadcrumb,
            'user' => $user]);
    }
    
    //Ambil data penjualan dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $penjualan = PenjualanModel::select('penjualan_id', 'penjualan_kode', 'user_id', 'pembeli', 'penjualan_tanggal')
            ->with('user');
        // filter data penjualan
        if ($request->user_id) {
            $penjualan->where('user_id', $request->user_id);
        }
        
        return DataTables::of($penjualan)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($penjualan) { // menambahkan kolom aksi
                $btn = '<button onclick="modalAction(\''.url('/penjualan/' . $penjualan->penjualan_id .'/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/penjualan/' . $penjualan->penjualan_id .'/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/penjualan/' . $penjualan->penjualan_id .'/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    //Menampilkan laman form tambah penjualan baru AJAX
    public function create_ajax()
    {
        $user = UserModel::select('user_id', 'nama')->get();

        return view('penjualan.create_ajax')
                    ->with('user', $user);
    }

    //Menyimpan data penjualan baru AJAX
    public function store_ajax(Request $request){
        //periksa bila request berupa AJAX atau tidak
        if($request->ajax() || $request->wantsJson()){
            $rules = [
                'penjualan_kode' => ['required', 'min:3', 'max:20', 'unique:t_penjualan,penjualan_kode'],
                'user_id' => ['required', 'integer', 'exists:m_user,user_id'],
                'pembeli' => ['required', 'string', 'max:100'],
                'penjualan_tanggal' => ['required', 'date'],
            ];

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()){
                return response()->json([
                    'status'    =>false,    //response status, false: eror/gagal, true:berhasil
                    'message'   => 'Validasi Gagal',
                    'msgField'  => $validator->errors(),    //pesan eror validasi
                ]);
            }

            PenjualanModel::create($request->all());
            return response()->json([
                'status'    => true,
                'message'   => 'Data penjualan berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    //Menampilkan form detil data penjualan AJAX
    public function show_ajax($id)
    {
        //$penjualan = PenjualanModel::find($id);

        // Ambil data penjualan beserta detailnya
        $penjualan = PenjualanModel::with('detail')->find($id);
        
        return view('penjualan.show_ajax', ['penjualan' => $penjualan]);
    }


    //Menampilkan laman form edit penjualan AJAX
    public function edit_ajax(string $id)
    {
        $penjualan = PenjualanModel::find($id);
        $user = UserModel::select('user_id', 'nama')->get();

        return view('penjualan.edit_ajax', ['penjualan' => $penjualan, 'user' => $user]);
    }

    //Menyimpan perubahan data penjualan AJAX
    public function update_ajax(Request $request, $id){
        //periksa bila request dari ajax atau bukan
        if($request->ajax() || $request->wantsJson()) {
            $rules = [
                'penjualan_kode' => ['required', 'min:3', 'max:20', 'unique:t_penjualan,penjualan_kode,'.$id.',penjualan_id'],
                'user_id' => ['required', 'integer', 'exists:m_user,user_id'],
                'pembeli' => ['required', 'string', 'max:100'],
                'penjualan_tanggal' => ['required', 'date'],
            ];

            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal!',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }

            $check = PenjualanModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data penjualan berhasil diperbarui!'
                ]);
            } else{
                return response()->json([
                    'status' => false,
                    'message' => 'Data penjualan tidak ditemukan!'
                ]);
            }
        }
        return redirect('/');
    }

    //Menampilkan laman form konfirmasi hapus data penjualan AJAX
    public function confirm_ajax(string $id){
        $penjualan = PenjualanModel::find($id);

        return view('penjualan.confirm_ajax', ['penjualan' => $penjualan]);
    }

    //Menghapus data penjualan AJAX
    public function delete_ajax(Request $request, $id)
    {
        //periksa bila request dari AJAX atau bukan
        if ($request->ajax() || $request->wantsJson()){
            $penjualan = PenjualanModel::find($id);
            if ($penjualan) { //jika data sudah ditemukan
                $penjualan->delete(); //data penjualan dihapus
                return response()->json([
                    'status'    => true,
                    'message'   => 'Data penjualan berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Data penjualan tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function import()
    {
        return view('penjualan.import');
    }

    public function import_ajax(Request $request)
    {
        if($request->ajax() || $request->wantsJson()){
            $rules = [
                // validasi file harus xls atau xlsx, max 1MB
                'file_penjualan' => ['required', 'mimes:xlsx', 'max:1024']
            ];
            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }
            $file = $request->file('file_penjualan'); // ambil file dari request
            $reader = IOFactory::createReader('Xlsx'); // load reader file excel
            $reader->setReadDataOnly(true); // hanya membaca data
            $spreadsheet = $reader->load($file->getRealPath()); // load file excel
            $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
            $data = $sheet->toArray(null, false, true, true); // ambil data excel
            $insert = [];
            if(count($data) > 1){ // jika data lebih dari 1 baris
                foreach ($data as $baris => $value) {
                    if($baris > 1){ // baris ke 1 adalah header, maka lewati
                        $insert[] = [
                            'penjualan_kode' => $value['A'],
                            'user_id' => $value['B'],
                            'pembeli' => $value['C'],
                            'penjualan_tanggal' => $value['F'],
                        ];
                    }
                }
                if(count($insert) > 0){
                    // insert data ke database, jika data sudah ada, maka diabaikan
                    PenjualanModel::insertOrIgnore($insert);
                }
                return response()->json([
                    'status' => true,
                    'message' => 'Data penjualan berhasil diimpor!'
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data penjualan yang diimpor.'
                ]);
            }
        }
        return redirect('/');
    }

    public function export_excel()
    {
        //ambil data penjualan yang akan diekspor
        $penjualan = PenjualanModel::select('penjualan_kode', 'user_id', 'pembeli', 'penjualan_tanggal')
                    ->orderBy('user_id')
                    ->with('user')
                    ->get();
        //load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); //ambil sheet yang aktif

        $sheet->setCellValue('A1', 'No.');
        $sheet->setCellValue('B1', 'Kode Penjualan');
        $sheet->setCellValue('C1', 'Nama Pembeli');
        $sheet->setCellValue('D1', 'Tanggal Penjualan');
        $sheet->setCellValue('E1', 'Pengguna');
        
        $sheet->getStyle('A1:E1')->getFont()->setBold(true); //bold header

        $no = 1; //nomor data dimulai dari 1
        $baris = 2; //baris data dimulai dari baris ke-2
        foreach($penjualan as $key => $value){
            $sheet->setCellValue('A'.$baris,$no);
            $sheet->setCellValue('B'.$baris,$value->penjualan_kode);
            $sheet->setCellValue('C'.$baris,$value->pembeli);
            $sheet->setCellValue('D'.$baris,$value->penjualan_tanggal);
            $sheet->setCellValue('E'.$baris,$value->user->nama); //ambil nama user
            $baris++;
            $no++;
        }
        foreach(range('A', 'E') as $columnID){
            $sheet->getColumnDimension($columnID)->setAutoSize(true); //set auto size untuk kolom
        }
        $sheet->setTitle('Data Penjualan'); //set title sheet

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Penjualan ' . date('Y-m-d H:i:s') . '.xlsx';
        //dd($filename);

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
    } //end function export_excel

    public function export_pdf()
    {
        $penjualan = PenjualanModel::select('penjualan_kode', 'user_id', 'pembeli', 'penjualan_tanggal')
                    ->orderBy('user_id')
                    ->orderBy('penjualan_kode')
                    ->with('user')
                    ->get();
                    
        //use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = Pdf::loadView('penjualan.export_pdf', ['penjualan' => $penjualan]);
        $pdf->setPaper('a4', 'portrait'); //set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); //set true jika ada gambar dari url
        $pdf->render();

        return $pdf->stream('Data Penjualan '.date('Y-m-d H:i:s').'.pdf');
    }
}