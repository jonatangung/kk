<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServisJasa extends Model
{
    protected $table = 'servis_jasa';
    public $timestamps = false;
    protected $guarded = [];

    // Relasi balik ke header servis
    public function servis()
    {
        return $this->belongsTo(Servis::class, 'servis_id');
    }
}
