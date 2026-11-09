<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\StokBarangExport;
use Maatwebsite\Excel\Facades\Excel;

//----- StokBarangController: menangani rekap dan transaksi stok barang (masuk/keluar) beserta export PDF/Excel
class StokBarangController extends Controller
{
    // ==================== STOK BARANG ====================

    //----- stokBarang(): Menampilkan halaman rekap stok barang
    public function stokBarang(Request $request)
    {
        if (!session('u')) return redirect('/');

        return view('stok-barang', ['rows' => $this->stokBarangData()]);
    }

    //----- stokBarangData(): Query rekap total stok masuk/keluar per barang beserta tanggal terakhir (private)
    private function stokBarangData()
    {
        return DB::select("
            SELECT supplier.id, supplier.nama_supplier, supplier.nama_barang,
            supplier.harga, supplier.stok, supplier.harga_jual,
            COALESCE(SUM(CASE WHEN stok_barang.jenis = 'masuk' THEN stok_barang.jumlah ELSE 0 END), 0) AS stok_masuk,
            COALESCE(MAX(CASE WHEN stok_barang.jenis = 'masuk' THEN stok_barang.tanggal END), '-') AS tanggal_masuk,
            COALESCE(SUM(CASE WHEN stok_barang.jenis = 'keluar' THEN stok_barang.jumlah ELSE 0 END), 0) AS stok_keluar,
            COALESCE(MAX(CASE WHEN stok_barang.jenis = 'keluar' THEN stok_barang.tanggal END), '-') AS tanggal_keluar
            FROM supplier
            LEFT JOIN stok_barang ON stok_barang.supplier_id = supplier.id
            GROUP BY supplier.id, supplier.nama_supplier, supplier.nama_barang,
            supplier.harga, supplier.stok, supplier.harga_jual
            ORDER BY supplier.id
        ");
    }

    //----- inputStokBarang(): Menampilkan form input stok dengan filter supplier/barang
    public function inputStokBarang(Request $request)
    {
        if (!session('u')) return redirect('/');

        $barang = collect();
        if ($request->supplier_nama) {
            $barang = DB::table('supplier')
                ->where('nama_supplier', $request->supplier_nama)
                ->get();
        }

        $selectedBarang = null;
        if ($request->supplier_id) {
            $selectedBarang = DB::table('supplier')
                ->where('id', $request->supplier_id)
                ->first();
        }

        return view('input_stok_barang', [
            'supplierData' => DB::table('supplier')->get(),
            'supplierNama' => $request->supplier_nama,
            'barang' => $barang,
            'selectedBarang' => $selectedBarang,
        ]);
    }

    //----- stokMasuk(): Mencatat transaksi stok masuk dan memperbarui tanggal_masuk supplier
    public function stokMasuk(Request $request)
    {
        if (!session('u')) return redirect('/');

        if (!$request->supplier_id || (int) $request->jumlah < 1) {
            return redirect('/stok-barang');
        }

        DB::table('stok_barang')->insert([
            'supplier_id' => $request->supplier_id,
            'jenis' => 'masuk',
            'jumlah' => $request->jumlah,
            'tanggal' => $request->tanggal,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('supplier')->where('id', $request->supplier_id)->update([
            'tanggal_masuk' => $request->tanggal ?: now()->toDateString(),
            'updated_at' => now(),
        ]);

        return redirect('/stok-barang');
    }

    //----- stokKeluar(): Mencatat transaksi stok keluar dan memperbarui harga_jual barang
    public function stokKeluar(Request $request, $id)
    {
        if (!session('u')) return redirect('/');

        $supplier = DB::table('supplier')->where('id', $id)->first();
        $jumlah = (int) $request->jumlah;

        if ($supplier && $jumlah > 0) {
            DB::table('supplier')->where('id', $id)->update([
                'harga_jual' => $request->harga_jual ?: 0,
                'updated_at' => now(),
            ]);

            DB::table('stok_barang')->insert([
                'supplier_id' => $id,
                'jenis' => 'keluar',
                'jumlah' => $jumlah,
                'tanggal' => $request->tanggal ?: now()->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect('/stok-barang');
    }

    //----- pdfStokBarang(): Mengunduh laporan stok barang dalam format PDF
    public function pdfStokBarang()
    {
        if (!session('u')) return redirect('/');

        $export = new StokBarangExport($this->stokBarangData());

        $this->pdfTable('Laporan Stok Barang', 'laporan-stok-barang', $export->headings(), $export->collection()->all());
    }

    //----- excelStokBarang(): Mengunduh laporan stok barang dalam format Excel (.xlsx)
    public function excelStokBarang()
    {
        if (!session('u')) return redirect('/');

        return Excel::download(
            new StokBarangExport($this->stokBarangData()),
            'laporan-stok-barang-' . date('Y-m-d') . '.xlsx'
        );
    }
}
