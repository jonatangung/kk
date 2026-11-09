<?php

namespace App\Exports;

use Illuminate\Support\Collection; //----- Collection: class bawaan Laravel untuk mengelola data array/objek
use Maatwebsite\Excel\Concerns\FromCollection; //----- FromCollection: interface Laravel Excel — sumber data export adalah Collection
use Maatwebsite\Excel\Concerns\WithHeadings; //----- WithHeadings: interface Laravel Excel — menentukan baris judul (header) di Excel

//----- class PembayaranExport: menyiapkan data pembayaran untuk diekspor ke Excel
class PembayaranExport implements FromCollection, WithHeadings
{
    //----- __construct(): menerima data rows (hasil query pembayaran join servis)
    public function __construct(private iterable $rows)
    {
    }

    //----- collection(): mengubah data pembayaran menjadi baris-baris Excel
    //----- $row->daftar_jasa: string rincian jasa yang sudah disusun di controller (misal: "Ganti Oli (1x), Cuci (2x)")
    //----- number_format: format jumlah bayar menjadi Rupiah
    //----- ucfirst(): huruf pertama metode jadi kapital
    public function collection(): Collection
    {
        return collect($this->rows)->values()->map(function (object $row, int $index): array {
            return [
                $index + 1, //----- No urut
                $row->no_pembayaran, //----- Nomor pembayaran
                $row->no_servis ?? '-', //----- No servis (kosong -> '-')
                $row->keluhan ?? '-', //----- Keluhan (kosong -> '-')
                $row->daftar_jasa, //----- Rincian jasa yang dibayar
                $row->tanggal, //----- Tanggal pembayaran
                'Rp' . number_format($row->jumlah_bayar, 0, ',', '.'), //----- Jumlah bayar diformat Rupiah
                ucfirst($row->metode ?: '-'), //----- Metode bayar dengan huruf kapital
            ];
        });
    }

    //----- headings(): judul kolom yang tampil di baris pertama Excel
    public function headings(): array
    {
        return [
            'No',
            'No Pembayaran',
            'No Servis',
            'Keluhan',
            'Jasa Dipilih',
            'Tanggal',
            'Jumlah Bayar',
            'Metode',
        ];
    }
}
