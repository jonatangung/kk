<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_supplier_tambah_stok');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_supplier_ubah_stok');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_stok_barang_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_stok_barang_delete');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_stok_barang_update');
    }

    public function down(): void {}
};
