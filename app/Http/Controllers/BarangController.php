<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class BarangController extends Controller
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
        $barang = Barang::all();

        // dd($barang);
        return view('app.barang.index', compact('barang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = Kategori::all();
        return view('app.barang.add', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $barang = $request->validate([
                'nama_barang' => 'required',
                'kategori_id' => 'required',
                'stok' => 'required',
                'satuan' => 'required',
                'foto_barang' => 'required',
            ]);
            $barang = $request->all();
            if ($request->has('foto_barang')) {
                $foto_barang = $request->file('foto_barang');
                $nama_foto_barang =  $request->nama_barang . '.' . $foto_barang->getClientOriginalExtension();
                $foto_barang->move('foto_barang', $nama_foto_barang);
                $barang['foto_barang'] = $nama_foto_barang;
            }

            $store = Barang::create($barang);

            if ($store == 0) {
                return redirect()->back()->with('error', 'Gagal Menambah Data Barang');
            }

            $this->logActivity(
                Auth::user()->id_user,
                'Tambah Barang',
                'Menambahkan Barang ' . $request->nama_barang
            );

            return redirect()->route('barangIndex')->with('success', 'Berhasil menambah data barang');
        } catch (\Exception $e) {
            // Kalau ada error dari database
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambah barang.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $barangShow = Barang::where('id_barang', $id)->first();
        return view('app.barang.show', compact('barangShow'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kategori = Kategori::all();
        $barangEdit = Barang::where('id_barang', $id)->first();
        return view('app.barang.edit', compact('barangEdit', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $barang = Barang::where('id_barang', $id)->first();
            $dataBarang = Request()->except(['_token']);
            if ($request->has('foto_barang')) {
                File::delete('foto_barang/' . $barang->foto_barang);
                $foto_barang = $request->file('foto_barang');
                $nama_foto =  $request->nama_barang . '.' . $foto_barang->getClientOriginalExtension();
                $foto_barang->move('foto_barang', $nama_foto);
                $dataBarang['foto_barang'] = $nama_foto;
            } else {
                unset($dataBarang['foto_barang']);
            }

            $update = Barang::where('id_barang', $id)->update($dataBarang);
            if ($update == 0) {
                return redirect()->back()->with('error', 'Gagal mengubah Data Barang');
            }

            $this->logActivity(
                Auth::user()->id_user,
                'Mengubah Barang',
                'Mengubah Data Barang ' . $request->nama_barang
            );

            return redirect()->route('barangIndex') - with('success', 'Berhasil mengubah data barang');
        } catch (\Exception $e) {
            // Kalau ada error dari database
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengubah barang.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
        $deleteFoto = Barang::where('id_barang', $id)->first();
        $oldData = (Barang::where('id_barang', $id)->first())->toArray();
        File::delete('foto_barang/' . $deleteFoto->foto_barang);

        $delete = Barang::where('id_barang', $id)->delete();

            if ($delete == 0) {
                return redirect()->back()->with('error', 'Gagal menghapus Data Barang');
            }

        $this->logActivity(
            Auth::user()->id_user,
            'Menghapus Barang',
            'Menghapus Data Barang ' . $oldData['nama_barang']
        );

        return redirect()->back()->with('success','Berhasil menghapus data barang');
        } catch (\Exception $e) {
            // Kalau ada error dari database 
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus barang.');
        }
    }
}
