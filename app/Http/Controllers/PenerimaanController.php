<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\CatatanTransaksi;
use App\Models\LogActivity;
use App\Models\Nota;
use App\Models\Penerimaan;
use App\Models\PenerimaanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PenerimaanController extends Controller
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
        $penerimaan = Penerimaan::where('status', 'PENDING')->get();
        return view('app.penerimaan.index', compact('penerimaan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nota = Nota::where('user_id', Auth::user()->id_user)->get();
        $barang = Barang::all();

        return view('app.penerimaan.nota', compact('nota', 'barang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatepenerimaan = $request->validate([
                'asal' => 'required',
            ]);

            $catatan_transaksi = new CatatanTransaksi();
            $catatan_transaksi->tipe = 'PENERIMAAN';
            $catatan_transaksi->save();
            $id_transaksi = $catatan_transaksi->id_transaksi;

            $penerimaan = new Penerimaan;
            $penerimaan->user_id = Auth::user()->id_user;
            $penerimaan->transaksi_id = $id_transaksi;
            $penerimaan->asal = $request->asal;
            $penerimaan->status = 'PENDING';
            $penerimaan->save();
            // validator
            if ($catatan_transaksi && $penerimaan == 0) {
                return redirect()->back()->with('error', 'Gagal membuat data penerimaan');
            }

            $id_penerimaan = $penerimaan->id_terima;

            for ($i = 0; $i < count($request->barang_id); $i++) {

                $tanggal = Carbon::now()->format('Ymd'); // Format YYYYMMDD (20240225)
                $barang = Barang::where('id_barang', $request->barang_id[$i])->first();
                $nama_barang = strtoupper(Str::slug($barang->nama_barang, '_'));

                $count = PenerimaanDetail::where('kode_terima_detail', 'LIKE', "TRM-{$nama_barang}-{$tanggal}-%")->count() + 1;

                // Format Kode: TRM-NAMABARANG-YYYYMMDDXXX
                $kode_terima_detail = "TRM-{$nama_barang}-{$tanggal}-" . str_pad($count, 3, '0', STR_PAD_LEFT);

                $detail_penerimaan = DB::table('penerimaan_detail')->insert([
                    'kode_terima_detail' => $kode_terima_detail,
                    'barang_id' => $request->barang_id[$i],
                    'terima_id' => $id_penerimaan,
                    'jumlah' => $request->jumlah[$i],
                    'created_at' => now(),
                ]);
                // validator
                if ($detail_penerimaan == 0) {
                    return redirect()->back()->with('error', 'Gagal membuat data detail penerimaan');
                }

                $nota = Nota::where([['user_id', Auth::user()->id_user], ['barang_id', $request->barang_id[$i]]])->delete();
                // validator
                if ($nota == 0) {
                    return redirect()->back()->with('error', 'Gagal menghapus data nota penerimaan');
                }
            }

            $this->logActivity(
                Auth::user()->id_user,
                'Menerima Barang',
                'Menerima Barang Dari  ' . $request->asal
            );

            return redirect()->route('penerimaanIndex')->with('success', 'Berhasil membuat data penerimaan');
        } catch (\Exception $e) {
            // Kalau ada error dari database 
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat data penerimaan.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data_penerimaan = Penerimaan::where('id_terima', $id)->first();
        $detail = PenerimaanDetail::where('terima_id', $id)->get();
        return view('app.penerimaan.detail.index', compact('data_penerimaan', 'detail'));
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
