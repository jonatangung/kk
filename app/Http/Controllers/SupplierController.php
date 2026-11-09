<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\SupplierExport;
use Maatwebsite\Excel\Facades\Excel;

//----- SupplierController: menangani CRUD data supplier/barang beserta export PDF/Excel
class SupplierController extends Controller
{
    // ==================== SUPPLIER ====================

    //----- supplier(): Menampilkan halaman daftar supplier/barang
    public function supplier()
    {
        if (!session('u')) return redirect('/');

        return view('supplier', ['rows' => $this->supplierData()]);
    }

    //----- supplierData(): Mengambil seluruh data supplier/barang dari database (private)
    private function supplierData()
    {
        return DB::table('supplier')->get();
    }

    //----- tambahSupplier(): Menampilkan form tambah supplier/barang baru
    public function tambahSupplier()
    {
        if (!session('u')) return redirect('/');

        return view('input_supplier');
    }

    //----- simpanSupplier(): Menyimpan supplier baru beserta catatan stok masuk awal jika ada
    public function simpanSupplier(Request $request)
    {
        if (!session('u')) return redirect('/');

        $supplierId = DB::table('supplier')->insertGetId([
            'nama_supplier' => $request->nama_supplier,
            'nama_barang' => $request->nama_barang,
            'stok' => 0,
            'harga' => $request->harga ?: 0,
            'tanggal_masuk' => $request->tanggal_masuk ?: now()->toDateString(),
            'kontak_person' => $request->kontak_person,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ((int) $request->stok > 0) {
            DB::table('stok_barang')->insert([
                'supplier_id' => $supplierId,
                'jenis' => 'masuk',
                'jumlah' => $request->stok,
                'tanggal' => $request->tanggal_masuk ?: now()->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect('/supplier');
    }

    //----- editSupplier(): Menampilkan form edit supplier/barang berdasarkan id
    public function editSupplier($id)
    {
        if (!session('u')) return redirect('/');

        return view('edit_supplier', [
            'row' => DB::table('supplier')->where('id', $id)->first(),
        ]);
    }

    //----- updateSupplier(): Memperbarui data supplier dan mencatat selisih stok (masuk/keluar)
    public function updateSupplier(Request $request, $id)
    {
        if (!session('u')) return redirect('/');

        $supplier = DB::table('supplier')->where('id', $id)->first();
        $stokLama = (int) $supplier->stok;
        $stokBaru = (int) $request->stok;

        DB::table('supplier')->where('id', $id)->update([
            'nama_supplier' => $request->nama_supplier,
            'nama_barang' => $request->nama_barang,
            'harga' => $request->harga ?: 0,
            'tanggal_masuk' => $request->tanggal_masuk,
            'kontak_person' => $request->kontak_person,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'updated_at' => now(),
        ]);

        if ($stokBaru > $stokLama) {
            DB::table('stok_barang')->insert([
                'supplier_id' => $id,
                'jenis' => 'masuk',
                'jumlah' => $stokBaru - $stokLama,
                'tanggal' => $request->tanggal_masuk ?: now()->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } elseif ($stokBaru < $stokLama) {
            DB::table('stok_barang')->insert([
                'supplier_id' => $id,
                'jenis' => 'keluar',
                'jumlah' => $stokLama - $stokBaru,
                'tanggal' => now()->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect('/supplier');
    }

    //----- hapusSupplier(): Menghapus data supplier/barang berdasarkan id
    public function hapusSupplier($id)
    {
        if (!session('u')) return redirect('/');

        DB::table('supplier')->where('id', $id)->delete();
        return redirect('/supplier');
    }

    //----- pdfSupplier(): Mengunduh laporan data supplier dalam format PDF
    public function pdfSupplier()
    {
        if (!session('u')) return redirect('/');

        $export = new SupplierExport($this->supplierData());

        $this->pdfTable('Laporan Data Supplier', 'laporan-supplier', $export->headings(), $export->collection()->all());
    }

    //----- excelSupplier(): Mengunduh laporan data supplier dalam format Excel (.xlsx)
    public function excelSupplier()
    {
        if (!session('u')) return redirect('/');

        return Excel::download(
            new SupplierExport($this->supplierData()),
            'laporan-supplier-' . date('Y-m-d') . '.xlsx'
        );
    }
}
