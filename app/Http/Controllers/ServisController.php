<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\ServisExport;
use Maatwebsite\Excel\Facades\Excel;

//----- ServisController: menangani CRUD transaksi servis beserta export PDF/Excel
class ServisController extends Controller
{
    // ==================== SERVIS ====================

    //----- servis(): Menampilkan halaman daftar servis
    public function servis()
    {
        if (!session('u')) return redirect('/');

        return view('servis', ['rows' => $this->servisData()]);
    }

    //----- servisData(): Mengambil data servis lengkap dengan pelanggan, kendaraan, mekanik, daftar jasa, dan metode pembayaran (private)
    private function servisData()
    {
        $rows = DB::table('servis')
            ->join('kendaraan', 'servis.kendaraan_id', '=', 'kendaraan.id')
            ->join('pelanggan', 'kendaraan.pelanggan_id', '=', 'pelanggan.id')
            ->leftJoin('mekanik', 'servis.mekanik_id', '=', 'mekanik.id')
            ->select(
                'servis.id',
                'servis.no_servis',
                'servis.tanggal_masuk',
                'servis.keluhan',
                'servis.status',
                'pelanggan.nama as nama_pelanggan',
                'kendaraan.no_polisi',
                'mekanik.nama as nama_mekanik'
            )
            ->orderByDesc('servis.id')
            ->get();

        $jasaByServis = DB::table('servis_jasa')
            ->join('jasa_servis', 'servis_jasa.jasa_servis_id', '=', 'jasa_servis.id')
            ->select('servis_jasa.servis_id', 'jasa_servis.nama_jasa', 'servis_jasa.jumlah', 'servis_jasa.harga')
            ->get()
            ->groupBy('servis_id');

        $pembayaranByServis = DB::table('pembayaran')
            ->orderByDesc('id')
            ->get()
            ->unique('servis_id')
            ->keyBy('servis_id');

        foreach ($rows as $row) {
            $jasa = $jasaByServis->get($row->id, collect());
            $pembayaran = $pembayaranByServis->get($row->id);
            $rawMetode = $pembayaran->metode ?? null;

            $row->daftar_jasa = $jasa->isNotEmpty()
                ? $jasa->pluck('nama_jasa')->implode(', ')
                : '-';
            $row->total_jasa = $jasa->sum(function ($item) {
                return $item->jumlah * $item->harga;
            });
            $row->metode_pembayaran = $rawMetode
                ? (strtolower($rawMetode) === 'qris' ? 'QRIS' : ucfirst($rawMetode))
                : '-';
        }

        return $rows;
    }

    //----- tambahServis(): Menampilkan form tambah servis baru (beserta data pelanggan, kendaraan, mekanik, jasa)
    public function tambahServis()
    {
        if (!session('u')) return redirect('/');

        return view('input_servis', [
            'pelanggan' => DB::table('pelanggan')->orderBy('nama')->get(),
            'kendaraan' => DB::table('kendaraan')->orderBy('no_polisi')->get(),
            'mekanik' => DB::table('mekanik')->orderBy('nama')->get(),
            'jasa' => DB::table('jasa_servis')->orderBy('nama_jasa')->get(),
        ]);
    }

