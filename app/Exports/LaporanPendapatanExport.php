<?php

namespace App\Exports;

use Illuminate\Support\Collection; //----- Collection: class bawaan Laravel untuk mengelola data array/objek
use Maatwebsite\Excel\Concerns\FromCollection; //----- FromCollection: interface Laravel Excel — sumber data export adalah Collection
use Maatwebsite\Excel\Concerns\WithHeadings; //----- WithHeadings: interface Laravel Excel — menentukan baris judul (header) di Excel

//----- class LaporanPendapatanExport: menyiapkan data laporan pendapatan untuk diekspor ke Excel
class LaporanPendapatanExport implements FromCollection, WithHeadings
{
    //----- __construct(): menerima 3 data:
    //----- $rows = daftar pembayaran, $jasaByServis = detail jasa per servis (sudah dikelompokkan), $totalPendapatan = total keseluruhan
    public function __construct(
        private Collection $rows,
        private Collection $jasaByServis,
        private float $totalPendapatan
    ) {
    }

    //----- collection(): mengubah data pembayaran menjadi baris-baris Excel
    //----- $jasaByServis->get($row->servis_id): mengambil daftar jasa milik servis tsb berdasarkan servis_id
    //----- ->map(fn...): ubah tiap jasa menjadi teks "Nama Jasa (2x) - Rp100.000"
    //----- ->implode(', '): gabung semua jasa jadi satu string dipisah koma
    //----- $data->push([...]): menambahkan 1 baris tambahan di bawah berisi TOTAL PENDAPATAN keseluruhan
    public function collection(): Collection
    {
        $data = $this->rows->values()->map(function (object $row, int $index): array {
            $jasaList = $this->jasaByServis->get($row->servis_id, collect());
            $jasa = '-';

            if ($jasaList->isNotEmpty()) {
                $jasa = $jasaList
                    ->map(fn ($item) => $item->nama_jasa . ' (' . $item->jumlah . 'x) - Rp'
                        . number_format($item->jumlah * $item->harga, 0, ',', '.'))
                    ->implode(', ');
            }

            return [
                $index + 1, //----- No urut
                $row->no_pembayaran, //----- Nomor pembayaran
                $row->no_servis ?? '-', //----- No servis (kosong -> '-')
                $jasa, //----- Rincian jasa yang dibayar
                $row->tanggal, //----- Tanggal pembayaran
                'Rp' . number_format($row->total_jasa, 0, ',', '.'), //----- Total bayar diformat Rupiah
                ucfirst($row->metode), //----- Metode bayar dengan huruf kapital
            ];
        });

        //----- Tambah baris TOTAL di paling bawah tabel
        $data->push([
            '',
            '',
            '',
            '',
            'Total Pendapatan',
            'Rp' . number_format($this->totalPendapatan, 0, ',', '.'),
            '',
        ]);

        return $data;
    }

    //----- headings(): judul kolom yang tampil di baris pertama Excel
    public function headings(): array
    {
        return [
            'No',
            'No Pembayaran',
            'No Servis',
            'Jasa Dipilih',
            'Tanggal',
            'Jumlah Bayar',
            'Metode',
        ];
    }
}
