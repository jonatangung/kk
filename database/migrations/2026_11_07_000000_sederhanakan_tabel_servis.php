<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('servis', function (Blueprint $table) {
            $table->dropColumn([
                'tanggal_selesai',
                'kilometer',
                'diagnosa',
                'total_jasa',
                'total_sparepart',
                'diskon',
                'total_bayar',
                'status_bayar',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('servis', function (Blueprint $table) {
            $table->dateTime('tanggal_selesai')->nullable()->after('tanggal_masuk');
            $table->unsignedInteger('kilometer')->nullable()->after('tanggal_selesai');
            $table->text('diagnosa')->nullable()->after('keluhan');
            $table->decimal('total_jasa', 15, 2)->default(0)->after('status');
            $table->decimal('total_sparepart', 15, 2)->default(0)->after('total_jasa');
            $table->decimal('diskon', 15, 2)->default(0)->after('total_sparepart');
            $table->decimal('total_bayar', 15, 2)->default(0)->after('diskon');
            $table->enum('status_bayar', ['belum', 'sebagian', 'lunas'])->default('belum')->after('total_bayar');
        });
    }
};
