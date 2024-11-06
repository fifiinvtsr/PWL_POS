<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserModel;

class UserController extends Controller
{
    public function index()
    {
        return UserModel::all();
    }

    public function store(Request $request)
    {
        $id = UserModel::create($request->all());
        return response()->json($id, 201);
    }


    public function show(UserModel $id) 
    {
        return response()->json($id);
    }
    
    public function update(Request $request, UserModel $id)
    {
        $id->update($request->all());
        return response()->json($id);
    }

    public function destroy(UserModel $id)
    {
        $id->delete();
        return response()->json([
            'success' => true,
            'message' => "Data terhapus",
        ]);
    }
}