<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\LaporanServisExport;
use App\Exports\LaporanPendapatanExport;
use Maatwebsite\Excel\Facades\Excel;

//----- LaporanController: menangani laporan servis & pendapatan dengan filter tanggal dan export PDF/Excel
class LaporanController extends Controller
{
    //---------------------------- LAPORAN ----------------------------

    //----- laporanServis(): Menampilkan laporan servis dengan filter tanggal; mendukung export PDF/Excel via parameter export
    public function laporanServis(Request $request)
    {
        if (!session('u')) return redirect('/');

        $rows = $this->laporanServisData($request);

        if ($request->export && !in_array(session('role'), ['owner', 'admin'], true)) {
            return redirect('/laporan-servis');
        }

        if ($request->export === 'pdf') {
            return $this->downloadPdf('pdf.laporan-servis', 'Laporan_Servis', [
                'rows' => $rows,
                'from' => $request->from,
                'to' => $request->to,
            ]);
        }

        if ($request->export === 'excel') {
            return Excel::download(new LaporanServisExport($rows), 'Laporan_Servis.xlsx');
        }

        return view('laporan-servis', ['rows' => $rows]);
    }

    //----- laporanServisData(): Query data servis join kendaraan, pelanggan, mekanik dengan filter tanggal (private)
    private function laporanServisData(Request $request)
    {
        $query = DB::table('servis')
            ->join('kendaraan', 'servis.kendaraan_id', '=', 'kendaraan.id')
            ->join('pelanggan', 'kendaraan.pelanggan_id', '=', 'pelanggan.id')
            ->leftJoin('mekanik', 'servis.mekanik_id', '=', 'mekanik.id')
            ->select(
                'servis.no_servis',
                'pelanggan.nama as nama_pelanggan',
                'kendaraan.no_polisi',
                'mekanik.nama as nama_mekanik',
                'servis.tanggal_masuk',
                'servis.keluhan',
                'servis.status'
            );

        if ($request->from) {
            $query->whereDate('servis.tanggal_masuk', '>=', $request->from);
        }

        if ($request->to) {
            $query->whereDate('servis.tanggal_masuk', '<=', $request->to);
        }

        return $query->orderByDesc('servis.tanggal_masuk')->get();
    }

    //----- laporanPendapatan(): Menampilkan laporan pendapatan dengan filter tanggal; mendukung export PDF/Excel
    public function laporanPendapatan(Request $request)
    {
        if (!session('u')) return redirect('/');

        $data = $this->laporanPendapatanData($request);

        if ($request->export && !in_array(session('role'), ['owner', 'admin'], true)) {
            return redirect('/laporan-pendapatan');
        }

        if ($request->export === 'pdf') {
            return $this->downloadPdf('pdf.laporan-pendapatan', 'Laporan_Pendapatan', $data + [
                'from' => $request->from,
                'to' => $request->to,
            ]);
        }

        if ($request->export === 'excel') {
            return Excel::download(
                new LaporanPendapatanExport($data['rows'], $data['jasaByServis'], $data['totalPendapatan']),
                'Laporan_Pendapatan.xlsx'
            );
        }

        return view('laporan-pendapatan', $data);
    }

    //----- laporanPendapatanData(): Mengambil data pembayaran join servis, hitung total per jasa dan total pendapatan (private)
    private function laporanPendapatanData(Request $request)
    {
        $query = DB::table('pembayaran')
            ->leftJoin('servis', 'servis.id', '=', 'pembayaran.servis_id')
            ->select('pembayaran.*', 'servis.no_servis', 'servis.keluhan');

        if ($request->from) {
            $query->whereDate('pembayaran.tanggal', '>=', $request->from);
        }

        if ($request->to) {
            $query->whereDate('pembayaran.tanggal', '<=', $request->to);
        }

        $rows = $query->orderByDesc('pembayaran.tanggal')->get();

        $jasaByServis = $this->jasaByServis($rows->pluck('servis_id')->filter()->unique()->all());
        $totalPendapatan = 0;

        foreach ($rows as $row) {
            $jasaList = $jasaByServis->get($row->servis_id, collect());
            $row->total_jasa = $jasaList->isNotEmpty()
                ? $jasaList->sum(fn($jasa) => $jasa->jumlah * $jasa->harga)
                : $row->jumlah_bayar;
            $totalPendapatan += $row->total_jasa;
        }

        return [
            'rows' => $rows,
            'jasaByServis' => $jasaByServis,
            'totalPendapatan' => $totalPendapatan,
        ];
    }
}
