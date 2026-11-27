<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; //----- Model: class induk Eloquent ORM bawaan Laravel

//----- class Setting: model untuk tabel 'setting' (identitas usaha bengkel)
//----- Tabel ini hanya berisi 1 baris data yang diubah lewat halaman Setting
class Setting extends Model
{
    protected $table = 'setting'; //----- nama tabel di database yang diwakili model ini

    //----- kolom yang boleh diisi massal dari form Setting
    protected $fillable = ['nama_usaha', 'nama_owner', 'alamat', 'logo', 'ikon'];
}
