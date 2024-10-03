<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenjualanModel extends Model
{
    use HasFactory;
    protected $table = 't_penjualan'; // Mendefinisikan nama tabel
    protected $primaryKey = 'penjualan_id'; // Mendefinisikan primary key
    protected $fillable = ['user_id','pembeli','user_id', 'penjualan_tanggal'];

    // Relasi ke UserModel (belongsTo)
    public function Users(): BelongsTo {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id'); // Mendefinisikan foreign key
    }
    public function PenjualanDetail(): BelongsTo {
        return $this->belongsTo(PenjualanDetailModel::class, 'penjualan_id', 'penjualan_id'); // Mendefinisikan foreign key
    }
}