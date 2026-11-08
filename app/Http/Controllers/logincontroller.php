<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\database;

class logincontroller extends Controller
{
    // ==================== LOGIN DAN DASHBOARD ====================

    public function index(){
        return view ('/login');
    }

    public function aksilogin(Request $Request){
        $username= $Request->input('u');
        $password= $Request->input('p');
        $hasilcek = DB::table('users')
            ->where(function ($query) use ($username) {
                $query->where('nama', $username)
                    ->orWhere('email', $username);
            })
            ->where('is_active', 1)
            ->first();

        $passwordValid = $hasilcek && $hasilcek->password === $password;

        if($passwordValid){
            session(['u'=>$hasilcek->nama]);
            return redirect('/home');
        }
        else{
            return redirect('/');
        }
    }

    public function logout(){
        session()->flush();
        return redirect('/');
    }

   public function register()
   {
       return view('girasya');
   }

   public function simpanRegister(Request $request)
   {
       DB::table('users')->insert([
           'nama' => $request->u,
           'email' => $request->e,
           'password' => $request->p,
           'role' => 'admin',
           'no_hp' => null,
           'foto' => $this->simpanFoto($request->file('foto')),
           'is_active' => 1,
           'created_at' => now(),
           'updated_at' => now(),
       ]);

       return redirect('/login');
   }

   public function home(Request $Request){
        if (session('u')){
            return view('home', [
                'pelanggan' => DB::table('pelanggan')->count(),
                'kendaraan' => DB::table('kendaraan')->count(),
                'mekanik' => DB::table('mekanik')->count(),
                'servis' => DB::table('servis')->count(),
            ]);
        }
        else{
            return redirect('/');
        };
    }




    // ==================== PELANGGAN ====================

    public function pelanggan(Request $request)
    {
        $data['pelanggan'] = (new database)->tampilTanggal('pelanggan', $request->from, $request->to);

        return view('pelanggan', $data);
    }

    public function tplg()
    {
        $data['user'] = (new database)->tampil('users');

        return view('input_pelanggan', $data);
    }

    public function aksi_tplg(Request $request)
    {
        (new database)->tambah('pelanggan', [
            'kode_pelanggan' => 'PLG-' . now()->format('ymdHis'),
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
        ]);

        return redirect('/pelanggan');
    }

    public function editPelanggan($id)
    {
        return view('edit_pelanggan', [
            'row' => DB::table('pelanggan')->where('id', $id)->first(),
        ]);
    }

    public function updatePelanggan(Request $request, $id)
    {
        DB::table('pelanggan')->where('id', $id)->update([
            'kode_pelanggan' => $request->kode_pelanggan,
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'updated_at' => now(),
        ]);
        return redirect('/pelanggan');
    }

    public function hapusPelanggan($id)
    {
        DB::table('pelanggan')->where('id', $id)->delete();
        return redirect('/pelanggan');
    }

    // ==================== MEKANIK ====================

    public function tkry()
    {
        return view('input_mekanik');
    }

    public function aksi_tkry(Request $request)
    {
        $user = (new database)->tarik('users', ['nama' => session('u')]);

        if (!$user) {
            return redirect('/tkry');
        }

        $data = [
            'user_id' => $user->id,
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'spesialisasi' => $request->spesialisasi,
            'status' => 'aktif',
        ];

        DB::table('mekanik')->insert($data);

        return redirect('/mekanik');
    }

    public function karyawan()
    {
        $data['karyawan'] = DB::table('mekanik')->get();

        return view('mekanik', $data);
    }

    public function editMekanik($id)
    {
        return view('edit_mekanik', [
            'row' => DB::table('mekanik')->where('id', $id)->first(),
        ]);
    }

    public function updateMekanik(Request $request, $id)
    {
        DB::table('mekanik')->where('id', $id)->update([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'spesialisasi' => $request->spesialisasi,
            'status' => $request->status,
            'updated_at' => now(),
        ]);
        return redirect('/mekanik');
    }

    public function hapusMekanik($id)
    {
        DB::table('mekanik')->where('id', $id)->delete();
        return redirect('/mekanik');
    }

    // ==================== KENDARAAN ====================

    public function kendaraan()
    {
        return view('kendaraan', ['rows' => DB::table('kendaraan')->get()]);
    }

