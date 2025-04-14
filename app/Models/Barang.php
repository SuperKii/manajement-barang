<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    protected $fillable = [
        'nama_barang',
        'kategori_id',
        'stok',
        'satuan',
        'foto_barang'
    ];

    public function kategori() {
        return $this->belongsTo(Kategori::class,'kategori_id','id_kategori');
    }
}
