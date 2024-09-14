<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() {
        $data= [
            // 'username' => 'customer-1',
            // 'nama' => 'Pelanggan',
            // 'password' => Hash::make('12345'),
            // 'level_id' => 4
            'nama' => 'Pelanggan Pertama',
        ];
        // UserModel::insert($data);
        UserModel::where('username', 'customer-1')->update($data);

        $user=UserModel::all();
        return view('user', ['data' => $user]);
    }
}
