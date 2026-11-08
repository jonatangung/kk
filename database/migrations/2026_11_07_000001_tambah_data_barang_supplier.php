<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('supplier', function (Blueprint $table) {
            $table->string('nama_barang', 100)->nullable()->after('nama_supplier');
            $table->integer('stok')->default(0)->after('nama_barang');
            $table->decimal('harga', 15, 2)->default(0)->after('stok');
            $table->date('tanggal_masuk')->nullable()->after('harga');
        });

        Schema::create('stok_barang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id');
            $table->enum('jenis', ['masuk', 'keluar']);
            $table->integer('jumlah');
            $table->date('tanggal');
            $table->timestamps();

            $table->foreign('supplier_id')->references('id')->on('supplier')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stok_barang');

        Schema::table('supplier', function (Blueprint $table) {
            $table->dropColumn(['nama_barang', 'stok', 'harga', 'tanggal_masuk']);
        });
    }
};
