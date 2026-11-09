<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\database;
use App\Exports\MekanikExport;
use Maatwebsite\Excel\Facades\Excel;

//----- MekanikController: menangani CRUD data mekanik beserta export PDF/Excel
class MekanikController extends Controller
{
    // ==================== MEKANIK ====================

    //----- karyawan(): Menampilkan halaman daftar mekanik
    public function karyawan()
    {
        if (!session('u')) return redirect('/');

        return view('mekanik', ['karyawan' => $this->mekanikData()]);
    }

    //----- mekanikData(): Mengambil seluruh data mekanik dari database (private)
    private function mekanikData()
    {
        return DB::table('mekanik')->get();
    }

    //----- tkry(): Menampilkan form tambah mekanik baru
    public function tkry()
    {
        if (!session('u')) return redirect('/');

        return view('input_mekanik');
    }

    //----- aksi_tkry(): Menyimpan data mekanik baru dan mengaitkannya dengan user yang login
    public function aksi_tkry(Request $request)
    {
        if (!session('u')) return redirect('/');

        $user = (new database)->tarik('users', ['nama' => session('u')]);

        if (!$user) {
            return redirect('/tkry');
        }

        $data = [
            'user_id' => $user->id,
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'spesialisasi' => $request->spesialisasi,
            'status' => 'aktif',
        ];

        DB::table('mekanik')->insert($data);

        return redirect('/mekanik');
    }

    //----- editMekanik(): Menampilkan form edit mekanik berdasarkan id
    public function editMekanik($id)
    {
        if (!session('u')) return redirect('/');

        return view('edit_mekanik', [
            'row' => DB::table('mekanik')->where('id', $id)->first(),
        ]);
    }

    //----- updateMekanik(): Memperbarui data mekanik yang dipilih
    public function updateMekanik(Request $request, $id)
    {
        if (!session('u')) return redirect('/');

        DB::table('mekanik')->where('id', $id)->update([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'spesialisasi' => $request->spesialisasi,
            'status' => $request->status,
            'updated_at' => now(),
        ]);
        return redirect('/mekanik');
    }

    //----- hapusMekanik(): Menghapus data mekanik berdasarkan id
    public function hapusMekanik($id)
    {
        if (!session('u')) return redirect('/');

        DB::table('mekanik')->where('id', $id)->delete();
        return redirect('/mekanik');
    }

    //----- pdfMekanik(): Mengunduh laporan data mekanik dalam format PDF
    public function pdfMekanik()
    {
        if (!session('u')) return redirect('/');

        $export = new MekanikExport($this->mekanikData());

        $this->pdfTable('Laporan Data Mekanik', 'laporan-mekanik', $export->headings(), $export->collection()->all());
    }

    //----- excelMekanik(): Mengunduh laporan data mekanik dalam format Excel (.xlsx)
    public function excelMekanik()
    {
        if (!session('u')) return redirect('/');

        return Excel::download(
            new MekanikExport($this->mekanikData()),
            'laporan-mekanik-' . date('Y-m-d') . '.xlsx'
        );
    }
}
