<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    use HasFactory;

    protected $table = 'nota';
    protected $primaryKey = 'id_nota';
    protected $fillable = [
        'user_id',
        'barang_id',
        'jumlah',
    ];

    public function barang() {
        return $this->belongsTo(Barang::class,'barang_id','id_barang');
    }
}
