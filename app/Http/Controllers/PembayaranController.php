<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\PembayaranExport;
use Maatwebsite\Excel\Facades\Excel;

//----- PembayaranController: menangani edit/hapus pembayaran beserta export PDF/Excel
class PembayaranController extends Controller
{
    // ==================== PEMBAYARAN ====================

    //----- pembayaran(): Menampilkan halaman daftar pembayaran
    public function pembayaran()
    {
        if (!session('u')) return redirect('/');

        return view('pembayaran', $this->pembayaranData());
    }

    //----- pembayaranData(): Mengambil data pembayaran join dengan servis beserta rincian jasa dan total bayar (private)
    private function pembayaranData()
    {
        $rows = DB::table('pembayaran')
            ->leftJoin('servis', 'servis.id', '=', 'pembayaran.servis_id')
            ->select('pembayaran.*', 'servis.no_servis', 'servis.keluhan')
            ->orderBy('pembayaran.id', 'desc')
            ->get();

        $jasaByServis = $this->jasaByServis($rows->pluck('servis_id')->filter()->unique()->all());

        foreach ($rows as $row) {
            $jasaList = $jasaByServis->get($row->servis_id, collect());
            $row->jumlah_bayar = $jasaList->isNotEmpty()
                ? $jasaList->sum(fn($jasa) => $jasa->jumlah * $jasa->harga)
                : $row->jumlah_bayar;
            $row->daftar_jasa = $jasaList->isNotEmpty()
                ? $jasaList->map(fn($jasa) => $jasa->nama_jasa . ' (' . $jasa->jumlah . 'x)')->implode(', ')
                : '-';
        }

        return [
            'rows' => $rows,
            'jasaByServis' => $jasaByServis,
        ];
    }

    //----- editPembayaran(): Menampilkan form edit pembayaran beserta detail jasa servisnya
    public function editPembayaran($id)
    {
        if (!session('u')) return redirect('/');

        $row = DB::table('pembayaran')->where('id', $id)->first();

        return view('edit_pembayaran', [
            'row' => $row,
            'servis' => DB::table('servis')->orderBy('no_servis')->get(),
            'detailJasa' => $this->jasaByServis([$row->servis_id])->get($row->servis_id, collect()),
        ]);
    }

    //----- updatePembayaran(): Memperbarui data pembayaran dan menghitung ulang jumlah bayar dari jasa
    public function updatePembayaran(Request $request, $id)
    {
        if (!session('u')) return redirect('/');

        $jasa = $this->jasaByServis([$request->servis_id])->get($request->servis_id, collect());
        $jumlahBayar = $jasa->isNotEmpty()
            ? $jasa->sum(fn($item) => $item->jumlah * $item->harga)
            : $request->jumlah_bayar;

        DB::table('pembayaran')->where('id', $id)->update([
            'no_pembayaran' => $request->no_pembayaran,
            'servis_id' => $request->servis_id,
            'tanggal' => $request->tanggal,
            'metode' => $request->metode,
            'jumlah_bayar' => $jumlahBayar,
            'no_referensi' => $request->no_referensi,
            'catatan' => $request->catatan,
        ]);
        return redirect('/pembayaran');
    }

    //----- hapusPembayaran(): Menghapus data pembayaran berdasarkan id
    public function hapusPembayaran($id)
    {
        if (!session('u')) return redirect('/');

        DB::table('pembayaran')->where('id', $id)->delete();
        return redirect('/pembayaran');
    }

    //----- pdfPembayaran(): Mengunduh laporan pembayaran dalam format PDF
    public function pdfPembayaran()
    {
        if (!session('u')) return redirect('/');

        $export = new PembayaranExport($this->pembayaranData()['rows']);

        $this->pdfTable('Laporan Pembayaran', 'laporan-pembayaran', $export->headings(), $export->collection()->all());
    }

    //----- excelPembayaran(): Mengunduh laporan pembayaran dalam format Excel (.xlsx)
    public function excelPembayaran()
    {
        if (!session('u')) return redirect('/');

        return Excel::download(
            new PembayaranExport($this->pembayaranData()['rows']),
            'laporan-pembayaran-' . date('Y-m-d') . '.xlsx'
        );
    }
}
