@extends('template')
@section('content')

<h1 class="mb-4 fw-bold">Tambah Data</h1>

<form action="/master/{{ $table }}" method="POST" style="max-width: 500px;">
    @csrf

    <?php foreach ($columns as $column) { ?>
        <?php if (!in_array($column, ['id', 'created_at', 'updated_at'])) { ?>
            <label class="fw-semibold"><?= str_replace('_', ' ', ucfirst($column)) ?>:</label>
            <input type="text" name="<?= $column ?>" class="form-control" required>
            <br>
        <?php } ?>
    <?php } ?>

    <button type="submit" class="btn btn-primary px-4">Simpan</button>
    <a href="<?= $backUrl ?>" class="btn btn-secondary px-4">Kembali</a>
</form>

@endsection
