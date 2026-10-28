@extends('template')
@section('content')

<h1 class="no-print">Welcome to the dashboard <?php echo session('u') ?></h1><br>
<h1 class="print-title">Data Pengguna</h1>

<form class="no-print d-flex flex-wrap align-items-center gap-3 mb-4" action="{{ url('/home') }}" method="GET">
    <label for="from" class="fw-semibold text-nowrap">Dari Tanggal:</label>
    <input type="date" id="from" name="from" value="{{ request('from') }}" class="form-control w-auto">

    <label for="to" class="fw-semibold text-nowrap">Sampai Tanggal:</label>
    <input type="date" id="to" name="to" value="{{ request('to') }}" class="form-control w-auto">

    <button type="submit" class="btn btn-secondary">Filter</button>
    <a href="/home" class="btn btn-secondary me-3">Reset</a>
</form>

<p class="no-print">
    <a href="/users/export/excel?from={{ request('from') }}&to={{ request('to') }}">
        <button type="button" class="btn btn-secondary">Export Excel</button>
    </a>
    <a href="/users/export/pdf?from={{ request('from') }}&to={{ request('to') }}" target="_blank">
        <button type="button" class="btn btn-secondary">Export PDF</button>
    </a>
    <button type="button" onclick="window.print()" class="btn btn-secondary">Print</button>
</p>

<br>

<table id="users-table" class="table table-bordered table-striped" border="1">
    <thead class="table-light">
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Email</th>
            <th>Level</th>
            <th>Nama Karyawan</th>
            <th>Alamat</th>
            <th>Jabatan</th>
            <th>Agama</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($data as $key => $value) {
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $value->username ?></td>
            <td><?= $value->email ?></td>
            <td><?= $value->level ?></td>
            <td><?= $value->nama_kry ?? '-' ?></td>
            <td><?= $value->alamat_kry ?? '-' ?></td>
            <td><?= $value->nama_jabatan ?? '-' ?></td>
            <td><?= $value->nama_agama ?? '-' ?></td>
            <td>
                <?php if ($value->nama_kry) { ?>
                    <form action="/edit/<?= $value->id_user ?>" method="GET" style="display:inline;">
                        <button type="submit" class="btn btn-warning btn-sm">Edit</button>
                    </form>
                <?php } ?>

                <form action="/delete/<?= $value->id_user ?>" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table> <!-- INI TAG YANG TADI KETINGGALAN -->

@endsection