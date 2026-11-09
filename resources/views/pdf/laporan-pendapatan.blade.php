<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: helvetica;
            font-size: 10px;
        }
        h2 {
            text-align: center;
            margin-bottom: 2px;
        }
        p.periode {
            text-align: center;
            font-size: 9px;
            margin-top: 0;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000000;
            padding: 4px;
            text-align: left;
        }
        th {
            background-color: #eeeeee;
            text-align: center;
            font-weight: bold;
        }
        td.angka {
            text-align: right;
        }
        td.total-label {
            text-align: right;
            font-weight: bold;
        }
        td.total-nilai {
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Laporan Pendapatan</h2>
    <p class="periode">
        Periode: {{ $from ?: 'awal' }} s/d {{ $to ?: 'akhir' }}
        | Dicetak: {{ now()->format('d/m/Y H:i') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Pembayaran</th>
                <th>No Servis</th>
                <th>Jasa Dipilih</th>
                <th>Tanggal</th>
                <th>Jumlah Bayar</th>
                <th>Metode</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            @foreach ($rows as $row)
                @php $jasaList = $jasaByServis->get($row->servis_id, collect()); @endphp
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row->no_pembayaran ?></td>
                    <td><?= $row->no_servis ?? '-' ?></td>
                    <td>
                        @forelse ($jasaList as $jasa)
                            <div><?= $jasa->nama_jasa ?> (<?= $jasa->jumlah ?>x) - Rp<?= number_format($jasa->jumlah * $jasa->harga, 0, ',', '.') ?></div>
                        @empty
                            -
                        @endforelse
                    </td>
                    <td><?= $row->tanggal ?></td>
                    <td class="angka">Rp<?= number_format($row->total_jasa, 0, ',', '.') ?></td>
                    <td><?= ucfirst($row->metode) ?></td>
                </tr>
            @endforeach
            <tr>
                <td class="total-label" colspan="5">Total Pendapatan</td>
                <td class="total-nilai">Rp<?= number_format($totalPendapatan, 0, ',', '.') ?></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
