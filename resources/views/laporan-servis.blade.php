@extends('template')
@section('content')
<h1>Laporan Servis</h1>
<div class="card mt-3">
    <div class="card-header"><h5 class="card-title mb-0">Laporan Servis</h5></div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
            <thead><tr><th>No</th><th>Data Servis</th></tr></thead>
            <tbody>
            <?php
            $no = 1;
            foreach ($rows as $value) {
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $value->id ?></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
@endsection
