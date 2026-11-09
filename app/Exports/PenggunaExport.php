<?php

namespace App\Exports;

use Illuminate\Support\Collection; //----- Collection: class bawaan Laravel untuk mengelola data array/objek
use Maatwebsite\Excel\Concerns\FromCollection; //----- FromCollection: interface Laravel Excel — sumber data export adalah Collection
use Maatwebsite\Excel\Concerns\WithHeadings; //----- WithHeadings: interface Laravel Excel — menentukan baris judul (header) di Excel

//----- class PenggunaExport: menyiapkan data pengguna/pengguna sistem untuk diekspor ke Excel
class PenggunaExport implements FromCollection, WithHeadings
{
    //----- __construct(): menerima data rows (hasil query users) saat class dipanggil dari controller
    public function __construct(private iterable $rows)
    {
    }

    //----- collection(): mengubah data pengguna menjadi baris-baris Excel
    //----- is_active ? 'Aktif' : 'Tidak Aktif': ubah angka 1/0 menjadi teks status
    public function collection(): Collection
    {
        return collect($this->rows)->values()->map(function (object $row, int $index): array {
            return [
                $index + 1, //----- No urut
                $row->nama, //----- Nama pengguna
                $row->email, //----- Email
                $row->role, //----- Role (admin/mekanik/dll)
                $row->no_hp, //----- No HP
                $row->foto ?: '-', //----- Nama file foto (kosong -> '-')
                $row->is_active ? 'Aktif' : 'Tidak Aktif', //----- Status aktif/tidak
                $row->created_at, //----- Tanggal bergabung
            ];
        });
    }

    //----- headings(): judul kolom yang tampil di baris pertama Excel
    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'Email',
            'Role',
            'No HP',
            'Foto',
            'Status',
            'Tanggal Bergabung',
        ];
    }
}
