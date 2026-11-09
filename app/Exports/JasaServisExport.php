<?php

namespace App\Exports;

use Illuminate\Support\Collection; //----- Collection: class bawaan Laravel untuk mengelola data array/objek
use Maatwebsite\Excel\Concerns\FromCollection; //----- FromCollection: interface Laravel Excel — sumber data export adalah Collection
use Maatwebsite\Excel\Concerns\WithHeadings; //----- WithHeadings: interface Laravel Excel — menentukan baris judul (header) di Excel

//----- class JasaServisExport: menyiapkan data jasa servis untuk diekspor ke Excel
class JasaServisExport implements FromCollection, WithHeadings
{
    //----- __construct(): menerima data rows (hasil query database) saat class dipanggil dari controller
    public function __construct(private iterable $rows)
    {
    }

    //----- collection(): mengubah data database menjadi baris-baris Excel
    //----- collect()->values()->map(): iterasi tiap baris dan susun sesuai urutan kolom
    //----- number_format: format harga menjadi Rupiah (misal: Rp50.000)
    //----- is_active ? 'Aktif' : 'Tidak Aktif': ubah angka 1/0 menjadi teks status
    public function collection(): Collection
    {
        return collect($this->rows)->values()->map(function (object $row, int $index): array {
            return [
                $index + 1, //----- No urut
                $row->kode_jasa, //----- Kode Jasa (misal: JS_001)
                $row->nama_jasa, //----- Nama Jasa
                'Rp' . number_format($row->harga, 0, ',', '.'), //----- Harga diformat Rupiah
                $row->estimasi_menit, //----- Estimasi pengerjaan (menit)
                $row->is_active ? 'Aktif' : 'Tidak Aktif', //----- Status aktif/tidak
            ];
        });
    }

    //----- headings(): judul kolom yang tampil di baris pertama Excel
    public function headings(): array
    {
        return [
            'No',
            'Kode Jasa',
            'Nama Jasa',
            'Harga',
            'Estimasi Menit',
            'Status',
        ];
    }
}
