<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\database;

class logincontroller extends Controller
{
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
            return redirect ()->intended('/home');
        }
        else{
            return redirect ()->intended('/');
        }
    }

    public function logout(){
        session()->flush();
        return redirect()->intended('/');
    }

    
public function zano(Request $Request)
    {
    $us = $Request->input('u');
    $ps = $Request->input('p');
    $em = $Request->input('e');
    

   $data = array(
    'nama' => $us,
    'password' => $ps,
    'email' => $em,
    'role' => 'admin',
    'created_at' => now(),
    'updated_at' => now()
    );

    $jalur = new database;
    $jalur->tambah('user', $data);

    return redirect()->intended('/');
    }

    public function tampil(){
        return view ('/girasya');
    }

    public function editview($id)
    {
        $user = DB::table('users')
            ->join('karyawan', 'users.id', '=', 'karyawan.id_user')
            ->where('users.id', $id)
            ->first();


        return view('edit', [
            'user' => $user,
            'jabatan' => DB::table('jabatan')->get(),
            'agama' => DB::table('agama')->get(),
        ]);
    }

    public function update(Request $request, $id)
{
    $data = $request->validate([
        'username' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'password' => 'nullable|string',
        'level' => 'required|in:admin,kasir,mekanik,owner',
        'nama' => 'required|string|max:255',
        'alamat' => 'required|string|max:255',
        'jk' => 'required|in:L,P',
        'jabatan' => 'required|exists:jabatan,id_jabatan',
       
    ]);

    $akun = [
        'nama' => $data['username'],
        'email' => $data['email'],
        'role' => $data['level'],    
        'updated_at' => now(),
    ];

    if ($data['password']) {
        $akun['password'] = $data['password'];
    }

    $karyawan = [
        'nama_kry' => $data['nama'],
        'alamat_kry' => $data['alamat'],
        'jk_kry' => $data['jk'],
        'id_jabatan' => $data['jabatan'],
        'id_agama' => $data['agama'],
    ];

    $jalur = new database;
    $jalur->ubah('users', ['id' => $id], $akun);
    $jalur->ubah('karyawan', ['user_id' => $id], $karyawan); 
}

    public function delete($id)
{
    $jalur = new database;

    $jalur->hapus('karyawan', ['user_id' => $id]);

    $jalur->hapus('users', ['id_user' => $id]);

    return redirect('/home');
}



   public function home(Request $Request){
        if (session('u')){
            $from = $Request->input('from');
            $to = $Request->input('to');
            $jalur = new database;
            $hello['data'] = $jalur->join1($from, $to);
            return view('home', $hello);
        }
        else{
            return redirect()->intended('/');
        };
    }




    public function tkry()
    {
        return view('tkry');
    }
 
    

    public function aksi_tkry(Request $Request)
    {
        $nama = $Request->input('nama');
        $no_hp = $Request->input('no_hp');
        $spesialisasi = $Request->input('spesialisasi');

        $jalur = new database;
        $user = $jalur->tarik('users', ['nama' => session('u')]);

        if (!$user) {
            return redirect('/tkry');
        }

        $kry = array(
            'user_id' => $user->id,
            'nama' => $nama,
            'no_hp' => $no_hp,
            'spesialisasi' => $spesialisasi,
            'status' => 'aktif'
        );

        $cek = $jalur->tarik('mekanik', ['user_id' => $user->id]);

        if ($cek) {
            $jalur->ubah('mekanik', ['user_id' => $user->id], $kry);
        } else {
            $jalur->tambah('mekanik', $kry);
        }

        return redirect('/karyawan');
    }

    public function tplg()
    {
        $jalur = new database;
        $data['user'] = $jalur->tampil('users');

        return view('tplg', $data);
    }

    
    public function aksi_tplg(Request $Request)
    {
        $nama = $Request->input('nama');
        $alamat = $Request->input('alamat');
        $email = $Request->input('email');
        $no_hp = $Request->input('no_hp');

        $kode = 'PLG-' . now()->format('ymdHis');
        $data = array(
            'kode_pelanggan' => $kode,
            'nama' => $nama,
            'alamat' => $alamat,
            'email' => $email,
            'no_hp' => $no_hp
        );

        $jalur = new database;
        $jalur->tambah('pelanggan', $data);

        return redirect('/pelanggan');
    }
    public function pelanggan()
    {
        $jalur = new database;

        $data['pelanggan'] = $jalur->tampil('pelanggan');

        return view('pelanggan', $data);
    }

    public function createMaster($table)
    {
        $allowedTables = [
            'pelanggan' => '/pelanggan',
            'mekanik' => '/karyawan',
            'kendaraan' => '/kendaraan',
            'jasa_servis' => '/jasa-servis',
            'sparepart' => '/sparepart',
            'supplier' => '/supplier',
            'servis' => '/servis',
            'pembelian' => '/pembelian',
            'pembayaran' => '/pembayaran',
            'stok_masuk' => '/stok-masuk',
            'stok_opname' => '/stok-opname',
            'users' => '/pengguna',
        ];


        return view('create-master', [
            'table' => $table,
            'backUrl' => $allowedTables[$table],
            'columns' => DB::getSchemaBuilder()->getColumnListing($table),
        ]);
    }

    public function storeMaster(Request $request, $table)
    {
        $allowedTables = [
            'pelanggan', 'mekanik', 'kendaraan', 'jasa_servis', 'sparepart', 'supplier',
            'servis', 'pembelian', 'pembayaran', 'stok_masuk', 'stok_opname', 'users',
        ];
        

        $data = $request->except(['_token']);
        DB::table($table)->insert($data);

        $urls = [
            'pelanggan' => '/pelanggan',
            'mekanik' => '/karyawan',
            'kendaraan' => '/kendaraan',
            'jasa_servis' => '/jasa-servis',
            'sparepart' => '/sparepart',
            'supplier' => '/supplier',
            'servis' => '/servis',
            'pembelian' => '/pembelian',
            'pembayaran' => '/pembayaran',
            'stok_masuk' => '/stok-masuk',
            'stok_opname' => '/stok-opname',
            'users' => '/pengguna',
        ];

        return redirect($urls[$table]);
    }

    public function editMaster($table, $id)
    {
        $allowedTables = [
            'pelanggan' => '/pelanggan',
            'mekanik' => '/karyawan',
            'kendaraan' => '/kendaraan',
            'jasa_servis' => '/jasa-servis',
            'sparepart' => '/sparepart',
            'supplier' => '/supplier',
        ];


        $row = DB::table($table)->where('id', $id)->first();
        abort_if(!$row, 404);

        return view('edit-master', [
            'table' => $table,
            'row' => $row,
            'backUrl' => $allowedTables[$table],
        ]);
    }

    public function updateMaster(Request $request, $table, $id)
    {
        $allowedTables = ['pelanggan', 'mekanik', 'kendaraan', 'jasa_servis', 'sparepart', 'supplier'];
        

        $data = $request->except(['_token', '_method']);
        DB::table($table)->where('id', $id)->update($data);

        $urls = [
            'pelanggan' => '/pelanggan',
            'mekanik' => '/karyawan',
            'kendaraan' => '/kendaraan',
            'jasa_servis' => '/jasa-servis',
            'sparepart' => '/sparepart',
            'supplier' => '/supplier',
        ];

        return redirect($urls[$table]);
    }

    public function deleteMaster($table, $id)
    {
        $allowedTables = ['pelanggan', 'mekanik', 'kendaraan', 'jasa_servis', 'sparepart', 'supplier'];
        

        DB::table($table)->where('id', $id)->delete();

        $urls = [
            'pelanggan' => '/pelanggan',
            'mekanik' => '/karyawan',
            'kendaraan' => '/kendaraan',
            'jasa_servis' => '/jasa-servis',
            'sparepart' => '/sparepart',
            'supplier' => '/supplier',
        ];

        return redirect($urls[$table]);
    }

    public function karyawan()
    {
        $jalur = new database;
        $data['karyawan'] = $jalur->join1();

        return view('mekanik', $data);
    }

    public function kendaraan()
    {
        return view('kendaraan', ['rows' => DB::table('kendaraan')->get()]);
    }

    public function jasaServis()
    {
        return view('jasa-servis', ['rows' => DB::table('jasa_servis')->get()]);
    }

    public function sparepart()
    {
        return view('sparepart', ['rows' => DB::table('sparepart')->get()]);
    }

    public function supplier()
    {
        return view('supplier', ['rows' => DB::table('supplier')->get()]);
    }

    public function servis()
    {
        return view('servis', ['rows' => DB::table('servis')->get()]);
    }

    public function pembelian()
    {
        return view('pembelian', ['rows' => DB::table('pembelian')->get()]);
    }

    public function pembayaran()
    {
        return view('pembayaran', ['rows' => DB::table('pembayaran')->get()]);
    }

    public function stokMasuk()
    {
        return view('stok-masuk', ['rows' => DB::table('stok_masuk')->get()]);
    }

    public function stokKeluar()
    {
        $masuk = DB::table('stok_masuk')
            ->join('sparepart', 'stok_masuk.sparepart_id', '=', 'sparepart.id')
            ->select(
                'stok_masuk.tanggal',
                'sparepart.nama_sparepart',
                DB::raw("'Masuk' as aktivitas"),
                'stok_masuk.jumlah',
                'stok_masuk.keterangan'
            )
            ->get();

        $keluar = DB::table('stok_keluar')
            ->join('sparepart', 'stok_keluar.sparepart_id', '=', 'sparepart.id')
            ->select(
                'stok_keluar.tanggal',
                'sparepart.nama_sparepart',
                DB::raw("'Keluar' as aktivitas"),
                'stok_keluar.jumlah',
                'stok_keluar.keterangan'
            )
            ->get();

        $rows = $masuk->concat($keluar)->sortByDesc('tanggal')->values();

        return view('stok-riwayat', ['rows' => $rows]);
    }

    public function stokOpname()
    {
        return view('stok-opname', ['rows' => DB::table('stok_opname')->get()]);
    }

    public function laporanServis()
    {
        return view('laporan-servis', ['rows' => DB::table('v_laporan_servis')->get()]);
    }

    public function laporanPendapatan()
    {
        return view('laporan-pendapatan', ['rows' => DB::table('pembayaran')->get()]);
    }

    public function laporanPersediaan()
    {
        $sparepart = DB::table('sparepart')
            ->select('nama_sparepart', 'stok', 'stok_minimum', 'harga_jual')
            ->get();

        $summary = [
            'jenis' => $sparepart->count(),
            'total_stok' => $sparepart->sum('stok'),
            'hampir_habis' => $sparepart->filter(function ($item) {
                return $item->stok > 0 && $item->stok <= $item->stok_minimum;
            })->count(),
            'kosong' => $sparepart->where('stok', 0)->count(),
            'nilai' => $sparepart->sum(function ($item) {
                return $item->stok * $item->harga_jual;
            }),
        ];

        return view('laporan-persediaan', [
            'summary' => $summary,
            'rows' => $sparepart,
        ]);
    }

    public function pengguna()
    {
        return view('pengguna', [
            'rows' => DB::table('users')
                ->select('id', 'nama', 'email', 'role', 'no_hp', 'is_active', 'created_at')
                ->get(),
        ]);
    }

    public function profil()
    {
        $user = DB::table('users')->where('nama', session('u'))->first();

        return view('profil', ['user' => $user]);
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'password' => 'nullable|min:6',
        ]);

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

        return redirect('/profil')->with('success', 'Profil berhasil diperbarui.');
    }

}  