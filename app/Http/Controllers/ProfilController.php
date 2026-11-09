<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//----- ProfilController: menangani halaman dan update profil user yang sedang login
class ProfilController extends Controller
{
    // ==================== PROFIL ====================

    //----- profil(): Menampilkan halaman profil user yang sedang login
    public function profil()
    {
        if (!session('u')) return redirect('/');

        $user = DB::table('users')->where('nama', session('u'))->first();

        return view('profil', ['user' => $user]);
    }

    //----- updateProfil(): Memperbarui profil user sendiri (nama, email, no_hp, password opsional, foto opsional)
    public function updateProfil(Request $request)
    {
        if (!session('u')) return redirect('/');

        $request->validate([
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = DB::table('users')->where('nama', session('u'))->first();

        if (!$user) {
            return redirect('/profil');
        }

        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'updated_at' => now(),
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                $this->hapusFoto($user->foto);
            }
            $data['foto'] = $this->simpanFoto($request->file('foto'));
        }

        DB::table('users')->where('id', $user->id)->update($data);
        session([
            'u' => $request->nama,
            'foto' => $data['foto'] ?? $user->foto,
        ]);

        return redirect('/profil');
    }
}
