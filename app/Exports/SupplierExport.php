<?php

namespace App\Exports;

use Illuminate\Support\Collection; //----- Collection: class bawaan Laravel untuk mengelola data array/objek
use Maatwebsite\Excel\Concerns\FromCollection; //----- FromCollection: interface Laravel Excel — menentukan sumber data export adalah Collection
use Maatwebsite\Excel\Concerns\WithHeadings; //----- WithHeadings: interface Laravel Excel — menentukan baris judul (header) di Excel

//----- class SupplierExport: menyiapkan data supplier/barang untuk diekspor ke file Excel
//----- implements FromCollection & WithHeadings: wajib diimplementasikan agar Laravel Excel tahu cara mengambil data & judul kolom
class SupplierExport implements FromCollection, WithHeadings
{
    //----- __construct(): constructor — menerima data rows (hasil query database) saat class ini dipanggil dari controller
    //----- private iterable $rows: property privat yang menyimpan data baris; hanya bisa diakses di dalam class ini
    public function __construct(private iterable $rows)
    {
    }

    //----- collection(): method wajib dari FromCollection — mengubah data database menjadi format baris Excel
    //----- collect($this->rows): mengubah data menjadi Laravel Collection agar bisa di-map
    //----- ->values(): mengurutkan ulang index agar mulai dari 0
    //----- ->map(function...): mengiterasi tiap baris data dan mengubahnya menjadi array sesuai urutan kolom
    //----- $index + 1: nomor urut otomatis (No) untuk tiap baris
    //----- number_format(..., 0, ',', '.'): memformat angka harga menjadi Rupiah (misal: Rp1.500.000)
    //----- ?: '-': jika data kosong/null, tampilkan tanda strip agar tidak kosong di Excel
    public function collection(): Collection
    {
        return collect($this->rows)->values()->map(function (object $row, int $index): array {
            return [
                $index + 1, //----- No urut
                $row->nama_supplier, //----- Nama Supplier / PT
                $row->nama_barang ?: '-', //----- Nama Barang (kosong -> '-')
                $row->stok, //----- Stok saat ini
                'Rp' . number_format($row->harga, 0, ',', '.'), //----- Harga diformat Rupiah
                $row->tanggal_masuk ?: '-', //----- Tanggal Masuk (kosong -> '-')
                $row->no_hp, //----- No HP supplier
            ];
        });
    }

    //----- headings(): method wajib dari WithHeadings — mengembalikan array judul kolom yang tampil di baris pertama Excel
    public function headings(): array
    {
        return [
            'No',
            'Nama Supplier / PT',
            'Nama Barang',
            'Stok',
            'Harga',
            'Tanggal Masuk',
            'No HP',
        ];
    }
}
