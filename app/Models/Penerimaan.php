<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Penerimaan extends Model
{
    use HasFactory;

    protected $table = 'penerimaan';
    protected $primaryKey = 'id_terima';
    protected $fillable = [
        'user_id',
        'transaksi_id',
        'kode_terima',
        'asal',
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
            $tanggal = Carbon::now()->format('Ymd'); // Format YYYYMMDD 

            $count = Penerimaan::where('kode_terima', 'LIKE', "TRM-{$tanggal}-%")->count() + 1;

            // Format Kode: TRM-NAMABARANG-YYYYMMDDXXX
            $model->kode_terima = "TRM-{$tanggal}-" . str_pad($count, 3, '0', STR_PAD_LEFT);
        });
    }
}
