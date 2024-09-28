<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Facades\DataTable;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    // public function index()
    // {
    //     // $user = UserModel::all();
    //     // return view('user', ['data' => $user]);
    //     // Tambah data user dengan Eloquent Model
    //     // $data = [
    //     //     'username' => 'Customer-1',
    //     //     'nama' => 'Pelanggan',
    //     //     'password' => Hash::make('12345'),
    //     //     'level_id' => 3
    //     // ];
    //     // UserModel::insert($data);

    //     // Coba akses model UserModel
    //     // $user = UserModel::all();
    //     // return view('user', ['data' => $user]);

    //     // $data = [
    //     //     'nama' => 'Pelanggan Pertama',
    //     // ];
    //     // UserModel::where('username', 'Customer-1')->update($data);

    //     //Jobsheet 4 Praktikum 1
    //     // $data = [
    //     //     'level_id' => 2,
    //     //     'username' => 'manager_tiga',
    //     //     'nama' => 'Manager 3',
    //     //     'password' => Hash::make('12345')
    //     // ];
    //     // UserModel::create($data);
        
    //     // $user = UserModel::all();
    //     // return view('user', ['data' => $user]);

    //     //jobsheet 4-Prartikum 2.1
    //     //$user = UserModel::find(1);
    //     // $user = UserModel::where('level_id', 1)->first();
    //     // $user = UserModel::firstWhere('level_id', 1);
    //     //     $user = UserModel::findOr(20, ['username', 'nama'], function(){
    //     //         abort(404);
    //     //     });
    //     // return view('user',['data' => $user]);

    //     //Jobsheet 4 - Praktikum 2.2
    //     // $user = UserModel::findOrFail(1);
    //     // $user = UserModel::where('username', 'manager9')->firstOrFail();
    //     // return view('user',['data' => $user]);

    //     //Jobsheet 4 - Praktikum 2.3 
    //     // $user = UserModel::where('level_id', 2)->count();
    //     // dd($user);
    //     // $user = UserModel::where('level_id', 2)->count(); 
    //     // return view('user',['data' => $user]);

    //     //Jobsheet 4 - Praktikum 2.4 
    //     // $user = UserModel::firstOrNew(
    //     //     [
    //     //         'username' => 'manager33',
    //     //         'nama' => 'Manager Tiga Tiga',
    //     //         'password' => Hash::make('12345'),
    //     //         'level_id' => 2
    //     //     ],
    //     // );
    //     // $user -> save();

    //     // return view('user',['data' => $user]);

    // }

    //Jobsheet 4 - Praktikum 2.5
    // public function index() {
    //         $user = UserModel::create([
    //             'username' => 'manager55',
    //             'nama' => 'Manager55',
    //             'password' => Hash::make(12345),
    //             'level_id' => 2,
    //     ]);
        
    //     $user->username = 'manager56';
        
    //     $user->isDirty(); // true
    //     $user->isDirty('username'); // true
    //     $user->isDirty('nama'); // false
    //     $user->isDirty(['nama', 'username']); // true
        
    //     $user->isClean(); // false
    //     $user->isClean('username'); // false
    //     $user->isClean('nama'); // true
    //     $user->isClean(['nama', 'username']); // false
        
    //     $user->save();
        
    //     $user->isDirty(); // false
    //     $user->isClean(); // true
    //     dd($user->isDirty());
    // }

        //Modifikasi 
        // $user = UserModel::create([
        //     'username' => 'manager11',
        //     'nama' => 'Manager11',
        //     'password' => Hash::make(12345),
        //     'level_id' => 2,
        // ]);
        
        // $user->username = 'manager12';
        
        // $user->save();
        
        // $user->wasChanged(); // true
        // $user->wasChanged('username'); // true
        // $user->wasChanged(['username', 'level_id']); // true
        // $user->wasChanged('nama'); // false
        // dd($user->wasChanged(['nama', 'username'])); //true


    //Praktikum 2.6
    // public function index() {
            
    //     $user = UserModel::all();
    //         return view('user', ['data' => $user]);
    //     }

    //     public function tambah() {
    //         return view('user_tambah');
    //     }

    //     public function tambah_simpan(Request $request){
    //         UserModel::create([
    //             'username' => $request->username,
    //             'nama' => $request->nama,
    //             'password' => Hash::make($request->password),
    //             'level_id' => $request->level_id
    //         ]);
        
    //         return redirect('/user');
    //     }

    //     public function ubah($id){
    //         $user = UserModel::where('user_id', $id)->first(); // Gunakan user_id
    //         return view('user_ubah', ['data' => $user]);
    //     }

    //     public function ubah_simpan($id, Request $request){
    //         // Cari user berdasarkan user_id
    //         $user = UserModel::find($id); // Laravel sekarang menggunakan user_id sebagai primary key
        
    //         // Update field yang diubah
    //         $user->username = $request->username;
    //         $user->nama = $request->nama;
        
    //         // Hashing password baru hanya jika diubah
    //         if (!empty($request->password)) {
    //             $user->password = Hash::make($request->password);
    //         }
        
    //         $user->level_id = $request->level_id;
        
    //         // Simpan perubahan
    //         $user->save();
        
    //         return redirect('/user');
    //     }

    //     public function hapus($id){
    //         $user = UserModel::find($id);
    //         $user->delete();

    //         return redirect('/user');
    //     }

        //Pratikum 2.7
        // public function index(){
        //     $user = UserModel::with('level')->get();
        //     dd($user);
        // }

        // public function index(){
            
        //     $user = UserModel::with('level')->get();
        //     return view('user', ['data' => $user]);
        // }

        // JS 5 PRAKTIKUM 3
        // menampilkan halaman user
        public function index()
        {
            $breadcrumb = (object) [
                'title' => 'Daftar User',
                'list' => ['Home', 'User']
            ];

            $page = (object) [
                'title' => 'Daftar user yang terdaftar dalam sistem'
            ];

            $activeMenu = 'user'; // Set menu yang sedang aktif

            return view('user.index', [
                'breadcrumb' => $breadcrumb, 
                'page' => $page, 
                'activeMenu' => $activeMenu
            ]);
        }

        // Ambil data user dalam bentuk json untuk DataTables
        public function list(Request $request)
        {
            $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
                ->with('level');

            return DataTables::of($users)
                // Menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
                ->addIndexColumn()
                // Menambahkan kolom aksi (tombol Detail, Edit, Hapus)
                ->addColumn('aksi', function ($user) {
                    $btn = '<a href="' . url('/user/' . $user->user_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                    $btn .= '<a href="' . url('/user/' . $user->user_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                    $btn .= '<form class="d-inline-block" method="POST" action="' . url('/user/' . $user->user_id) . '">'
                        . csrf_field() . method_field('DELETE') .
                        '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                    return $btn;
                })
                // Memberitahu bahwa kolom aksi berisi HTML
                ->rawColumns(['aksi'])
                ->make(true);
        }


    // Menampilkan halaman form tambah user
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list' => ['Home', 'User', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah user baru'
        ];

        $level = LevelModel::all(); // Ambil data level untuk ditampilkan di form
        $activeMenu = 'user'; // Set menu yang sedang aktif

        return view('user.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan data user baru
    public function store (Request $request)
    {
        $request->validate([
            // username harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_user kolom username
            "username" => "required|string|min:3|unique:m_user,username",
            'nama' => 'required|string|max:100', // nama harus diisi, berupa string, dan maksimal 100 karakter
            'password' => 'required|min:5', // password harus diisi dan minimal 5 karakter
            "level_id" => 'required|integer' // level_id harus diisi dan berupa angka
        ]);

        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password), // password dienkripsi sebelum disimpan
            "level_id" => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data user berhasil disimpan');
    }


    // Menampilkan detail user
    public function show(string $id)
    {
        $user = UserModel::with('level')->find($id);
        
        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Detail']
        ];
        
        $page = (object) [
            'title' => 'Detail user'
        ];
        
        $activeMenu = 'user'; // set menu yang sedang aktif
        
        return view('user.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'user' => $user,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menampilkan halaman form edit user
    public function edit(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::all();

        $breadcrumb = (object) [
            "title" => 'Edit User',
            "list" => ['Home', 'User', 'Edit']
        ];

        $page = (object) [
            'title' => "Edit user"
        ];

        $activeMenu = "user"; // set menu yang sedang aktif

        return view('user.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'user' => $user,
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan perubahan data user
    public function update(Request $request, string $id)
    {
        $request->validate([
            // username harus diisi, berupa string, minimal 3 karakter,
            // dan bernilai unik di tabel m_user kolom username kecuali untuk user dengan id yang sedang diedit
            "username" => "required|string|min:3|unique:m_user,username,$id,user_id",
            'nama' => 'required|string|max:100', // nama harus diisi, berupa string, dan maksimal 100 karakter
            'password' => 'nullable|string|min:5', // password bisa diisi (minimal 5 karakter) dan bisa tidak diisi
            "level_id" => 'required|integer' // level_id harus diisi dan berupa angka
        ]);

        UserModel::find($id)->update([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
            "level_id" => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data user berhasil diubah');
    }

    // Menghapus data user
    public function destroy(string $id)
    {
        $check = UserModel::find($id); // untuk mengecek apakah data user dengan id yang dimaksud ada atau tidak
        if (!$check) {
            return redirect('/user')->with('error', "Data user tidak ditemukan");
        }

        try {
            UserModel::destroy($id); // Hapus data user
            return redirect('/user')->with('success', 'Data user berhasil dihapus');
        } catch (QueryException $e) { // Gunakan QueryException yang sudah diimpor
            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

}