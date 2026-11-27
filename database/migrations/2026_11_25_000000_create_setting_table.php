<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //----- Tabel setting: hanya berisi 1 baris untuk identitas usaha (nama, owner, alamat, logo, ikon)
        Schema::create('setting', function (Blueprint $table) {
            $table->id();
            $table->string('nama_usaha'); //----- nama toko/usaha, tampil di header
            $table->string('nama_owner'); //----- nama pemilik, tampil kecil di bawah nama usaha
            $table->text('alamat')->nullable(); //----- alamat toko, tampil di header
            $table->string('logo')->nullable(); //----- nama file logo di public/uploads/setting
            $table->string('ikon')->nullable(); //----- nama file favicon di public/uploads/setting
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting');
    }
};
