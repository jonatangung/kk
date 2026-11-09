<?php

namespace App\Exports;

use Illuminate\Support\Collection; //----- Collection: class bawaan Laravel untuk mengelola data array/objek
use Maatwebsite\Excel\Concerns\FromCollection; //----- FromCollection: interface Laravel Excel — sumber data export adalah Collection
use Maatwebsite\Excel\Concerns\WithHeadings; //----- WithHeadings: interface Laravel Excel — menentukan baris judul (header) di Excel

//----- class UsersExport: menyiapkan data gabungan user + mekanik (hasil join1) untuk diekspor ke Excel
//----- Dipakai untuk laporan gabungan pengguna sistem dan data mekanik
class UsersExport implements FromCollection, WithHeadings
{
    //----- __construct(): menerima data users (hasil join users + mekanik dari model database)
    public function __construct(private Collection $users)
    {
    }

    //----- collection(): mengubah data user+mekanik menjadi baris-baris Excel
    //----- $user->nama_user ?? $user->nama: pakai nama dari tabel users jika ada (hasil join), fallback ke nama asli
    //----- $user->role ?? '-': role user, kosong -> '-'
    //----- $user->nama: nama mekanik (dari tabel mekanik)
    //----- ?? '-': semua properti opsional ditampilkan '-' jika null
    public function collection(): Collection
    {
        return $this->users->values()->map(function (object $user, int $index): array {
            return [
                $index + 1, //----- No urut
                $user->nama_user ?? $user->nama, //----- Nama (user hasil join / fallback nama asli)
                $user->email, //----- Email
                $user->role ?? '-', //----- Level/role (kosong -> '-')
                $user->nama, //----- Nama Mekanik
                $user->no_hp ?? '-', //----- No HP (kosong -> '-')
                $user->spesialisasi ?? '-', //----- Spesialisasi (kosong -> '-')
                $user->status ?? '-', //----- Status (kosong -> '-')
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
            'Level',
            'Nama Mekanik',
            'No HP',
            'Spesialisasi',
            'Status',
        ];
    }
}
