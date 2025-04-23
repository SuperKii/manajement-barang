<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\CatatanTransaksi;
use App\Models\LogActivity;
use App\Models\Nota;
use App\Models\Pengiriman;
use App\Models\PengirimanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PengirimanController extends Controller
{
    private function logActivity($userId, $aksi, $deskripsi)
    {
        LogActivity::create([
            'user_id' => $userId,
            'aksi' => $aksi,
            'deskripsi' => $deskripsi,
            'created_at' => Carbon::now()->format('d-m-Y H:i')
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengiriman = Pengiriman::where('status', 'PENDING')->get();

        return view('app.pengiriman.index', compact('pengiriman'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nota = Nota::where('user_id', Auth::user()->id_user)->get();
        $barang = Barang::all();

        return view('app.pengiriman.nota', compact('nota', 'barang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatepengiriman = $request->validate([
                'tujuan' => 'required',

            ]);

            $catatan_transaksi = new CatatanTransaksi();
            $catatan_transaksi->tipe = 'PENGIRIMAN';
            $catatan_transaksi->save();
            $id_transaksi = $catatan_transaksi->id_transaksi;

            $pengiriman = new Pengiriman();
            $pengiriman->user_id = Auth::user()->id_user;
            $pengiriman->transaksi_id = $id_transaksi;
            $pengiriman->tujuan = $request->tujuan;
            $pengiriman->status = 'PENDING';
            $pengiriman->save();

            // validator
            if ($catatan_transaksi && $pengiriman == 0) {
                return redirect()->back()->with('error', 'Gagal membuat data pengiriman');
            }

            $id_pengiriman = $pengiriman->id_kirim;

            for ($i = 0; $i < count($request->barang_id); $i++) {
                $tanggal = Carbon::now()->format('Ymd'); // Format YYYYMMDD (20240225)
                $barang = Barang::where('id_barang', $request->barang_id[$i])->first();
                $nama_barang = strtoupper(Str::slug($barang->nama_barang, '_'));

                $count = PengirimanDetail::where('kode_kirim_detail', 'LIKE', "KRM-{$nama_barang}-{$tanggal}-%")->count() + 1;

                // Format Kode: KRM-NAMABARANG-YYYYMMDDXXX
                $kode_kirim_detail = "KRM-{$nama_barang}-{$tanggal}-" . str_pad($count, 3, '0', STR_PAD_LEFT);

                $detail_pengiriman = DB::table('pengiriman_detail')->insert([
                    'kode_kirim_detail' => $kode_kirim_detail,
                    'barang_id' => $request->barang_id[$i],
                    'kirim_id' => $id_pengiriman,
                    'jumlah' => $request->jumlah[$i],
                    'created_at' => now(),
                ]);
                //validator
                if ($detail_pengiriman == 0) {
                    return redirect()->back()->with('error', 'Gagal membuat data detail pengiriman');
                }

                $nota = Nota::where([['user_id', Auth::user()->id_user], ['barang_id', $request->barang_id[$i]]])->delete();
                if ($nota == 0) {
                    return redirect()->back()->with('error', 'Gagal menghapus data nota pengiriman');
                }
            }

            $this->logActivity(
                Auth::user()->id_user,
                'Mengirim Barang',
                'Mengirim Barang Ke  ' . $request->tujuan
            );

            return redirect()->route('pengirimanIndex')->with('success', 'Berhasil membuat data pengiriman');
        } catch (\Exception $e) {
            // Kalau ada error dari database 
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat data pengiriman.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data_pengiriman = Pengiriman::where('id_kirim', $id)->first();
        $detail = PengirimanDetail::where('kirim_id', $id)->get();
        return view('app.pengiriman.detail.index', compact('data_pengiriman', 'detail'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
