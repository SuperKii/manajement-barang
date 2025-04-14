<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Laravel\Prompts\Key;

class KategoriController extends Controller
{
    // Log Activity 
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
        $kategori = Kategori::all();
        return view('app.kategori.index', compact('kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('app.kategori.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $kategori = $request->validate([
            'nama_kategori' => 'required',
        ]);

        Kategori::create($kategori);

        // Log Activity
        $this->logActivity(
            Auth::user()->id_user,
            'Tambah Kategori',
            'Menambahkan Kategori ' . $request->nama_kategori
        );

        return redirect()->route('kategoriIndex');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kategoriEdit = Kategori::where('id_kategori', $id)->first();
        return view('app.kategori.update', compact('kategoriEdit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dataKategori = [
            'nama_kategori' => $request->nama_kategori,
        ];
        $oldData = (Kategori::where('id_kategori',$id)->first())->toArray();
        $proses = Kategori::where('id_kategori', $id)->update($dataKategori);
        $newData = (Kategori::where('id_kategori',$id)->first())->toArray();

        // Log Activity
        $this->logActivity(
            Auth::user()->id_user,
            'Mengubah Kategori',
            'Mengubah Kategori ' . $oldData['nama_kategori'] . ' -> ' . $newData['nama_kategori']
        );

        return redirect()->route('kategoriIndex');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $oldData = (Kategori::where('id_kategori',$id)->first())->toArray();
        $kategoriDel = Kategori::where('id_kategori', $id)->delete();

        // Log Activity
        $this->logActivity(
            Auth::user()->id_user,
            'Menghapus Kategori',
            'Menghapus Kategori ' . $oldData['nama_kategori']
        );

        return redirect()->route('kategoriIndex');
    }
}
