<?php

namespace App\Models;

//----- Model User: class untuk tabel 'users' (pengguna sistem: admin, mekanik, dll)
//----- extends Authenticatable (bukan Model biasa) karena dipakai untuk autentikasi/login Laravel
//----- Tidak wajib dipakai di project ini karena login di controller pakai DB::table + session manual

// use Illuminate\Contracts\Auth\MustVerifyEmail; //----- interface opsional: aktifkan jika ingin verifikasi email wajib
use Illuminate\Database\Eloquent\Factories\HasFactory; //----- HasFactory: trait untuk factory (testing)
use Illuminate\Foundation\Auth\User as Authenticatable; //----- class induk user Laravel yang sudah punya fitur auth
use Illuminate\Notifications\Notifiable; //----- Notifiable: trait untuk mengirim notifikasi (email/notif) ke user
use Laravel\Sanctum\HasApiTokens; //----- HasApiTokens: trait untuk API token (login via API)

class User extends Authenticatable
{
    //----- trait yang dipakai class ini:
    //----- HasApiTokens = bisa membuat token API, HasFactory = bisa pakai factory testing, Notifiable = bisa kirim notifikasi
    use HasApiTokens, HasFactory, Notifiable;

    // 1. Kunci koneksi ke nama tabel 'users' di database Anda
    protected $table = 'users'; //----- Eloquent default mencari tabel 'users' — ini konfirmasi eksplisit

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // 2. Ubah 'name' menjadi 'nama' agar sesuai dengan kolom tabel database Anda
    //----- $fillable = daftar kolom yang BOLEH diisi massal (misal: User::create([...]))
    //----- Kolom di luar daftar ini tidak bisa diisi sekaligus (proteksi mass assignment)
    protected $fillable = [
        'nama', //----- nama lengkap user (kolom DB bernama 'nama', bukan 'name')
        'email', //----- email login
        'password', //----- password (otomatis di-hash karena cast 'hashed' di bawah)
        'role', //----- role user: admin / mekanik / dll
        'no_hp', //----- nomor HP
        'foto', //----- nama file foto profil
        'is_active', //----- status aktif (1=aktif, 0=nonaktif)
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    //----- $hidden = kolom yang TIDAK ditampilkan saat data user diubah jadi JSON/array
    //----- Tujuannya: password & remember_token tidak boleh bocor ke response API/view
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    //----- $casts = aturan konversi tipe data otomatis:
    //----- 'email_verified_at' => 'datetime': ubah string tanggal jadi object Carbon (mudah format/manipulasi)
    //----- 'password' => 'hashed': password yang diisi akan OTOMATIS di-hash (bcrypt) sebelum disimpan
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
