<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class database extends Model
{

    public function tampil($table)
    {
        return DB::table($table)
        ->get();
    }

    public function tampilTanggal($table, $from, $to)
    {
        $query = DB::table($table);

        if ($from) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to) {
            $query->whereDate('created_at', '<=', $to);
        }

        return $query->get();
    }

    public function join1($from = null, $to = null)
    {
        $query = DB::table('user')
            ->leftJoin('karyawan', 'user.id_user', '=', 'karyawan.id_user')
            ->leftJoin('jabatan', 'karyawan.id_jabatan', '=', 'jabatan.id_jabatan')
            ->leftJoin('agama', 'karyawan.id_agama', '=', 'agama.id_agama')
            ->select(
                'user.*',
                'karyawan.id_karyawan',
                'karyawan.nama_kry',
                'karyawan.alamat_kry',
                'karyawan.jk_kry',
                'karyawan.id_jabatan',
                'karyawan.id_agama',
                'jabatan.nama_jabatan',
                'agama.nama_agama'
            );

        if ($from) {
            $query->whereDate('user.created_at', '>=', $from);
        }

        if ($to) {
            $query->whereDate('user.created_at', '<=', $to);
        }

        return $query->get();
    }


    public function tambah($table, $data)
    {
        return DB::table($table)->insert($data);
    }

    public function ubah($table, $where, $data)
    {
        return DB::table($table)->where($where)->update($data);
    }

    public function hapus($table, $where)
    {
        return DB::table($table)->where($where)->delete();
    }

    public function tarik($table, $where)
    {
        return DB::table($table)->where($where)->first();
    }
}