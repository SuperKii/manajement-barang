<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanTransaksi extends Model
{
    use HasFactory;
    
    protected $table = 'catatan_transaksi';
    protected $primaryKey = 'id_transaksi';
    protected $fillable = [
        'tipe'
    ];


    public function penerimaan()
    {
        return $this->hasMany(Penerimaan::class, 'transaksi_id');
    }

    // Relasi untuk pengiriman
    public function pengiriman()
    {
        return $this->hasMany(Pengiriman::class, 'transaksi_id');
    }
}
