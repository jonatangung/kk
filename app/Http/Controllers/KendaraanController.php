<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\KendaraanExport;
use Maatwebsite\Excel\Facades\Excel;

//----- KendaraanController: menangani CRUD data kendaraan beserta export PDF/Excel
class KendaraanController extends Controller
{
    // ==================== KENDARAAN ====================

    //----- kendaraan(): Menampilkan halaman daftar kendaraan
    public function kendaraan()
    {
        if (!session('u')) return redirect('/');

        return view('kendaraan', ['rows' => $this->kendaraanData()]);
    }

    //----- kendaraanData(): Mengambil seluruh data kendaraan dari database (private)
    private function kendaraanData()
    {
        return DB::table('kendaraan')
            ->join('pelanggan', 'kendaraan.pelanggan_id', '=', 'pelanggan.id')
            ->select('kendaraan.*', 'pelanggan.nama as nama_pelanggan')
            ->orderBy('kendaraan.no_polisi')
            ->get();
    }

    //----- tambahKendaraan(): Menampilkan form tambah kendaraan baru (beserta daftar pelanggan)
    public function tambahKendaraan()
    {
        if (!session('u')) return redirect('/');

        return view('input_kendaraan', [
            'pelanggan' => DB::table('pelanggan')
                ->select('id', 'nama', 'kode_pelanggan')
                ->orderBy('nama')
                ->get(),
        ]);
    }

    //----- simpanKendaraan(): Menyimpan data kendaraan baru ke database
    public function simpanKendaraan(Request $request)
    {
        if (!session('u')) return redirect('/');

        DB::table('kendaraan')->insert([
            'pelanggan_id' => $request->pelanggan_id,
            'no_polisi' => $request->no_polisi,
            'merk' => $request->merk,
            'model' => $request->model,
            'tahun' => $request->tahun,
            'warna' => $request->warna,
            'no_rangka' => $request->no_rangka,
            'no_mesin' => $request->no_mesin,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/kendaraan');
    }

    //----- editKendaraan(): Menampilkan form edit kendaraan berdasarkan id
    public function editKendaraan($id)
    {
        if (!session('u')) return redirect('/');

        return view('edit_kendaraan', [
            'row' => DB::table('kendaraan')->where('id', $id)->first(),
            'pelanggan' => DB::table('pelanggan')->orderBy('nama')->get(),
        ]);
    }

    //----- updateKendaraan(): Memperbarui data kendaraan yang dipilih
    public function updateKendaraan(Request $request, $id)
    {
        if (!session('u')) return redirect('/');

        DB::table('kendaraan')->where('id', $id)->update([
            'pelanggan_id' => $request->pelanggan_id,
            'no_polisi' => $request->no_polisi,
            'merk' => $request->merk,
            'model' => $request->model,
            'tahun' => $request->tahun,
            'warna' => $request->warna,
            'no_rangka' => $request->no_rangka,
            'no_mesin' => $request->no_mesin,
            'updated_at' => now(),
        ]);
        return redirect('/kendaraan');
    }

    //----- hapusKendaraan(): Menghapus data kendaraan berdasarkan id
    public function hapusKendaraan($id)
    {
        if (!session('u')) return redirect('/');

        DB::table('kendaraan')->where('id', $id)->delete();
        return redirect('/kendaraan');
    }

    //----- pdfKendaraan(): Mengunduh laporan data kendaraan dalam format PDF
    public function pdfKendaraan()
    {
        if (!session('u')) return redirect('/');

        $export = new KendaraanExport($this->kendaraanData());

        $this->pdfTable('Laporan Data Kendaraan', 'laporan-kendaraan', $export->headings(), $export->collection()->all());
    }

    //----- excelKendaraan(): Mengunduh laporan data kendaraan dalam format Excel (.xlsx)
    public function excelKendaraan()
    {
        if (!session('u')) return redirect('/');

        return Excel::download(
            new KendaraanExport($this->kendaraanData()),
            'laporan-kendaraan-' . date('Y-m-d') . '.xlsx'
        );
    }
}
