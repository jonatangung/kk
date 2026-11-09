<?php

namespace App\Models;

//----- Model database: class helper generik untuk operasi CRUD ke tabel mana pun
//----- Tidak terikat ke satu tabel — nama tabel dikirim sebagai parameter ($table)
//----- Dibuat untuk mempermudah query tanpa menulis Eloquent/DB facade berulang kali

use Illuminate\Database\Eloquent\Factories\HasFactory; //----- HasFactory: trait untuk factory (testing)
use Illuminate\Database\Eloquent\Model; //----- Model: class induk Eloquent ORM bawaan Laravel
use Illuminate\Support\Facades\DB; //----- DB: facade untuk query builder Laravel

//----- class database: kumpulan method helper query database
class database extends Model
{

    //----- tampil(): mengambil SEMUA data dari tabel tertentu
    //----- DB::table($table)->get(): query builder — select * dari tabel lalu ambil semua baris
    public function tampil($table)
    {
        return DB::table($table)
        ->get();
    }

    //----- tampilTanggal(): mengambil data tabel dengan filter rentang tanggal berdasarkan kolom created_at
    //----- $from = tanggal mulai, $to = tanggal akhir (dari form filter)
    //----- whereDate(): filter hanya berdasarkan bagian tanggal (abaikan jam)
    //----- >= dan <= : inklusif — data di tanggal from dan to ikut diambil
    public function tampilTanggal($table, $from, $to)
    {
        $query = DB::table($table);

        if ($from) {
            $query->whereDate('created_at', '>=', $from); //----- filter tanggal mulai
        }

        if ($to) {
            $query->whereDate('created_at', '<=', $to); //----- filter tanggal akhir
        }

        return $query->get();
    }

    //----- join1(): query gabungan (JOIN) tabel mekanik dengan users
    //----- leftJoin: gabungkan users lewat kolom user_id — tetap ambil mekanik walau user-nya tidak ada
    //----- select 'mekanik.*': ambil semua kolom mekanik + kolom tambahan dari users (nama_user, email, role)
    //----- 'users.nama as nama_user': rename kolom nama agar tidak bentrok dengan nama di tabel mekanik
    //----- Filter tanggal opsional berdasarkan created_at tabel mekanik
    public function join1($from = null, $to = null)
    {
        $query = DB::table('mekanik')
            ->leftJoin('users', 'mekanik.user_id', '=', 'users.id')
            ->select(
                'mekanik.*',
                'users.nama as nama_user',
                'users.email',
                'users.role'
            );

        if ($from) {
            $query->whereDate('mekanik.created_at', '>=', $from); //----- filter tanggal mulai
        }

        if ($to) {
            $query->whereDate('mekanik.created_at', '<=', $to); //----- filter tanggal akhir
        }

        return $query->get();
    }


    //----- tambah(): INSERT data baru ke tabel
    //----- $data = array associative berisi kolom => nilai yang akan disimpan
    //----- return insert(): mengembalikan true/false apakah insert berhasil
    public function tambah($table, $data)
    {
        return DB::table($table)->insert($data);
    }

    //----- ubah(): UPDATE data pada tabel
    //----- $where = kondisi pencarian (misal: ['id' => 5]) untuk menentukan baris mana yang diubah
    //----- $data = array kolom => nilai baru
    public function ubah($table, $where, $data)
    {
        return DB::table($table)->where($where)->update($data);
    }

    //----- hapus(): DELETE data dari tabel berdasarkan kondisi $where
    public function hapus($table, $where)
    {
        return DB::table($table)->where($where)->delete();
    }

    //----- tarik(): SELECT satu baris data pertama yang cocok dengan kondisi $where
    //----- first(): ambil hanya 1 record (bukan semua)
    public function tarik($table, $where)
    {
        return DB::table($table)->where($where)->first();
    }
}
