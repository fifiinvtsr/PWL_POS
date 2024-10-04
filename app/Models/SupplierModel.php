<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplierModel extends Model
{
    use HasFactory;
    protected $table ='m_supplier'; // Mendefinisikan nama tabel
    protected $primaryKey ='supplier_id'; // Mendefinisikan primary key
    protected $fillable = ['supplier_id','supplier_kode','supplier_nama','supplier_alamat'];

    public function Stok(): BelongsTo {
        return $this->belongsTo(StokModel::class,'supplier_id','supplier_id'); // Mendefinisikan foreign key
    }
}