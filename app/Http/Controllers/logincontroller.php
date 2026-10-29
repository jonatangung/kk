<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\database;

class logincontroller extends Controller
{
    public function index(){
        return view ('/login');
    }

    public function aksilogin(Request $Request){
        $username= $Request->input('u');
        $password= $Request->input('p');
        $where= array(
        'username'=>$username,
        'password'=> $password
    );

        $jalur= new database;
        $hasilcek = $jalur->tarik('user', $where);

        if($hasilcek){
            session(['u'=>$hasilcek->username]);
            return redirect ()->intended('/home');
        }
        else{
            return redirect ()->intended('/');
        }
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
    
    public function exportUsersExcel(Request $Request)
    {
        if (!session('u')) {
            return redirect('/');
        }

        return Excel::download(
            new UsersExport($this->filteredUsers($Request)),
            'data-users.xlsx'
        );
    }

    public function exportUsersPdf(Request $Request)
    {
        if (!session('u')) {
            return redirect('/');
        }

        $data = $this->filteredUsers($Request);
        $pdf = new \TCPDF();
        $pdf->SetTitle('Data User');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();
        $pdf->writeHTML(view('users-pdf', ['data' => $data])->render(), true, false, true, false, '');

        return response($pdf->Output('data-user.pdf', 'S'))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="data-user.pdf"');
    }

   private function filteredUsers(Request $request): Collection
    {
        $jalur = new database;

        return $jalur->join1($request->input('from'), $request->input('to'));
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
    'username' => $us,
    'password' => $ps,
    'email' => $em,
    'level' => 'pelanggan',
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
        $user = DB::table('user')
            ->join('karyawan', 'user.id_user', '=', 'karyawan.id_user')
            ->where('user.id_user', $id)
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
            'level' => 'required|in:admin,karyawan,pelanggan',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'jk' => 'required|in:L,P',
            'jabatan' => 'required|exists:jabatan,id_jabatan',
            'agama' => 'required|exists:agama,id_agama',
        ]);

        $akun = [
            'username' => $data['username'],
            'email' => $data['email'],
            'level' => $data['level'],
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
        $jalur->ubah('user', ['id_user' => $id], $akun);
        $jalur->ubah('karyawan', ['id_user' => $id], $karyawan);

        return redirect('/home');
    }

    public function delete($id)
{
    $jalur = new database;

    $jalur->hapus('karyawan', ['id_user' => $id]);

    $jalur->hapus('user', ['id_user' => $id]);

    return redirect('/home');
}



    public function karyawan()
    {
        $jalur = new database;
        $data['karyawan'] = $jalur->join1();

        return view('karyawan', $data);
    }


    public function tkry()
    {
        $jalur = new database;

        $data['jabatan'] = $jalur->tampil('jabatan');
        $data['agama'] = $jalur->tampil('agama');

        return view('tkry', $data);
    }
 
    

    public function aksi_tkry(Request $Request)
    {
        $nama = $Request->input('nama');
        $alamat = $Request->input('alamat');
        $jk = $Request->input('jk');
        $jb = $Request->input('jabatan');
        $ag = $Request->input('agama');

        $jalur = new database;
        $user = $jalur->tarik('user', ['username' => session('u')]);

        if (!$user) {
            return redirect('/tkry');
        }

        $kry = array(
            'id_user' => $user->id_user,
            'nama_kry' => $nama,
            'alamat_kry' => $alamat,
            'jk_kry' => $jk,
            'id_jabatan' => $jb,
            'id_agama' => $ag
        );

        $cek = $jalur->tarik('karyawan', ['id_user' => $user->id_user]);

        if ($cek) {
            $jalur->ubah('karyawan', ['id_user' => $user->id_user], $kry);
        } else {
            $jalur->tambah('karyawan', $kry);
        }

        return redirect('/karyawan');
    }

    public function tplg()
    {
        $jalur = new database;
        $data['user'] = $jalur->tampil('user');

        return view('tplg', $data);
    }

    
    public function aksi_tplg(Request $Request)
    {
        $nama = $Request->input('nama');
        $alamat = $Request->input('alamat');
        $no_hp = $Request->input('no_hp');

        $data = array(
            'nama_plg' => $nama,
            'alamat_plg' => $alamat,
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

    


}