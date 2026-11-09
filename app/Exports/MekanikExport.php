<?php

namespace App\Exports;

use Illuminate\Support\Collection; //----- Collection: class bawaan Laravel untuk mengelola data array/objek
use Maatwebsite\Excel\Concerns\FromCollection; //----- FromCollection: interface Laravel Excel — sumber data export adalah Collection
use Maatwebsite\Excel\Concerns\WithHeadings; //----- WithHeadings: interface Laravel Excel — menentukan baris judul (header) di Excel

//----- class MekanikExport: menyiapkan data mekanik untuk diekspor ke Excel
class MekanikExport implements FromCollection, WithHeadings
{
    //----- __construct(): menerima data rows (hasil query database) saat class dipanggil dari controller
    public function __construct(private iterable $rows)
    {
    }

    //----- collection(): mengubah data database menjadi baris-baris Excel
    //----- collect()->values()->map(): iterasi tiap baris dan susun sesuai urutan kolom
    //----- ucfirst(): huruf pertama status jadi kapital (misal: "aktif" -> "Aktif")
    public function collection(): Collection
    {
        return collect($this->rows)->values()->map(function (object $row, int $index): array {
            return [
                $index + 1, //----- No urut
                $row->nama, //----- Nama mekanik
                $row->no_hp, //----- No HP
                $row->spesialisasi, //----- Spesialisasi keahlian
                ucfirst($row->status ?: '-'), //----- Status dengan huruf kapital
            ];
        });
    }

    //----- headings(): judul kolom yang tampil di baris pertama Excel
    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'No HP',
            'Spesialisasi',
            'Status',
        ];
    }
}
