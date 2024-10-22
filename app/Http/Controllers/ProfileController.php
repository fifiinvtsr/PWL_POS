<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $id = session('user_id');
        $breadcrumb = (object) [
            'title' => 'Profil',
            'list' => ['Home', 'profile']
        ];
        $page = (object) [
            'title' => 'Profil'
        ];
        $activeMenu = 'profile'; // set menu yang sedang aktif
        $user = UserModel::with('level')->find($id);
        $level = LevelModel::all(); // ambil data level untuk filter level
        return view('profile.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    public function edit_ajax(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('profile.edit_ajax', ['user' => $user, 'level' => $level]);
    }

    // Menyimpan perubahan data user AJAX (termasuk foto)
    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|max:20|unique:m_user,username,' . $id . ',user_id',
                'nama'     => 'required|max:100',
                'password' => 'nullable|min:5|max:20',
                'foto'     => 'nullable|mimes:jpeg,png,jpg|max:4096'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal!',
                    'msgField' => $validator->errors()
                ]);
            }

            $user = UserModel::find($id);

            if ($user) {
                // Update foto jika di-upload
                if ($request->hasFile('foto')) {
                    $file = $request->file('foto');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $path = 'adminlte/dist/img/';
                    $file->move($path, $filename);

                    // Hapus foto lama jika ada
                    if ($user->foto && file_exists(public_path($user->foto))) {
                        unlink(public_path($user->foto));
                    }

                    $user->foto = $path . $filename;
                }

                // Update data lainnya
                $user->username = $request->username;
                $user->nama = $request->nama;
                $user->level_id = $request->level_id;
                
                // Hanya update password jika diisi
                if ($request->filled('password')) {
                    $user->password = bcrypt($request->password);
                }

                $user->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate!'
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

    // Khusus untuk update foto
    public function update_foto(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'foto' => 'required|mimes:jpeg,png,jpg|max:4096'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $user = UserModel::find($id);

            if ($user) {
                if ($request->hasFile('foto')) {
                    $file = $request->file('foto');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $path = 'adminlte/dist/img/';
                    $file->move($path, $filename);

                    // Hapus foto lama jika ada
                    if ($user->foto && file_exists(public_path($user->foto))) {
                        unlink(public_path($user->foto));
                    }

                    $user->update(['foto' => $path . $filename]);

                    return response()->json([
                        'status' => true,
                        'message' => 'Foto berhasil diupdate!'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan!'
                ]);
            }
        }

        return redirect('/');
    }
}