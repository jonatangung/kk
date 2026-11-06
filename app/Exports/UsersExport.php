<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    public function __construct(private Collection $users)
    {
    }

    public function collection(): Collection
    {
        return $this->users->values()->map(function (object $user, int $index): array {
            return [
                $index + 1,
                $user->nama_user ?? $user->nama,
                $user->email,
                $user->role ?? '-',
                $user->nama,
                $user->no_hp ?? '-',
                $user->spesialisasi ?? '-',
                $user->status ?? '-',
            ];
        });
    }

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
