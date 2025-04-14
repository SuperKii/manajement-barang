<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatStok extends Model
{
    use HasFactory;

    protected $table = 'riwayat_stok';
    protected $primaryKey = 'id_riwayat_stok';
    protected $fillable = [
        'user_id',
        'barang_id',
        'type',
        'jumlah',
        'deskripsi',
    ];

    public function barang() {
        return $this->belongsTo(Barang::class,'barang_id','id_barang');
    }
    public function user() {
        return $this->belongsTo(User::class,'user_id','id_user');
    }
}
