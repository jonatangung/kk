<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//----- LoginController: menangani halaman login, logout, registrasi, dan dashboard home
class LoginController extends Controller
{
    // ==================== LOGIN DAN DASHBOARD ====================

    //----- index(): Menampilkan halaman login
    public function index(){
        return view('login');
    }

    //----- aksilogin(): Memproses login — cek username/email & password, simpan session lalu redirect ke home
    public function aksilogin(Request $request){
        $username = $request->input('u');
        $password = $request->input('p');

        $hasilcek = DB::table('users')
            ->where(function ($query) use ($username) {
                $query->where('nama', $username)
                    ->orWhere('email', $username);
            })
            ->first();

        $passwordValid = $hasilcek && $hasilcek->password === $password;

        if($passwordValid){
            DB::table('users')->where('id', $hasilcek->id)->update([
                'is_active' => 1,
                'updated_at' => now(),
            ]);

            if ($hasilcek->role === 'mekanik') {
                DB::table('mekanik')->where('user_id', $hasilcek->id)->update([
                    'status' => 'aktif',
                    'updated_at' => now(),
                ]);
            }

            session([
                'u' => $hasilcek->nama,
                'id_user' => $hasilcek->id,
                'role' => $hasilcek->role,
                'foto' => $hasilcek->foto,
            ]);
            return redirect('/home');
        }
        else{
            return redirect('/');
        }
    }

    //----- logout(): Menandai user nonaktif lalu menghapus semua session dan kembali ke halaman login
    public function logout(){
        if (session('id_user')) {
            DB::table('users')->where('id', session('id_user'))->update([
                'is_active' => 0,
                'updated_at' => now(),
            ]);

            if (session('role') === 'mekanik') {
                DB::table('mekanik')->where('user_id', session('id_user'))->update([
                    'status' => 'nonaktif',
                    'updated_at' => now(),
                ]);
            }
        }

        session()->flush();
        return redirect('/');
    }

    //----- register(): Menampilkan halaman registrasi user baru
    public function register()
    {
        return view('girasya');
    }

    //----- simpanRegister(): Menyimpan user baru dari form registrasi (role admin)
    public function simpanRegister(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        DB::table('users')->insert([
            'nama' => $request->u,
            'email' => $request->e,
            'password' => $request->p,
            'role' => 'admin',
            'no_hp' => null,
            'foto' => $this->simpanFoto($request->file('foto')),
            'is_active' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/login');
    }

    //----- home(): Menampilkan dashboard beserta jumlah pelanggan, kendaraan, mekanik, dan servis
    public function home(Request $request){
        if (session('u')){
            return view('home', [
                'pelanggan' => DB::table('pelanggan')->count(),
                'kendaraan' => DB::table('kendaraan')->count(),
                'mekanik' => DB::table('mekanik')->count(),
                'servis' => DB::table('servis')->count(),
            ]);
        }
        else{
            return redirect('/');
        };
    }
}
