<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Pengiriman extends Model
{
    use HasFactory;

    protected $table = 'pengiriman';
    protected $primaryKey = 'id_kirim';
    protected $fillable = [
        'user_id',
        'transaksi_id',
        'kode_kirim',
        'tujuan',
        'status'
    ];

    public function user() {
        return $this->belongsTo(User::class,'user_id','id_user');
    }
    public function transaksi()
    {
        return $this->belongsTo(CatatanTransaksi::class, 'transaksi_id');
    }


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $tanggal = Carbon::now()->format('Ymd'); // Format YYYYMMDD (20240225)

            $count = Pengiriman::where('kode_kirim', 'LIKE', "KRM-{$tanggal}-%")->count() + 1;

            // Format Kode: KRM-NAMABARANG-YYYYMMDDXXX
            $model->kode_kirim = "KRM-{$tanggal}-" . str_pad($count, 3, '0', STR_PAD_LEFT);
        });
    }
}
