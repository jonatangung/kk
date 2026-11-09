<?php

namespace App\Exports;

use Illuminate\Support\Collection; //----- Collection: class bawaan Laravel untuk mengelola data array/objek
use Maatwebsite\Excel\Concerns\FromCollection; //----- FromCollection: interface Laravel Excel — sumber data export adalah Collection
use Maatwebsite\Excel\Concerns\WithHeadings; //----- WithHeadings: interface Laravel Excel — menentukan baris judul (header) di Excel

//----- class LaporanServisExport: menyiapkan data laporan servis untuk diekspor ke Excel
class LaporanServisExport implements FromCollection, WithHeadings
{
    //----- __construct(): menerima data rows (hasil query join servis+pelanggan+kendaraan+mekanik)
    public function __construct(private Collection $rows)
    {
    }

    //----- collection(): mengubah data laporan menjadi baris-baris Excel
    //----- ?: '-': data null/kosong ditampilkan sebagai strip
    //----- ucfirst(): huruf pertama jadi kapital (misal: "selesai" -> "Selesai")
    public function collection(): Collection
    {
        return $this->rows->values()->map(function (object $row, int $index): array {
            return [
                $index + 1, //----- No urut
                $row->no_servis, //----- Nomor servis
                $row->nama_pelanggan, //----- Nama pelanggan
                $row->no_polisi, //----- No polisi kendaraan
                $row->nama_mekanik ?: '-', //----- Nama mekanik (kosong -> '-')
                $row->tanggal_masuk, //----- Tanggal servis masuk
                $row->keluhan ?: '-', //----- Keluhan pelanggan (kosong -> '-')
                ucfirst($row->status ?: '-'), //----- Status dengan huruf kapital
            ];
        });
    }

    //----- headings(): judul kolom yang tampil di baris pertama Excel
    public function headings(): array
    {
        return [
            'No',
            'No Servis',
            'Pelanggan',
            'No Polisi',
            'Mekanik',
            'Tanggal Masuk',
            'Keluhan',
            'Status',
        ];
    }
}
