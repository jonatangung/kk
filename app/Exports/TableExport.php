<?php

namespace App\Exports;

use Illuminate\Support\Collection; //----- Collection: class bawaan Laravel untuk mengelola data array/objek
use Maatwebsite\Excel\Concerns\FromCollection; //----- FromCollection: interface Laravel Excel — sumber data export adalah Collection
use Maatwebsite\Excel\Concerns\WithHeadings; //----- WithHeadings: interface Laravel Excel — menentukan baris judul (header) di Excel

//----- class TableExport: export generik yang dipakai bersama untuk PDF tabel (bukan file Excel langsung)
//----- Dipakai oleh helper pdfTable() di controller untuk mengambil headings & rows apa adanya
class TableExport implements FromCollection, WithHeadings
{
    //----- __construct(): menerima array judul kolom ($headings) dan array data baris ($rows) dari controller
    public function __construct(
        private array $headings,
        private array $rows
    ) {
    }

    //----- collection(): mengembalikan data baris apa adanya (sudah berbentuk array dari controller)
    public function collection(): Collection
    {
        return collect($this->rows)->values();
    }

    //----- headings(): mengembalikan judul kolom yang dikirim dari controller
    public function headings(): array
    {
        return $this->headings;
    }
}
