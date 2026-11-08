<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_stok_barang_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_stok_barang_delete');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_stok_barang_update');

        DB::unprepared("
            CREATE TRIGGER trg_stok_barang_insert
            AFTER INSERT ON stok_barang
            FOR EACH ROW
            BEGIN
                IF NEW.jenis = 'masuk' THEN
                    UPDATE supplier SET stok = stok + NEW.jumlah WHERE id = NEW.supplier_id;
                ELSE
                    UPDATE supplier SET stok = stok - NEW.jumlah WHERE id = NEW.supplier_id;
                END IF;
            END
        ");

        DB::unprepared("
            CREATE TRIGGER trg_stok_barang_delete
            AFTER DELETE ON stok_barang
            FOR EACH ROW
            BEGIN
                IF OLD.jenis = 'masuk' THEN
                    UPDATE supplier SET stok = stok - OLD.jumlah WHERE id = OLD.supplier_id;
                ELSE
                    UPDATE supplier SET stok = stok + OLD.jumlah WHERE id = OLD.supplier_id;
                END IF;
            END
        ");

        DB::unprepared("
            CREATE TRIGGER trg_stok_barang_update
            AFTER UPDATE ON stok_barang
            FOR EACH ROW
            BEGIN
                IF OLD.jenis = 'masuk' THEN
                    UPDATE supplier SET stok = stok - OLD.jumlah WHERE id = OLD.supplier_id;
                ELSE
                    UPDATE supplier SET stok = stok + OLD.jumlah WHERE id = OLD.supplier_id;
                END IF;

                IF NEW.jenis = 'masuk' THEN
                    UPDATE supplier SET stok = stok + NEW.jumlah WHERE id = NEW.supplier_id;
                ELSE
                    UPDATE supplier SET stok = stok - NEW.jumlah WHERE id = NEW.supplier_id;
                END IF;
            END
        ");
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_stok_barang_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_stok_barang_delete');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_stok_barang_update');
    }
};
