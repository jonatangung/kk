@extends('template')
@section('content')

<h1 class="mb-4 fw-bold">Edit Data</h1>

<form action="/master/{{ $table }}/{{ $row->id }}" method="POST" style="max-width: 500px;">
    @csrf
    @method('PUT')

    <?php foreach ((array) $row as $column => $value) { ?>
        <?php if (!in_array($column, ['id', 'created_at', 'updated_at'])) { ?>
            <label class="fw-semibold"><?= str_replace('_', ' ', ucfirst($column)) ?>:</label>
            <input type="text" name="<?= $column ?>" value="<?= $value ?>" class="form-control">
            <br>
        <?php } ?>
    <?php } ?>

    <button type="submit" class="btn btn-primary px-4">Simpan</button>
    <a href="<?= $backUrl ?>" class="btn btn-secondary px-4">Kembali</a>
</form>

@endsection
