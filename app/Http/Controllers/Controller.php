<?php

namespace App\Http\Controllers;

//----- Controller.php: class induk (parent) untuk SEMUA controller di project ini
//----- berisi helper bersama: upload foto, generate PDF, dan query detail jasa per servis

use Illuminate\Foundation\Auth\Access\AuthorizesRequests; //----- trait: method bantu untuk pengecekan hak akses (authorize)
use Illuminate\Foundation\Validation\ValidatesRequests; //----- trait: method bantu untuk validasi form ($this->validate)
use Illuminate\Routing\Controller as BaseController; //----- BaseController: class controller bawaan Laravel
use Illuminate\Support\Facades\DB;

//----- class Controller: titik pusat semua controller aplikasi
class Controller extends BaseController
{
    //----- use trait: memasukkan method-method bantu ke dalam class ini
    //----- AuthorizesRequests = bisa pakai $this->authorize() untuk cek permission
    //----- ValidatesRequests  = bisa pakai $this->validate() untuk validasi input
    use AuthorizesRequests, ValidatesRequests;

    //----- jasaByServis(): Mengambil detail jasa per servis_id dan mengelompokkannya (dipakai pembayaran & laporan)
    protected function jasaByServis(array $servisIds)
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

    //----- simpanFoto(): Helper — menyimpan file foto upload ke public/uploads/users dan mengembalikan nama filenya
    protected function simpanFoto($file)
    {
        if (!$file) {
            return null;
        }

        $folder = public_path('uploads/users');
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $extension = strtolower($file->extension() ?: $file->getClientOriginalExtension() ?: 'jpg');
        $namaFile = uniqid('foto_') . '.' . $extension;
        $file->move($folder, $namaFile);

        return $namaFile;
    }

    //----- hapusFoto(): Helper — menghapus file foto dari folder uploads jika ada
    protected function hapusFoto($namaFile)
    {
        $path = public_path('uploads/users/' . $namaFile);
        if (file_exists($path)) {
            unlink($path);
        }
    }

    //----- pdfTable(): Helper — membangun tabel HTML lalu mengunduhnya sebagai PDF
    protected function pdfTable(string $title, string $filename, array $headings, array $rows): void
    {
        // 1. Siapkan bagian judul laporan
        $html = '<h1 style="text-align:center">' . e($title) . '</h1>';
        $html .= '<p style="text-align:center">Dicetak: ' . now()->format('d/m/Y H:i') . '</p>';
        $html .= '<br>';

        // 2. Buka tabel dan baris heading
        $html .= '<table border="1" width="100%">';
        $html .= '<tr style="background-color:#dddddd;font-weight:bold">';
        foreach ($headings as $heading) {
            $html .= '<th>' . e($heading) . '</th>';
        }
        $html .= '</tr>';

        // 3. Isi data per baris
        foreach ($rows as $row) {
            $html .= '<tr>';
            foreach ($row as $cell) {
                $html .= '<td>' . e((string) $cell) . '</td>';
            }
            $html .= '</tr>';
        }

        // 4. Tutup tabel lalu download
        $html .= '</table>';
        $this->downloadPdfHtml($filename, $html);
    }

    //----- downloadPdf(): Helper — merender view Blade lalu mengunduhnya sebagai PDF
    protected function downloadPdf(string $view, string $filename, array $data)
    {
        $this->downloadPdfHtml($filename, view($view, $data)->render());
    }

    //----- downloadPdfHtml(): Helper — generate PDF dari string HTML menggunakan TCPDF lalu force download
    protected function downloadPdfHtml(string $filename, string $html): void
    {
        $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetCreator('Sistem Informasi Bengkel Motor');
        $pdf->SetTitle($filename);
        $pdf->SetMargins(15, 15, 15);
        $pdf->SetAutoPageBreak(true, 15);
        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output($filename . '.pdf', 'D');
        exit;
    }
}
