<?php

namespace App\Http\Controllers;

use App\Models\LogActivity;
use App\Models\User;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
        $user = User::all();
        return view('app.user.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('app.user.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $user = $request->validate([
                'nama' => 'required',
                'email' => 'required',
                'password' => 'required',
                'role' => 'required',
                'alamat' => 'required',
                'no_hp' => 'required',
                'foto_profile' => 'required',
            ]);
            $user = $request->all();
            if ($request->has('foto_profile')) {
                $foto_profile = $request->file('foto_profile');
                $nama_foto_profile =  $request->nama . '.' . $foto_profile->getClientOriginalExtension();
                $foto_profile->move('foto_profile', $nama_foto_profile);
                $user['foto_profile'] = $nama_foto_profile;
            }

            $user['password'] = Hash::make($request->password);

            $store = User::create($user);

            if ($store == 0) {
                return redirect()->back()->with('error', 'Gagal Menambah Data user');
            }

            $this->logActivity(
                Auth::user()->id_user,
                'Tambah User',
                'Menambahkan User ' . $request->nama
            );

            return redirect()->route('userIndex')->with('success', 'Berhasil menambah data user');
        } catch (\Exception $e) {
            // Kalau ada error dari database
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambah data user.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $userShow = User::where('id_user', $id)->first();
        return view('app.user.show', compact('userShow'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $userEdit = User::where('id_user', $id)->first();
        return view('app.user.edit', compact('userEdit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = $request->validate([
                'nama' => 'required',
                'email' => 'required',
                'alamat' => 'required',
                'no_hp' => 'required',
            ]);
            $updateUser = User::where('id_user', $id)->first();
            $updateUser['nama'] = $request->nama;
            $updateUser['email'] = $request->email;
            $updateUser['alamat'] = $request->alamat;
            $updateUser['no_hp'] = $request->no_hp;
            if ($request->has('foto_profile')) {
                File::delete('foto_profile/' . $updateUser->foto_profile);
                $foto_profile = $request->file('foto_profile');
                $nama_foto =  $request->nama . '.' . $foto_profile->getClientOriginalExtension();
                $foto_profile->move('foto_profile', $nama_foto);
                $updateUser['foto_profile'] = $nama_foto;
            } else {
                unset($updateUser['foto_profile']);
            }

            if (isset($request->password)) {
                $updateUser['password'] = Hash::make($request->password);
            }

            $updateUser->save();

            if ($updateUser == 0) {
                return redirect()->back()->with('error', 'Gagal mengubah Data user');
            }

            $this->logActivity(
                Auth::user()->id_user,
                'Mengubah User',
                'Mengubah Data User ' . $request->nama
            );

            return redirect()->route('userIndex')->with('success', 'Berhasil mengubah data user');
        } catch (\Exception $e) {
            // Kalau ada error dari database
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengubah data user.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            $deleteFoto = User::where('id_user', $id)->first();
            $oldData = (User::where('id_user', $id)->first())->toArray();
            File::delete('foto_profile/' . $deleteFoto->foto_barang);

            $delete = User::where('id_user', $id)->delete();
            if ($delete == 0) {
                return redirect()->back()->with('error', 'Gagal menghapus data user');
            }

            $this->logActivity(
                Auth::user()->id_user,
                'Menghapus User',
                'Menghapus User ' . $oldData['nama']
            );

            return redirect()->back()->with('success', 'Berhasil menghapus data user');
        } catch (\Exception $e) {
            // Kalau ada error dari database
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data user.');
        }
    }
}