    public function tambahKendaraan()
    {
        return view('input_kendaraan', [
            'pelanggan' => DB::table('pelanggan')
                ->select('id', 'nama', 'kode_pelanggan')
                ->orderBy('nama')
                ->get(),
        ]);
    }

    public function simpanKendaraan(Request $request)
    {
        DB::table('kendaraan')->insert([
            'pelanggan_id' => $request->pelanggan_id,
            'no_polisi' => $request->no_polisi,
            'merk' => $request->merk,
            'model' => $request->model,
            'tahun' => $request->tahun,
            'warna' => $request->warna,
            'no_rangka' => $request->no_rangka,
            'no_mesin' => $request->no_mesin,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/kendaraan');
    }

    public function editKendaraan($id)
    {
        return view('edit_kendaraan', [
            'row' => DB::table('kendaraan')->where('id', $id)->first(),
            'pelanggan' => DB::table('pelanggan')->orderBy('nama')->get(),
        ]);
    }

    public function updateKendaraan(Request $request, $id)
    {
        DB::table('kendaraan')->where('id', $id)->update([
            'pelanggan_id' => $request->pelanggan_id,
            'no_polisi' => $request->no_polisi,
            'merk' => $request->merk,
            'model' => $request->model,
            'tahun' => $request->tahun,
            'warna' => $request->warna,
            'no_rangka' => $request->no_rangka,
            'no_mesin' => $request->no_mesin,
            'updated_at' => now(),
        ]);
        return redirect('/kendaraan');
    }

    public function hapusKendaraan($id)
    {
        DB::table('kendaraan')->where('id', $id)->delete();
        return redirect('/kendaraan');
    }

    // ==================== JASA SERVIS ====================

    public function jasaServis()
    {
        return view('jasa-servis', ['rows' => DB::table('jasa_servis')->get()]);
    }

    public function tambahJasaServis()
    {
        return view('input_jasa_servis');
    }

    public function simpanJasaServis(Request $request)
    {
        $lastKode = DB::table('jasa_servis')
            ->where('kode_jasa', 'like', 'JS_%')
            ->orderByDesc('kode_jasa')
            ->value('kode_jasa');

        $next = $lastKode ? ((int) substr($lastKode, 3)) + 1 : 1;

        DB::table('jasa_servis')->insert([
            'kode_jasa' => 'JS_' . str_pad($next, 3, '0', STR_PAD_LEFT),
            'nama_jasa' => $request->nama_jasa,
            'harga' => $request->harga,
            'estimasi_menit' => $request->estimasi_menit,
            'deskripsi' => $request->deskripsi,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/jasa-servis');
    }

    public function editJasaServis($id)
    {
        return view('edit_jasa_servis', [
            'row' => DB::table('jasa_servis')->where('id', $id)->first(),
        ]);
    }

    public function updateJasaServis(Request $request, $id)
    {
        DB::table('jasa_servis')->where('id', $id)->update([
            'kode_jasa' => $request->kode_jasa,
            'nama_jasa' => $request->nama_jasa,
            'harga' => $request->harga,
            'estimasi_menit' => $request->estimasi_menit,
            'deskripsi' => $request->deskripsi,
            'updated_at' => now(),
        ]);
        return redirect('/jasa-servis');
    }

    public function hapusJasaServis($id)
    {
        DB::table('servis_jasa')->where('jasa_servis_id', $id)->delete();
        DB::table('jasa_servis')->where('id', $id)->delete();
        return redirect('/jasa-servis');
    }

    // ==================== SUPPLIER ====================

    public function supplier()
    {
        return view('supplier', ['rows' => DB::table('supplier')->get()]);
    }

    public function tambahSupplier()
    {
        return view('input_supplier');
    }

    public function simpanSupplier(Request $request)
    {
        $supplierId = DB::table('supplier')->insertGetId([
            'nama_supplier' => $request->nama_supplier,
            'nama_barang' => $request->nama_barang,
            'stok' => 0,
            'harga' => $request->harga ?: 0,
            'tanggal_masuk' => $request->tanggal_masuk ?: now()->toDateString(),
            'kontak_person' => $request->kontak_person,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ((int) $request->stok > 0) {
            DB::table('stok_barang')->insert([
                'supplier_id' => $supplierId,
                'jenis' => 'masuk',
                'jumlah' => $request->stok,
                'tanggal' => $request->tanggal_masuk ?: now()->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect('/supplier');
    }

    public function editSupplier($id)
    {
        return view('edit_supplier', [
            'row' => DB::table('supplier')->where('id', $id)->first(),
        ]);
    }

    public function updateSupplier(Request $request, $id)
    {
        $supplier = DB::table('supplier')->where('id', $id)->first();
        $stokLama = (int) $supplier->stok;
        $stokBaru = (int) $request->stok;

        DB::table('supplier')->where('id', $id)->update([
            'nama_supplier' => $request->nama_supplier,
            'nama_barang' => $request->nama_barang,
            'harga' => $request->harga ?: 0,
            'tanggal_masuk' => $request->tanggal_masuk,
            'kontak_person' => $request->kontak_person,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'updated_at' => now(),
        ]);

        if ($stokBaru > $stokLama) {
            DB::table('stok_barang')->insert([
                'supplier_id' => $id,
                'jenis' => 'masuk',
                'jumlah' => $stokBaru - $stokLama,
                'tanggal' => $request->tanggal_masuk ?: now()->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } elseif ($stokBaru < $stokLama) {
            DB::table('stok_barang')->insert([
                'supplier_id' => $id,
                'jenis' => 'keluar',
                'jumlah' => $stokLama - $stokBaru,
                'tanggal' => now()->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect('/supplier');
    }

    public function stokBarang(Request $request)
    {
        return view('stok-barang', [
            'rows' => DB::select("
                SELECT supplier.id, supplier.nama_supplier, supplier.nama_barang,
                supplier.harga, supplier.stok, supplier.harga_jual,
                COALESCE(SUM(CASE WHEN stok_barang.jenis = 'masuk' THEN stok_barang.jumlah ELSE 0 END), 0) AS stok_masuk,
                COALESCE(MAX(CASE WHEN stok_barang.jenis = 'masuk' THEN stok_barang.tanggal END), '-') AS tanggal_masuk,
                COALESCE(SUM(CASE WHEN stok_barang.jenis = 'keluar' THEN stok_barang.jumlah ELSE 0 END), 0) AS stok_keluar,
                COALESCE(MAX(CASE WHEN stok_barang.jenis = 'keluar' THEN stok_barang.tanggal END), '-') AS tanggal_keluar
                FROM supplier
                LEFT JOIN stok_barang ON stok_barang.supplier_id = supplier.id
                GROUP BY supplier.id, supplier.nama_supplier, supplier.nama_barang,
                supplier.harga, supplier.stok, supplier.harga_jual
                ORDER BY supplier.id
            "),
        ]);
    }

    public function inputStokBarang(Request $request)
    {
        $barang = collect();
        if ($request->supplier_nama) {
            $barang = DB::table('supplier')
                ->where('nama_supplier', $request->supplier_nama)
                ->get();
        }

        $selectedBarang = null;
        if ($request->supplier_id) {
            $selectedBarang = DB::table('supplier')
                ->where('id', $request->supplier_id)
                ->first();
        }

        return view('input_stok_barang', [
            'supplierData' => DB::table('supplier')->get(),
            'supplierNama' => $request->supplier_nama,
            'barang' => $barang,
            'selectedBarang' => $selectedBarang,
        ]);
    }

    public function stokMasuk(Request $request)
    {
        if (!$request->supplier_id || (int) $request->jumlah < 1) {
            return redirect('/stok-barang');
        }

        DB::table('stok_barang')->insert([
            'supplier_id' => $request->supplier_id,
            'jenis' => 'masuk',
            'jumlah' => $request->jumlah,
            'tanggal' => $request->tanggal,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('supplier')->where('id', $request->supplier_id)->update([
            'tanggal_masuk' => $request->tanggal ?: now()->toDateString(),
            'updated_at' => now(),
        ]);

        return redirect('/stok-barang');
    }

    public function stokKeluar(Request $request, $id)
    {
        $supplier = DB::table('supplier')->where('id', $id)->first();
        $jumlah = (int) $request->jumlah;

        if ($supplier && $jumlah > 0) {
            DB::table('supplier')->where('id', $id)->update([
                'harga_jual' => $request->harga_jual ?: 0,
                'updated_at' => now(),
            ]);

            DB::table('stok_barang')->insert([
                'supplier_id' => $id,
                'jenis' => 'keluar',
                'jumlah' => $jumlah,
                'tanggal' => $request->tanggal ?: now()->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect('/stok-barang');
    }

    public function hapusSupplier($id)
    {
        DB::table('supplier')->where('id', $id)->delete();
        return redirect('/supplier');
    }

    // ==================== SERVIS ====================

    public function servis()
    {
        $rows = DB::table('servis')
            ->join('kendaraan', 'servis.kendaraan_id', '=', 'kendaraan.id')
            ->join('pelanggan', 'kendaraan.pelanggan_id', '=', 'pelanggan.id')
            ->leftJoin('mekanik', 'servis.mekanik_id', '=', 'mekanik.id')
            ->select(
                'servis.id',
                'servis.tanggal_masuk',
                'servis.status',
                'pelanggan.nama as nama_pelanggan',
                'kendaraan.no_polisi',
                'mekanik.nama as nama_mekanik'
            )
            ->orderByDesc('servis.id')
            ->get();

        $jasaByServis = DB::table('servis_jasa')
            ->join('jasa_servis', 'servis_jasa.jasa_servis_id', '=', 'jasa_servis.id')
            ->select('servis_jasa.servis_id', 'jasa_servis.nama_jasa', 'servis_jasa.jumlah', 'servis_jasa.harga')
            ->get()
            ->groupBy('servis_id');

        $pembayaranByServis = DB::table('pembayaran')
            ->orderByDesc('id')
            ->get()
            ->unique('servis_id')
            ->keyBy('servis_id');

        foreach ($rows as $row) {
            $jasa = $jasaByServis->get($row->id, collect());
            $pembayaran = $pembayaranByServis->get($row->id);
            $rawMetode = $pembayaran->metode ?? null;

            $row->daftar_jasa = $jasa->isNotEmpty()
                ? $jasa->pluck('nama_jasa')->implode(', ')
                : '-';
            $row->total_jasa = $jasa->sum(function ($item) {
                return $item->jumlah * $item->harga;
            });
            $row->metode_pembayaran = $rawMetode
                ? (strtolower($rawMetode) === 'qris' ? 'QRIS' : ucfirst($rawMetode))
                : '-';
        }

        return view('servis', ['rows' => $rows]);
    }

    public function tambahServis()
    {
        return view('input_servis', [
            'pelanggan' => DB::table('pelanggan')->orderBy('nama')->get(),
            'kendaraan' => DB::table('kendaraan')->orderBy('no_polisi')->get(),
            'mekanik' => DB::table('mekanik')->orderBy('nama')->get(),
            'jasa' => DB::table('jasa_servis')->orderBy('nama_jasa')->get(),
        ]);
    }

    public function simpanServis(Request $request)
    {
        $user = DB::table('users')->where('nama', session('u'))->first();

        if (!$user) {
            return redirect('/login');
        }

        $nomorTerakhir = DB::table('servis')
            ->where('no_servis', 'like', 'SRV%')
            ->pluck('no_servis');

        $angkaTerbesar = 0;
        foreach ($nomorTerakhir as $nomor) {
            $angka = (int) preg_replace('/[^0-9]/', '', $nomor);
            if ($angka > $angkaTerbesar) {
                $angkaTerbesar = $angka;
            }
        }

        do {
            $angkaTerbesar++;
            $noServis = 'SRV' . str_pad($angkaTerbesar, 3, '0', STR_PAD_LEFT);
        } while (DB::table('servis')->where('no_servis', $noServis)->exists());

        $servisId = DB::table('servis')->insertGetId([
            'no_servis' => $noServis,
            'pelanggan_id' => $request->pelanggan_id,
            'kendaraan_id' => $request->kendaraan_id,
            'mekanik_id' => $request->mekanik_id ?: null,
            'user_id' => $user->id,
            'keluhan' => $request->keluhan,
            'status' => $request->status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $jumlahBayar = 0;

        foreach ($request->jasa_servis_id ?: [] as $jasaId) {
            $jasa = DB::table('jasa_servis')->where('id', $jasaId)->first();

            if ($jasa) {
                $jumlah = (int) ($request->jumlah_jasa[$jasaId] ?? 1);
                if ($jumlah < 1) {
                    $jumlah = 1;
                }

                DB::table('servis_jasa')->insert([
                    'servis_id' => $servisId,
                    'jasa_servis_id' => $jasa->id,
                    'jumlah' => $jumlah,
                    'harga' => $jasa->harga,
                ]);
                $jumlahBayar += $jasa->harga * $jumlah;
            }
        }

        DB::table('pembayaran')->insert([
            'no_pembayaran' => 'PAY-' . $servisId . '-' . time(),
            'servis_id' => $servisId,
            'user_id' => $user->id,
            'tanggal' => now(),
            'metode' => $request->metode_pembayaran ?: 'tunai',
            'jumlah_bayar' => $jumlahBayar,
            'created_at' => now(),
        ]);

        return redirect('/servis');
    }

    public function editServis($id)
    {
        return view('edit_servis', [
            'row' => DB::table('servis')->where('id', $id)->first(),
            'pelanggan' => DB::table('pelanggan')->orderBy('nama')->get(),
            'kendaraan' => DB::table('kendaraan')->orderBy('no_polisi')->get(),
            'mekanik' => DB::table('mekanik')->orderBy('nama')->get(),
            'jasa' => DB::table('jasa_servis')->orderBy('nama_jasa')->get(),
            'detailJasa' => DB::table('servis_jasa')->where('servis_id', $id)->get(),
            'pembayaran' => DB::table('pembayaran')->where('servis_id', $id)->first(),
        ]);
    }

    public function updateServis(Request $request, $id)
    {
        DB::table('servis')->where('id', $id)->update([
            'no_servis' => $request->no_servis,
            'pelanggan_id' => $request->pelanggan_id,
            'kendaraan_id' => $request->kendaraan_id,
            'mekanik_id' => $request->mekanik_id,
            'keluhan' => $request->keluhan,
            'status' => $request->status,
            'catatan' => $request->catatan,
            'updated_at' => now(),
        ]);

        DB::table('servis_jasa')->where('servis_id', $id)->delete();

        $jumlahBayar = 0;

        foreach ($request->jasa_servis_id ?: [] as $jasaId) {
            $jasa = DB::table('jasa_servis')->where('id', $jasaId)->first();

            if ($jasa) {
                $jumlah = (int) ($request->jumlah_jasa[$jasaId] ?? 1);
                if ($jumlah < 1) {
                    $jumlah = 1;
                }
                $servisJasaId = DB::table('servis_jasa')->insertGetId([
                    'servis_id' => (int) $id,
                    'jasa_servis_id' => (int) $jasa->id,
                    'jumlah' => $jumlah,
                    'harga' => (float) $jasa->harga,
                ]);
                $jumlahBayar += $jasa->harga * $jumlah;
            }
        }

        if (DB::table('pembayaran')->where('servis_id', $id)->exists()) {
            DB::table('pembayaran')->where('servis_id', $id)->update([
                'metode' => $request->metode_pembayaran ?: 'tunai',
                'jumlah_bayar' => $jumlahBayar,
            ]);
        } else {
            $user = DB::table('users')->where('nama', session('u'))->first();

            if ($user) {
                DB::table('pembayaran')->insert([
                    'no_pembayaran' => 'PAY-' . $id . '-' . time(),
                    'servis_id' => $id,
                    'user_id' => $user->id,
                    'tanggal' => now(),
                    'metode' => $request->metode_pembayaran ?: 'tunai',
                    'jumlah_bayar' => $jumlahBayar,
                    'created_at' => now(),
                ]);
            }
        }

        return redirect('/servis');
    }

    public function hapusServis($id)
    {
        DB::table('pembayaran')->where('servis_id', $id)->delete();
        DB::table('servis_jasa')->where('servis_id', $id)->delete();
        DB::table('servis')->where('id', $id)->delete();
        return redirect('/servis');
    }

    // ==================== PEMBAYARAN ====================

    public function pembayaran()
    {
        $rows = DB::table('pembayaran')
            ->leftJoin('servis', 'servis.id', '=', 'pembayaran.servis_id')
            ->select('pembayaran.*', 'servis.no_servis', 'servis.keluhan')
            ->orderBy('pembayaran.id', 'desc')
            ->get();

        $jasaByServis = $this->jasaByServis($rows->pluck('servis_id')->filter()->unique()->all());

        foreach ($rows as $row) {
            $jasaList = $jasaByServis->get($row->servis_id, collect());
            $row->jumlah_bayar = $jasaList->isNotEmpty()
                ? $jasaList->sum(fn($jasa) => $jasa->jumlah * $jasa->harga)
                : $row->jumlah_bayar;
        }

        return view('pembayaran', [
            'rows' => $rows,
            'jasaByServis' => $jasaByServis,
        ]);
    }

    private function jasaByServis(array $servisIds)
    {
        if (empty($servisIds)) {
            return collect();
        }

        return DB::table('servis_jasa')
            ->join('jasa_servis', 'servis_jasa.jasa_servis_id', '=', 'jasa_servis.id')
            ->whereIn('servis_jasa.servis_id', $servisIds)
            ->select(
                'servis_jasa.servis_id',
                'jasa_servis.nama_jasa',
                'servis_jasa.jumlah',
                'servis_jasa.harga'
            )
            ->get()
            ->groupBy('servis_id');
    }

    public function editPembayaran($id)
    {
        $row = DB::table('pembayaran')->where('id', $id)->first();

        return view('edit_pembayaran', [
            'row' => $row,
            'servis' => DB::table('servis')->orderBy('no_servis')->get(),
            'detailJasa' => $this->jasaByServis([$row->servis_id])->get($row->servis_id, collect()),
        ]);
    }

    public function updatePembayaran(Request $request, $id)
    {
        $jasa = $this->jasaByServis([$request->servis_id])->get($request->servis_id, collect());
        $jumlahBayar = $jasa->isNotEmpty()
            ? $jasa->sum(fn($item) => $item->jumlah * $item->harga)
            : $request->jumlah_bayar;

        DB::table('pembayaran')->where('id', $id)->update([
            'no_pembayaran' => $request->no_pembayaran,
            'servis_id' => $request->servis_id,
            'tanggal' => $request->tanggal,
            'metode' => $request->metode,
            'jumlah_bayar' => $jumlahBayar,
            'no_referensi' => $request->no_referensi,
            'catatan' => $request->catatan,
        ]);
        return redirect('/pembayaran');
    }

    public function hapusPembayaran($id)
    {
        DB::table('pembayaran')->where('id', $id)->delete();
        return redirect('/pembayaran');
    }

    // ==================== PENGGUNA ====================

    public function pengguna()
    {
        return view('pengguna', [
            'rows' => DB::table('users')
                ->select('id', 'nama', 'email', 'role', 'no_hp', 'foto', 'is_active', 'created_at')
                ->get(),
        ]);
    }

    public function tambahPengguna()
    {
        return view('input_pengguna');
    }

    public function simpanPengguna(Request $request)
    {
        DB::table('users')->insert([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role,
            'no_hp' => $request->no_hp,
            'foto' => $this->simpanFoto($request->file('foto')),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/pengguna');
    }

    public function editPengguna($id)
    {
        return view('edit_pengguna', [
            'row' => DB::table('users')->where('id', $id)->first(),
        ]);
    }

    public function updatePengguna(Request $request, $id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
            'no_hp' => $request->no_hp,
            'updated_at' => now(),
        ];

        if ($request->hasFile('foto')) {
            if ($user && $user->foto) {
                $this->hapusFoto($user->foto);
            }
            $data['foto'] = $this->simpanFoto($request->file('foto'));
        }

        DB::table('users')->where('id', $id)->update($data);
        return redirect('/pengguna');
    }

    public function hapusPengguna($id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        if ($user && $user->foto) {
            $this->hapusFoto($user->foto);
        }
        DB::table('users')->where('id', $id)->delete();
        return redirect('/pengguna');
    }

    private function simpanFoto($file)
    {
        if (!$file) {
            return null;
        }

        $folder = public_path('uploads/users');
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $namaFile = uniqid('foto_') . '.' . $file->getClientOriginalExtension();
        $file->move($folder, $namaFile);

        return $namaFile;
    }

    private function hapusFoto($namaFile)
    {
        $path = public_path('uploads/users/' . $namaFile);
        if (file_exists($path)) {
            unlink($path);
        }
    }
    //----------------------------LAPORAN----------------------------

    public function laporanServis(Request $request)
    {
        $rows = $this->laporanServisData($request);
        $table = $this->laporanServisTableHtml($rows);

        if ($request->export === 'pdf') {
            return $this->downloadPdf('Laporan Servis', 'Laporan_Servis', $table, $request);
        }
        if ($request->export === 'excel') {
            return $this->downloadExcel('Laporan Servis', 'Laporan_Servis', $table, $request);
        }

        return view('laporan-servis', ['rows' => $rows]);
    }

    private function laporanServisData(Request $request)
    {
        $query = DB::table('servis')
            ->join('kendaraan', 'servis.kendaraan_id', '=', 'kendaraan.id')
            ->join('pelanggan', 'kendaraan.pelanggan_id', '=', 'pelanggan.id')
            ->leftJoin('mekanik', 'servis.mekanik_id', '=', 'mekanik.id')
            ->select(
                'servis.no_servis',
                'pelanggan.nama as nama_pelanggan',
                'kendaraan.no_polisi',
                'mekanik.nama as nama_mekanik',
                'servis.tanggal_masuk',
                'servis.keluhan',
                'servis.status'
            );

        if ($request->from) {
            $query->whereDate('servis.tanggal_masuk', '>=', $request->from);
        }

        if ($request->to) {
            $query->whereDate('servis.tanggal_masuk', '<=', $request->to);
        }

        return $query->orderByDesc('servis.tanggal_masuk')->get();
    }

    private function laporanServisTableHtml($rows)
    {
        $html = '<table border="1" cellpadding="4" cellspacing="0" width="100%">'
            . '<tr style="background-color:#eeeeee;font-weight:bold;text-align:center">'
            . '<th>No</th><th>No Servis</th><th>Pelanggan</th><th>No Polisi</th>'
            . '<th>Mekanik</th><th>Tanggal Masuk</th><th>Keluhan</th><th>Status</th></tr>';

        $no = 1;
        foreach ($rows as $row) {
            $html .= '<tr>'
                . '<td>' . $no++ . '</td>'
                . '<td>' . e($row->no_servis) . '</td>'
                . '<td>' . e($row->nama_pelanggan) . '</td>'
                . '<td>' . e($row->no_polisi) . '</td>'
                . '<td>' . e($row->nama_mekanik ?: '-') . '</td>'
                . '<td>' . e($row->tanggal_masuk) . '</td>'
                . '<td>' . e($row->keluhan ?: '-') . '</td>'
                . '<td>' . e(ucfirst($row->status ?: '-')) . '</td>'
                . '</tr>';
        }

        return $html . '</table>';
    }

    public function laporanPendapatan(Request $request)
    {
        $data = $this->laporanPendapatanData($request);
        $table = $this->laporanPendapatanTableHtml($data['rows'], $data['jasaByServis'], $data['totalPendapatan']);

        if ($request->export === 'pdf') {
            return $this->downloadPdf('Laporan Pendapatan', 'Laporan_Pendapatan', $table, $request);
        }
        if ($request->export === 'excel') {
            return $this->downloadExcel('Laporan Pendapatan', 'Laporan_Pendapatan', $table, $request);
        }

        return view('laporan-pendapatan', $data);
    }

    private function laporanPendapatanData(Request $request)
    {
        $query = DB::table('pembayaran')
            ->leftJoin('servis', 'servis.id', '=', 'pembayaran.servis_id')
            ->select('pembayaran.*', 'servis.no_servis', 'servis.keluhan');

        if ($request->from) {
            $query->whereDate('pembayaran.tanggal', '>=', $request->from);
        }

        if ($request->to) {
            $query->whereDate('pembayaran.tanggal', '<=', $request->to);
        }

        $rows = $query->orderByDesc('pembayaran.tanggal')->get();

        $jasaByServis = $this->jasaByServis($rows->pluck('servis_id')->filter()->unique()->all());
        $totalPendapatan = 0;

        foreach ($rows as $row) {
            $jasaList = $jasaByServis->get($row->servis_id, collect());
            $row->total_jasa = $jasaList->isNotEmpty()
                ? $jasaList->sum(fn($jasa) => $jasa->jumlah * $jasa->harga)
                : $row->jumlah_bayar;
            $totalPendapatan += $row->total_jasa;
        }

        return [
            'rows' => $rows,
            'jasaByServis' => $jasaByServis,
            'totalPendapatan' => $totalPendapatan,
        ];
    }

    private function laporanPendapatanTableHtml($rows, $jasaByServis, $totalPendapatan)
    {
        $html = '<table border="1" cellpadding="4" cellspacing="0" width="100%">'
            . '<tr style="background-color:#eeeeee;font-weight:bold;text-align:center">'
            . '<th>No</th><th>No Pembayaran</th><th>No Servis</th><th>Jasa Dipilih</th>'
            . '<th>Tanggal</th><th>Jumlah Bayar</th><th>Metode</th></tr>';

        $no = 1;
        foreach ($rows as $row) {
            $jasaList = $jasaByServis->get($row->servis_id, collect());
            $jasa = '-';
            if ($jasaList->isNotEmpty()) {
                $jasa = $jasaList
                    ->map(fn($jasa) => e($jasa->nama_jasa) . ' (' . $jasa->jumlah . 'x) - Rp'
                        . number_format($jasa->jumlah * $jasa->harga, 0, ',', '.'))
                    ->implode('<br>');
            }

            $html .= '<tr>'
                . '<td>' . $no++ . '</td>'
                . '<td>' . e($row->no_pembayaran) . '</td>'
                . '<td>' . e($row->no_servis ?? '-') . '</td>'
                . '<td>' . $jasa . '</td>'
                . '<td>' . e($row->tanggal) . '</td>'
                . '<td style="text-align:right">Rp' . number_format($row->total_jasa, 0, ',', '.') . '</td>'
                . '<td>' . e(ucfirst($row->metode)) . '</td>'
                . '</tr>';
        }

        return $html
            . '<tr>'
            . '<td colspan="5" style="text-align:right;font-weight:bold">Total Pendapatan</td>'
            . '<td style="text-align:right;font-weight:bold">Rp' . number_format($totalPendapatan, 0, ',', '.') . '</td>'
            . '<td></td>'
            . '</tr></table>';
    }

    // ==================== PROFIL ====================

    public function profil()
    {
        $user = DB::table('users')->where('nama', session('u'))->first();

        return view('profil', ['user' => $user]);
    }

    public function updateProfil(Request $request)
    {
        $user = DB::table('users')->where('nama', session('u'))->first();

        if (!$user) {
            return redirect('/profil');
        }

        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'updated_at' => now(),
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        DB::table('users')->where('id', $user->id)->update($data);
        session(['u' => $request->nama]);

        return redirect('/profil');
    }

    // ==================== EXPORT LAPORAN ====================

    private function laporanHeaderHtml(string $title, Request $request): string
    {
        $periode = 'Periode: ' . ($request->from ?: 'awal') . ' s/d ' . ($request->to ?: 'akhir');

        return '<h2 style="text-align:center">' . e($title) . '</h2>'
            . '<p style="text-align:center;font-size:10px">'
            . e($periode) . ' | Dicetak: ' . now()->format('d/m/Y H:i')
            . '</p>';
    }

    private function downloadPdf(string $title, string $filename, string $tableHtml, Request $request)
    {
        $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator('Sistem Informasi Bengkel Motor');
        $pdf->SetTitle($title);
        $pdf->SetMargins(15, 15, 15);
        $pdf->SetAutoPageBreak(true, 15);
        $pdf->AddPage();
        $pdf->writeHTML($this->laporanHeaderHtml($title, $request) . $tableHtml, true, false, true, false, '');
        $pdf->Output($filename . '.pdf', 'D');
    }

    private function downloadExcel(string $title, string $filename, string $tableHtml, Request $request)
    {
        $html = '<html><head><meta charset="utf-8"></head><body>'
            . $this->laporanHeaderHtml($title, $request)
            . $tableHtml
            . '</body></html>';

        return response("\xEF\xBB\xBF" . $html, 200, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $filename . '.xls"',
        ]);
    }

}
