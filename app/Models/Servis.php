<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; //----- Model: class induk Eloquent ORM bawaan Laravel

//----- class Servis: model untuk tabel 'servis' (header transaksi servis di bengkel)
//----- Satu baris = satu servis/kendaraan yang masuk bengkel
class Servis extends Model
{
    protected $table = 'servis'; //----- nama tabel di database yang diwakili model ini
    public $timestamps = false; //----- matikan created_at/updated_at otomatis (kolom diatur manual)
    protected $guarded = []; //----- izinkan mass assignment ke semua kolom (tanpa proteksi $fillable)

    //----- servisJasa(): relasi hasMany — 1 servis bisa punya BANYAK jasa (misal: ganti oli + cuci + kampas rem)
    //----- Foreign key 'servis_id' ada di tabel servis_jasa yang menunjuk balik ke tabel ini
    //----- Hasilnya bisa diakses via $servis->servisJasa (lazy loading)
    public function servisJasa()
    {
        return $this->hasMany(ServisJasa::class, 'servis_id');
    }
}
