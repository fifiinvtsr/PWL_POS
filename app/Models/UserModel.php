<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject; //praktikum 1 js 9
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable; //implementasi class Aunthenticatable

class UserModel extends Authenticatable implements JWTSubject
{
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    use HasFactory;

    protected $table = 'm_user';        //mendefinisikan nama tabel yang digunakan UserModel
    protected $primaryKey = 'user_id';  //mendefinisikan primary key dari tabel yang digunakan
    protected $fillable = ['level_id', 'username', 'nama', 'password', 'foto', 'created_at', 'updated_at'];

    protected $hidden = ['password']; //jangan ditampilkan saat select
    protected $casts = ['password' => 'hashed']; //casting password agar otomatis di-hash

    //Relasi tabel m_user ke m_level (many-to-one)
    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    //Mendapatkan nama role
    public function getRoleName(): string
    {
        return $this->level->level_nama;
    }

    //Memeriksa bila user memiliki role tertentu
    public function hasRole($role): bool
    {
        return $this->level->level_kode == $role;
    }

    //Mendapatkan kode role
    public function getRole()
    {
        return $this->level->level_kode;
    }
}