<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StokModel extends Model
{
    use HasFactory;

    protected $table ='t_stok'; // Mendefinisikan nama tabel
    protected $primaryKey ='stok_id'; // Mendefinisikan primary key
    protected $fillable = ['barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah'];

    public function Users(): BelongsTo {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }
    public function Barang(): BelongsTo {
        return $this->belongsTo(BarangModel::class, 'barang_id', 'barang_id');
    }
    public function Supplier(): BelongsTo {
        return $this->belongsTo(SupplierModel::class,'supplier_id','supplier_id'); // Mendefinisikan foreign key
    }
}