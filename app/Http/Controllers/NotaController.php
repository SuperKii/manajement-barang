<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Nota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $barang = Barang::all();
        // return view('app.penerimaan.add',compact('barang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validateNota = $request->validate([
                'barang_id' => 'required',
                'jumlah' => 'required'
            ]);

            $data = $request->all();
            $data['user_id'] = Auth::user()->id_user;

            $createNota = Nota::create($data);

            if($createNota == 0) {
                return redirect()->back()->with('error','Gagal membuat nota');
            }

            return redirect()->back()->with('success', 'Berhasil membuat nota');
        } catch (\Exception $e) {
            // Kalau ada error dari database 
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat nota.');
        }
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
    public function destroy(string $id) {}
}
