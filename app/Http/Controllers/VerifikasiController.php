<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\CatatanTransaksi;
use App\Models\LogActivity;
use App\Models\Penerimaan;
use App\Models\PenerimaanDetail;
use App\Models\Pengiriman;
use App\Models\PengirimanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VerifikasiController extends Controller
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

    public function indexPenerimaan()
    {
        $dataPenerimaan = Penerimaan::where('status', 'PENDING')->get();
        return view('app.verifikasi.penerimaan.index', compact('dataPenerimaan'));
    }

    public function indexPengiriman()
    {
        $dataPengiriman = Pengiriman::where('status', 'PENDING')->get();
        return view('app.verifikasi.pengiriman.index', compact('dataPengiriman'));
    }
    public function indexCatatanTransaksi()
    {
        $catatan_transaksi = CatatanTransaksi::all();
        return view('app.verifikasi.catatanTransaksi.index', compact('catatan_transaksi'));
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatePenerimaan(Request $request, string $id)
    {
        $validateUpdatePenerimaan = $request->validate([
            'status' => 'required'
        ]);

        $updateStatus = Penerimaan::where('id_terima', $id)->first();
        if ($request->status == 'VERIFIED') {
            $updateStatus['status'] = $request->status;
        } else {
            $updateStatus['status'] = 'REJECTED';
        }
        $updateStatus->save();

        $dataPenerimaan = Penerimaan::where('id_terima', $id)->first();
        $dataDetail = PenerimaanDetail::where('terima_id', $id)->get();
        if ($request->status == 'VERIFIED') {
            for ($i = 0; $i < count($dataDetail); $i++) {
                $riwayat_stok = DB::table('riwayat_stok')->insert([
                    'user_id' => $dataPenerimaan['user_id'],
                    'barang_id' => $dataDetail[$i]['barang_id'],
                    'type' => 'IN',
                    'jumlah' => $dataDetail[$i]['jumlah'],
                    'deskripsi' => 'Penerimaan Barang Sejumlah = ' . $dataDetail[$i]['jumlah'],
                    'created_at' => now(),
                ]);
                $updateStok = Barang::where('id_barang', $dataDetail[$i]['barang_id'])->first();
                $updateStok['stok'] = $updateStok['stok'] + $dataDetail[$i]['jumlah'];
                $updateStok->save();
            }

            $this->logActivity(
                Auth::user()->id_user,
                'Memverifikasi Penerimaan',
                'Memverifikasi Penerimaan Dengan Kode ' . $dataPenerimaan['kode_terima']
            );
        } else {
            $this->logActivity(
                Auth::user()->id_user,
                'Mereject Penerimaan',
                'Mereject Penerimaan Dengan Kode ' . $dataPenerimaan['kode_terima']
            );
        }

        return redirect()->back();
    }
    public function updatePengiriman(Request $request, string $id)
    {
        $validateUpdatePengiriman = $request->validate([
            'status' => 'required'
        ]);

        $updateStatus = Pengiriman::where('id_kirim', $id)->first();
        if ($request->status == 'VERIFIED') {
            $updateStatus['status'] = $request->status;
        } else {
            $updateStatus['status'] = 'REJECTED';
        }
        $updateStatus->save();

        $dataPengiriman = Pengiriman::where('id_kirim', $id)->first();
        $dataDetail = PengirimanDetail::where('kirim_id', $id)->get();
        if ($request->status == 'VERIFIED') {
            for ($i = 0; $i < count($dataDetail); $i++) {
                $riwayat_stok = DB::table('riwayat_stok')->insert([
                    'user_id' => $dataPengiriman['user_id'],
                    'barang_id' => $dataDetail[$i]['barang_id'],
                    'type' => 'OUT',
                    'jumlah' => $dataDetail[$i]['jumlah'],
                    'deskripsi' => 'Pengiriman Barang Sejumlah = ' . $dataDetail[$i]['jumlah'],
                    'created_at' => now(),
                ]);

                $updateStok = Barang::where('id_barang', $dataDetail[$i]['barang_id'])->first();
                $updateStok['stok'] = $updateStok['stok'] - $dataDetail[$i]['jumlah'];
                $updateStok->save();
            }

            $this->logActivity(
                Auth::user()->id_user,
                'Memverifikasi Pengiriman',
                'Memverifikasi Pengiriman Dengan Kode ' . $dataPengiriman['kode_kirim']
            );
        } else {
            $this->logActivity(
                Auth::user()->id_user,
                'Mereject Pengiriman',
                'Mereject Pengiriman Dengan Kode ' . $dataPengiriman['kode_kirim']
            );
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
