<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\JasaServisExport;
use Maatwebsite\Excel\Facades\Excel;

//----- JasaServisController: menangani CRUD data jasa servis beserta export PDF/Excel
class JasaServisController extends Controller
{
    // ==================== JASA SERVIS ====================

    //----- jasaServis(): Menampilkan halaman daftar jasa servis
    public function jasaServis()
    {
        if (!session('u')) return redirect('/');

        return view('jasa-servis', ['rows' => $this->jasaServisData()]);
    }

    //----- jasaServisData(): Mengambil seluruh data jasa servis dari database (private)
    private function jasaServisData()
    {
        return DB::table('jasa_servis')->get();
    }

    //----- tambahJasaServis(): Menampilkan form tambah jasa servis baru
    public function tambahJasaServis()
    {
        if (!session('u')) return redirect('/');

        return view('input_jasa_servis');
    }

    //----- simpanJasaServis(): Menyimpan jasa servis baru dengan kode otomatis JS_xxx
    public function simpanJasaServis(Request $request)
    {
        if (!session('u')) return redirect('/');

        $lastKode = DB::table('jasa_servis')
            ->where('kode_jasa', 'like', 'JS_%')
            ->orderByDesc('kode_jasa')
            ->value('kode_jasa');

        $next = $lastKode ? ((int) substr($lastKode, 3)) + 1 : 1;

        DB::table('jasa_servis')->insert([
            'kode_jasa' => 'JS_' . str_pad($next, 3, '0', STR_PAD_LEFT),
            'nama_jasa' => $request->nama_jasa,
            'harga' => $request->harga,
            'estimasi_menit' => $request->estimasi_menit,
            'deskripsi' => $request->deskripsi,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/jasa-servis');
    }

    //----- editJasaServis(): Menampilkan form edit jasa servis berdasarkan id
    public function editJasaServis($id)
    {
        if (!session('u')) return redirect('/');

        return view('edit_jasa_servis', [
            'row' => DB::table('jasa_servis')->where('id', $id)->first(),
        ]);
    }

    //----- updateJasaServis(): Memperbarui data jasa servis yang dipilih
    public function updateJasaServis(Request $request, $id)
    {
        if (!session('u')) return redirect('/');

        DB::table('jasa_servis')->where('id', $id)->update([
            'kode_jasa' => $request->kode_jasa,
            'nama_jasa' => $request->nama_jasa,
            'harga' => $request->harga,
            'estimasi_menit' => $request->estimasi_menit,
            'deskripsi' => $request->deskripsi,
            'updated_at' => now(),
        ]);
        return redirect('/jasa-servis');
    }

    //----- hapusJasaServis(): Menghapus jasa servis beserta relasi servis_jasa-nya
    public function hapusJasaServis($id)
    {
        if (!session('u')) return redirect('/');

        DB::table('servis_jasa')->where('jasa_servis_id', $id)->delete();
        DB::table('jasa_servis')->where('id', $id)->delete();
        return redirect('/jasa-servis');
    }

    //----- pdfJasaServis(): Mengunduh laporan data jasa servis dalam format PDF
    public function pdfJasaServis()
    {
        if (!session('u')) return redirect('/');

        $export = new JasaServisExport($this->jasaServisData());

        $this->pdfTable('Laporan Data Jasa Servis', 'laporan-jasa-servis', $export->headings(), $export->collection()->all());
    }

    //----- excelJasaServis(): Mengunduh laporan data jasa servis dalam format Excel (.xlsx)
    public function excelJasaServis()
    {
        if (!session('u')) return redirect('/');

        return Excel::download(
            new JasaServisExport($this->jasaServisData()),
            'laporan-jasa-servis-' . date('Y-m-d') . '.xlsx'
        );
    }
}
