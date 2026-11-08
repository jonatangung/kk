<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servis extends Model
{
    protected $table = 'servis';
    public $timestamps = false;
    protected $guarded = [];

    // Relasi ke detail jasa (1 servis memiliki banyak jasa)
    public function servisJasa()
    {
        return $this->hasMany(ServisJasa::class, 'servis_id');
    }
}