    //----- simpanServis(): Menyimpan servis baru, detail jasa yang dipilih, dan data pembayarannya
    public function simpanServis(Request $request)
    {
        if (!session('u')) return redirect('/');

        $user = DB::table('users')->where('nama', session('u'))->first();

        if (!$user) {
            return redirect('/login');
        }

        $nomorTerakhir = DB::table('servis')
            ->where('no_servis', 'like', 'SRV%')
            ->pluck('no_servis');

        $angkaTerbesar = 0;
        foreach ($nomorTerakhir as $nomor) {
            $angka = (int) preg_replace('/[^0-9]/', '', $nomor);
            if ($angka > $angkaTerbesar) {
                $angkaTerbesar = $angka;
            }
        }

        do {
            $angkaTerbesar++;
            $noServis = 'SRV' . str_pad($angkaTerbesar, 3, '0', STR_PAD_LEFT);
        } while (DB::table('servis')->where('no_servis', $noServis)->exists());

        $servisId = DB::table('servis')->insertGetId([
            'no_servis' => $noServis,
            'pelanggan_id' => $request->pelanggan_id,
            'kendaraan_id' => $request->kendaraan_id,
            'mekanik_id' => $request->mekanik_id ?: null,
            'user_id' => $user->id,
            'keluhan' => $request->keluhan,
            'status' => $request->status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $jumlahBayar = 0;

        foreach ($request->jasa_servis_id ?: [] as $jasaId) {
            $jasa = DB::table('jasa_servis')->where('id', $jasaId)->first();

            if ($jasa) {
                $jumlah = (int) ($request->jumlah_jasa[$jasaId] ?? 1);
                if ($jumlah < 1) {
                    $jumlah = 1;
                }

                DB::table('servis_jasa')->insert([
                    'servis_id' => $servisId,
                    'jasa_servis_id' => $jasa->id,
                    'jumlah' => $jumlah,
                    'harga' => $jasa->harga,
                ]);
                $jumlahBayar += $jasa->harga * $jumlah;
            }
        }

        DB::table('pembayaran')->insert([
            'no_pembayaran' => 'PAY-' . $servisId . '-' . time(),
            'servis_id' => $servisId,
            'user_id' => $user->id,
            'tanggal' => now(),
            'metode' => $request->metode_pembayaran ?: 'tunai',
            'jumlah_bayar' => $jumlahBayar,
            'created_at' => now(),
        ]);

        return redirect('/servis');
    }

    //----- editServis(): Menampilkan form edit servis beserta detail jasa dan pembayaran
    public function editServis($id)
    {
        if (!session('u')) return redirect('/');

        return view('edit_servis', [
            'row' => DB::table('servis')->where('id', $id)->first(),
            'pelanggan' => DB::table('pelanggan')->orderBy('nama')->get(),
            'kendaraan' => DB::table('kendaraan')->orderBy('no_polisi')->get(),
            'mekanik' => DB::table('mekanik')->orderBy('nama')->get(),
            'jasa' => DB::table('jasa_servis')->orderBy('nama_jasa')->get(),
            'detailJasa' => DB::table('servis_jasa')->where('servis_id', $id)->get(),
            'pembayaran' => DB::table('pembayaran')->where('servis_id', $id)->first(),
        ]);
    }

    //----- updateServis(): Memperbarui data servis, menghapus & menyisip ulang detail jasa, lalu update/insert pembayaran
    public function updateServis(Request $request, $id)
    {
        if (!session('u')) return redirect('/');

        DB::table('servis')->where('id', $id)->update([
            'no_servis' => $request->no_servis,
            'pelanggan_id' => $request->pelanggan_id,
            'kendaraan_id' => $request->kendaraan_id,
            'mekanik_id' => $request->mekanik_id,
            'keluhan' => $request->keluhan,
            'status' => $request->status,
            'catatan' => $request->catatan,
            'updated_at' => now(),
        ]);

        DB::table('servis_jasa')->where('servis_id', $id)->delete();

        $jumlahBayar = 0;

        foreach ($request->jasa_servis_id ?: [] as $jasaId) {
            $jasa = DB::table('jasa_servis')->where('id', $jasaId)->first();

            if ($jasa) {
                $jumlah = (int) ($request->jumlah_jasa[$jasaId] ?? 1);
                if ($jumlah < 1) {
                    $jumlah = 1;
                }
                $servisJasaId = DB::table('servis_jasa')->insertGetId([
                    'servis_id' => (int) $id,
                    'jasa_servis_id' => (int) $jasa->id,
                    'jumlah' => $jumlah,
                    'harga' => (float) $jasa->harga,
                ]);
                $jumlahBayar += $jasa->harga * $jumlah;
            }
        }

        if (DB::table('pembayaran')->where('servis_id', $id)->exists()) {
            DB::table('pembayaran')->where('servis_id', $id)->update([
                'metode' => $request->metode_pembayaran ?: 'tunai',
                'jumlah_bayar' => $jumlahBayar,
            ]);
        } else {
            $user = DB::table('users')->where('nama', session('u'))->first();

            if ($user) {
                DB::table('pembayaran')->insert([
                    'no_pembayaran' => 'PAY-' . $id . '-' . time(),
                    'servis_id' => $id,
                    'user_id' => $user->id,
                    'tanggal' => now(),
                    'metode' => $request->metode_pembayaran ?: 'tunai',
                    'jumlah_bayar' => $jumlahBayar,
                    'created_at' => now(),
                ]);
            }
        }

        return redirect('/servis');
    }

    //----- hapusServis(): Menghapus servis beserta relasi pembayaran dan servis_jasa-nya
    public function hapusServis($id)
    {
        if (!session('u')) return redirect('/');

        DB::table('pembayaran')->where('servis_id', $id)->delete();
        DB::table('servis_jasa')->where('servis_id', $id)->delete();
        DB::table('servis')->where('id', $id)->delete();
        return redirect('/servis');
    }

    //----- pdfServis(): Mengunduh laporan transaksi servis dalam format PDF
    public function pdfServis()
    {
        if (!session('u')) return redirect('/');

        $export = new ServisExport($this->servisData());

        $this->pdfTable('Laporan Transaksi Servis', 'laporan-servis', $export->headings(), $export->collection()->all());
    }

    //----- excelServis(): Mengunduh laporan transaksi servis dalam format Excel (.xlsx)
    public function excelServis()
    {
        if (!session('u')) return redirect('/');

        return Excel::download(
            new ServisExport($this->servisData()),
            'laporan-servis-' . date('Y-m-d') . '.xlsx'
        );
    }
}
