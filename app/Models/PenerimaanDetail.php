<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenerimaanDetail extends Model
{
    use HasFactory;

    protected $table = 'penerimaan_detail';
    protected $primaryKey = 'id_terima_detail';
    protected $fillable = [
        'kode_terima_detail',
        'barang_id',
        'terima_id',
        'jumlah',
    ];

    public function barang() {
        return $this->belongsTo(Barang::class,'barang_id','id_barang');
    }
    public function terima() {
        return $this->belongsTo(Penerimaan::class,'terima_id','id_terima');
    }


}
