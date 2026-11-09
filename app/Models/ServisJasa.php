<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; //----- Model: class induk Eloquent ORM bawaan Laravel

//----- class ServisJasa: model untuk tabel 'servis_jasa' (detail jasa dalam satu servis)
//----- Ini tabel relasi/pivot: menghubungkan servis dengan jasa_servis beserta jumlah & harga
class ServisJasa extends Model
{
    protected $table = 'servis_jasa'; //----- nama tabel di database yang diwakili model ini
    public $timestamps = false; //----- matikan created_at/updated_at otomatis
    protected $guarded = []; //----- izinkan mass assignment ke semua kolom

    //----- servis(): relasi belongsTo — kebalikan dari hasMany di Servis
    //----- Artinya: banyak baris servis_jasa "milik" SATU servis
    //----- Foreign key 'servis_id' menunjuk ke tabel servis
    public function servis()
    {
        return $this->belongsTo(Servis::class, 'servis_id');
    }
}
