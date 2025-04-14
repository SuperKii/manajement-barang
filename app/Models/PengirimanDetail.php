<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class PengirimanDetail extends Model
{
    use HasFactory;

    protected $table = 'pengiriman_detail';
    protected $primaryKey = 'id_kirim_detail';
    protected $fillable = [
        'kode_kirim_detail',
        'barang_id',
        'kirim_id',
        'jumlah',
    ];

    public function barang() {
        return $this->belongsTo(Barang::class,'barang_id','id_barang');
    }
    public function kirim() {
        return $this->belongsTo(Pengiriman::class,'kirim_id','id_kirim');
    }


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $tanggal = Carbon::now()->format('Ymd'); // Format YYYYMMDD (20240225)

            $barang = $model->barang;  
            if (!$barang) {
                throw new \Exception("Barang tidak ditemukan!");
            }

            $nama_barang = strtoupper(Str::slug($barang->nama_barang, '_'));

            $count = PengirimanDetail::where('kode_kirim_detail', 'LIKE', "KRM-{$nama_barang}-{$tanggal}%")->count() + 1;

            // Format Kode: KRM-NAMABARANG-YYYYMMDDXXX
            $model->kode_kirim_detail = "KRM-{$nama_barang}-{$tanggal}" . str_pad($count, 3, '0', STR_PAD_LEFT);
        });
    }
}
