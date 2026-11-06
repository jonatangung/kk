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
        $query = DB::table('mekanik')
            ->leftJoin('users', 'mekanik.user_id', '=', 'users.id')
            ->select(
                'mekanik.*',
                'users.nama as nama_user',
                'users.email',
                'users.role'
            );

        if ($from) {
            $query->whereDate('mekanik.created_at', '>=', $from);
        }

        if ($to) {
            $query->whereDate('mekanik.created_at', '<=', $to);
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