<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

//----- SettingController: menangani halaman pengaturan identitas usaha
//----- Hanya bisa diakses role admin (dicek lewat middleware 'level:admin' di route)
class SettingController extends Controller
{
    //----- index(): Menampilkan form setting yang sudah terisi data saat ini
    public function index()
    {
        //----- Ambil baris setting pertama; kalau belum ada, buat object kosong
        $setting = Setting::first();
        if ($setting === null) {
            $setting = new Setting();
        }

        return view('setting', ['setting' => $setting]);
    }

    //----- update(): Menyimpan perubahan setting (teks + file logo/ikon)
    public function update(Request $request)
    {
        //----- Validasi input: nama wajib, logo & ikon opsional hanya gambar maks 2 MB
        $validated = $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'nama_owner' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'logo' => 'nullable|mimes:jpg,jpeg,png,ico,svg,webp|max:2048',
            'ikon' => 'nullable|mimes:jpg,jpeg,png,ico,svg,webp|max:2048',
        ]);

        //----- Ambil baris setting; kalau belum ada, buat baru
        $setting = Setting::first();
        if ($setting === null) {
            $setting = new Setting();
        }

        $setting->nama_usaha = $validated['nama_usaha'];
        $setting->nama_owner = $validated['nama_owner'];
        $setting->alamat = $validated['alamat'];

        //----- Folder penyimpanan file logo & ikon
        $folder = public_path('uploads/setting');
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        //----- Simpan file logo baru kalau diupload, lalu hapus file lama
        if ($request->hasFile('logo')) {
            $namaFile = time() . '_' . bin2hex(random_bytes(4)) . '_' . $request->file('logo')->getClientOriginalName();
            $request->file('logo')->move($folder, $namaFile);

            if ($setting->logo && file_exists($folder . '/' . $setting->logo)) {
                unlink($folder . '/' . $setting->logo);
            }

            $setting->logo = $namaFile;
        }

        //----- Simpan file ikon baru kalau diupload, lalu hapus file lama
        if ($request->hasFile('ikon')) {
            $namaFile = time() . '_' . bin2hex(random_bytes(4)) . '_' . $request->file('ikon')->getClientOriginalName();
            $request->file('ikon')->move($folder, $namaFile);

            if ($setting->ikon && file_exists($folder . '/' . $setting->ikon)) {
                unlink($folder . '/' . $setting->ikon);
            }

            $setting->ikon = $namaFile;
        }

        $setting->save();

        return redirect('/setting')->with('sukses', 'Data setting berhasil disimpan.');
    }
}
