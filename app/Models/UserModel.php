<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Casts\Attribute;

class UserModel extends Authenticatable implements JWTSubject
{
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }

    use HasFactory;
    protected $table = 'm_user';
    protected $primaryKey = 'user_id';
    // protected $fillable =['level_id', 'username', 'nama', 'password', 'created_at', 'profile_image', 'updated_at'];
    protected $fillable = [
        'username',
        'nama',
        'password',
        'level_id',
        'image'
    ];

    protected $casts = ['password' => 'hashed'];

    public function level() : BelongsTo
    {
        return $this -> belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    //nama role
    public function getRoleName(): string{
        return $this->level->level_nama;
    }

    // apakah user memiliki role tertentu
    public function hasRole($role): bool{
        return $this ->level->level_kode == $role;
    }

    //Mendapatkan kode role
    public function getRole()
    {
        return $this->level->level_kode;
    }

    protected function image(): Attribute 
    {
        return Attribute::make(
            get: fn ($image) => url('/storage/posts/'.$image),
        );
    }
}