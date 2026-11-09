<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\PenggunaExport;
use Maatwebsite\Excel\Facades\Excel;

//----- PenggunaController: menangani CRUD data pengguna/pengguna sistem beserta export PDF/Excel
class PenggunaController extends Controller
{
    // ==================== PENGGUNA ====================

    //----- pengguna(): Menampilkan halaman daftar pengguna/pengguna sistem
    public function pengguna()
    {
        if (!session('u')) return redirect('/');

        return view('pengguna', ['rows' => $this->penggunaData()]);
    }

    //----- penggunaData(): Mengambil data users untuk ditampilkan (private)
    private function penggunaData()
    {
        return DB::table('users')
            ->select('id', 'nama', 'email', 'role', 'no_hp', 'foto', 'is_active', 'created_at')
            ->get();
    }

    //----- tambahPengguna(): Menampilkan form tambah pengguna baru
    public function tambahPengguna()
    {
        if (!session('u')) return redirect('/');

        return view('input_pengguna');
    }

    //----- simpanPengguna(): Menyimpan pengguna baru beserta upload foto
    public function simpanPengguna(Request $request)
    {
        if (!session('u')) return redirect('/');

        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        DB::table('users')->insert([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role,
            'no_hp' => $request->no_hp,
            'is_active' => 0,
            'foto' => $this->simpanFoto($request->file('foto')),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/pengguna');
    }

    //----- editPengguna(): Menampilkan form edit pengguna berdasarkan id
    public function editPengguna($id)
    {
        if (!session('u')) return redirect('/');

        return view('edit_pengguna', [
            'row' => DB::table('users')->where('id', $id)->first(),
        ]);
    }

    //----- updatePengguna(): Memperbarui data pengguna; ganti foto jika diupload dan sinkronkan session jika mengedit diri sendiri
    public function updatePengguna(Request $request, $id)
    {
        if (!session('u')) return redirect('/');

        $request->validate([
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = DB::table('users')->where('id', $id)->first();
        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
            'no_hp' => $request->no_hp,
            'updated_at' => now(),
        ];

        if ($request->hasFile('foto')) {
            if ($user && $user->foto) {
                $this->hapusFoto($user->foto);
            }
            $data['foto'] = $this->simpanFoto($request->file('foto'));
        }

        DB::table('users')->where('id', $id)->update($data);

        if ($user && (int) session('id_user') === (int) $id) {
            session([
                'u' => $request->nama,
                'role' => $request->role,
                'foto' => $data['foto'] ?? $user->foto,
            ]);
        }

        return redirect('/pengguna');
    }

    //----- hapusPengguna(): Menghapus foto lalu menghapus data pengguna berdasarkan id
    public function hapusPengguna($id)
    {
        if (!session('u')) return redirect('/');

        $user = DB::table('users')->where('id', $id)->first();
        if ($user && $user->foto) {
            $this->hapusFoto($user->foto);
        }
        DB::table('users')->where('id', $id)->delete();
        return redirect('/pengguna');
    }

    //----- pdfPengguna(): Mengunduh laporan data pengguna dalam format PDF
    public function pdfPengguna()
    {
        if (!session('u')) return redirect('/');

        $export = new PenggunaExport($this->penggunaData());

        $this->pdfTable('Laporan Data Pengguna', 'laporan-pengguna', $export->headings(), $export->collection()->all());
    }

    //----- excelPengguna(): Mengunduh laporan data pengguna dalam format Excel (.xlsx)
    public function excelPengguna()
    {
        if (!session('u')) return redirect('/');

        return Excel::download(
            new PenggunaExport($this->penggunaData()),
            'laporan-pengguna-' . date('Y-m-d') . '.xlsx'
        );
    }
}
