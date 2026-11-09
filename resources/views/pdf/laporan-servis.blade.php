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
    </style>
</head>
<body>
    <h2>Laporan Servis</h2>
    <p class="periode">
        Periode: {{ $from ?: 'awal' }} s/d {{ $to ?: 'akhir' }}
        | Dicetak: {{ now()->format('d/m/Y H:i') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Servis</th>
                <th>Pelanggan</th>
                <th>No Polisi</th>
                <th>Mekanik</th>
                <th>Tanggal Masuk</th>
                <th>Keluhan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            @foreach ($rows as $row)
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row->no_servis ?></td>
                    <td><?= $row->nama_pelanggan ?></td>
                    <td><?= $row->no_polisi ?></td>
                    <td><?= $row->nama_mekanik ?: '-' ?></td>
                    <td><?= $row->tanggal_masuk ?></td>
                    <td><?= $row->keluhan ?: '-' ?></td>
                    <td><?= ucfirst($row->status ?: '-') ?></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
