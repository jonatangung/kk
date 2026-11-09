<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\database;
use App\Exports\PelangganExport;
use Maatwebsite\Excel\Facades\Excel;

//----- PelangganController: menangani CRUD data pelanggan beserta export PDF/Excel
class PelangganController extends Controller
{
    // ==================== PELANGGAN ====================

    //----- pelanggan(): Menampilkan halaman daftar pelanggan (dengan filter tanggal)
    public function pelanggan(Request $request)
    {
        if (!session('u')) return redirect('/');

        return view('pelanggan', [
            'pelanggan' => $this->pelangganData($request),
        ]);
    }

    //----- pelangganData(): Mengambil data pelanggan dengan filter rentang tanggal (private, dipakai view/pdf/excel)
    private function pelangganData(Request $request)
    {
        return (new database)->tampilTanggal('pelanggan', $request->from, $request->to);
    }

    //----- tplg(): Menampilkan form tambah pelanggan baru
    public function tplg()
    {
        if (!session('u')) return redirect('/');

        $data['user'] = (new database)->tampil('users');

        return view('input_pelanggan', $data);
    }

    //----- aksi_tplg(): Menyimpan data pelanggan baru ke database
    public function aksi_tplg(Request $request)
    {
        if (!session('u')) return redirect('/');

        (new database)->tambah('pelanggan', [
            'kode_pelanggan' => 'PLG-' . now()->format('ymdHis'),
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
        ]);

        return redirect('/pelanggan');
    }

    //----- editPelanggan(): Menampilkan form edit pelanggan berdasarkan id
    public function editPelanggan($id)
    {
        if (!session('u')) return redirect('/');

        return view('edit_pelanggan', [
            'row' => DB::table('pelanggan')->where('id', $id)->first(),
        ]);
    }

    //----- updatePelanggan(): Memperbarui data pelanggan yang dipilih
    public function updatePelanggan(Request $request, $id)
    {
        if (!session('u')) return redirect('/');

        DB::table('pelanggan')->where('id', $id)->update([
            'kode_pelanggan' => $request->kode_pelanggan,
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'updated_at' => now(),
        ]);
        return redirect('/pelanggan');
    }

    //----- hapusPelanggan(): Menghapus data pelanggan berdasarkan id
    public function hapusPelanggan($id)
    {
        if (!session('u')) return redirect('/');

        DB::table('pelanggan')->where('id', $id)->delete();
        return redirect('/pelanggan');
    }

    //----- pdfPelanggan(): Mengunduh laporan data pelanggan dalam format PDF
    public function pdfPelanggan(Request $request)
    {
        if (!session('u')) return redirect('/');

        $export = new PelangganExport($this->pelangganData($request));

        $this->pdfTable('Laporan Data Pelanggan', 'laporan-pelanggan', $export->headings(), $export->collection()->all());
    }

    //----- excelPelanggan(): Mengunduh laporan data pelanggan dalam format Excel (.xlsx)
    public function excelPelanggan(Request $request)
    {
        if (!session('u')) return redirect('/');

        return Excel::download(
            new PelangganExport($this->pelangganData($request)),
            'laporan-pelanggan-' . date('Y-m-d') . '.xlsx'
        );
    }
}
