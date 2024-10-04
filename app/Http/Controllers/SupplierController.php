<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\SupplierModel;

class SupplierController extends Controller
{
    public function index() {

        $breadcrumb = (object) [
            'title' => 'Daftar Supplier',
            'list' => ['Home','Supplier']
         ];

         $page = (object) [
            'title' => 'Daftar supplier barang.'
         ];

         $activeMenu = 'supplier'; //set menu yang sedang aktif

         return view('supplier.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request){
        $suppliers = SupplierModel::select('supplier_id', 'supplier_kode', 'supplier_nama', 'supplier_alamat');

        
        return DataTables::of($suppliers)
        ->addIndexColumn()  
        ->addColumn('aksi', function ($supplier) { 
//            $btn  = '<a href="'.url('/supplier/' . $supplier->supplier_id).'" class="btn btn-info btn-sm">Detail</a> '; 
  //          $btn .= '<a href="'.url('/supplier/' . $supplier->supplier_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> '; 
    //        $btn .= '<form class="d-inline-block" method="POST" action="'. url('/supplier/'.$supplier->supplier_id).'">' 
      //              . csrf_field() . method_field('DELETE') .  
        //            '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';      
        $btn = '<button onclick="modalAction(\''.url('/supplier/' . $supplier->supplier_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
$btn .= '<button onclick="modalAction(\''.url('/supplier/' . $supplier->supplier_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
$btn .= '<button onclick="modalAction(\''.url('/supplier/' . $supplier->supplier_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';
  
        return $btn; 
        }) 
        ->rawColumns(['aksi'])
        ->make(true);
    }

    public function create() {
        $breadcrumb = (object) [
            'title' => 'Tambah Supplier',
            'list' => ['Home','Supplier','Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah supplier baru'
        ];

        $activeMenu = 'supplier';

        return view('supplier.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request) {
        $request -> validate ([
            'supplier_kode'  => 'required|string|unique:m_supplier,supplier_kode',
            'supplier_nama'  => 'required|string|max:100',
            'supplier_alamat'  => 'required|string|max:100'

        ]);

        SupplierModel::create([
            'supplier_kode'  => $request->supplier_kode,
            'supplier_nama'  => $request->supplier_nama,
            'supplier_alamat'  => $request->supplier_alamat
        ]);

        return redirect('/supplier')->with('success', 'Data supplier berhasil disimpan.');
    }

    public function show(string $id) {
        $supplier = SupplierModel::find($id);
        $breadcrumb = (object) [
            'title' => 'Detail Supplier',
            'list'  => ['Home','Supplier','Detail']
        ];

        $page = (object) [
            'title' => 'Detail Supplier',
        ];

        $activeMenu = 'supplier';

        return view('supplier.show', ['breadcrumb' => $breadcrumb, 'page' => $page,'supplier' => $supplier, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id) {
        $supplier = SupplierModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Supplier',
            'list' => ['Home','Supplier','Edit'],
        ];

        $page = (object) [
            'title' => 'Edit Supplier'
        ];

        $activeMenu = 'supplier';

        return view('supplier.edit', ['breadcrumb' => $breadcrumb, 'supplier' => $supplier, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, string $id) {
        $request -> validate( [ 
            'supplier_kode'  => 'required|string|unique:m_supplier,supplier_kode',
            'supplier_nama'  => 'required|string|max:100',
            'supplier_alamat' => 'required|string|max:100'
        ]);

        SupplierModel::find($id)->update([
            'supplier_kode'  => $request->supplier_kode,
            'supplier_nama'  => $request->supplier_nama,
            'supplier_alamat'  => $request->supplier_alamat
        ]);

        return redirect('/supplier')->with('success','Data supplier berhasil diubah');

    }

    public function destroy(string $id) {
        $check = SupplierModel::find($id);
        if(!$check) {
            return redirect('/supplier') -> with('error', 'Data supplier tidak ditemukan');
        }

        try {
            SupplierModel::destroy($id);

            return redirect('/supplier')->with('success', 'Data supplier berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/supplier') -> with('error','Data supplier gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function create_ajax() {

        return view('supplier.create_ajax');
    }

    public function store_ajax(Request $request) {

        if ($request -> ajax() || $request -> wantsJson()) {
            $rules = [
                'supplier_kode'  => 'required|string|unique:m_supplier,supplier_kode',
                'supplier_nama'  => 'required|string|max:100',
                'supplier_alamat' => 'required|string|max:100'

            ];

            $validator = Validator::make($request -> all(),$rules);

            if ($validator -> fails()) {
                return response() -> json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            SupplierModel:: create($request->all());
            return response() -> json([
                'status' => true,
                'message' => 'Data berhasil disimpan!'
            ]);
        }
        redirect('/');
    }

    public function edit_ajax(string $id) {
        $supplier = SupplierModel::find($id);

        return view('supplier.edit_ajax', ['supplier' => $supplier]);
    }

    public function update_ajax(Request $request, $id)
    {
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'supplier_kode'  => 'required|string|unique:m_supplier,supplier_kode',
                'supplier_nama'  => 'required|string|max:100',
                'supplier_alamat' => 'required|string|max:100'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }

        $check = SupplierModel::find($id);
        
        if ($check) {
            if (!$request->filled('password')) { 
                $request->request->remove('password');
            }

            $check->update($request->all());

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
    public function confirm_ajax(string $id) {
        $supplier = SupplierModel::find($id);

        return view('supplier.confirm_ajax', ['supplier' => $supplier]);
    } 

    public function delete_ajax(Request $request, $id) {
        if ($request -> ajax() || $request -> wantsJson()) {
            $supplier = SupplierModel::find($id);

            if ($supplier) {
                $supplier->delete();
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
}