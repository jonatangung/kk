@extends('template')

@section('content')

    <h1 class="mb-4 fw-bold">Kelola Stok Barang</h1>

    <div class="card">
        <div class="card-body">
            <form action="/input_stok_barang" method="GET" class="row g-3 mb-4">
                <div class="col-md-8">
                    <label class="fw-semibold">Pilih Barang</label>
                    <select name="supplier_id" class="form-control" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach ($supplierData as $item)
                            <option value="{{ $item->id }}" @selected(request('supplier_id') == $item->id)>
                                {{ $item->nama_supplier }} - {{ $item->nama_barang ?: 'Tanpa Nama Barang' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-secondary w-100">Pilih</button>
                </div>
            </form>

            @if ($selectedBarang)
              

        

                    <div class="col-md-6">
                        <div class="border rounded p-3 h-100">
                            <h5 class="mb-3">Stok Keluar</h5>
                            <form action="/stok-barang_keluar/{{ $selectedBarang->id }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label class="fw-semibold">Jumlah Keluar</label>
                                    <input type="number" name="jumlah" min="1" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="fw-semibold">Tanggal Keluar</label>
                                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="fw-semibold">Harga Jual</label>
                                    <input type="number" name="harga_jual" min="0" class="form-control" required>
                                </div>

                                <button type="submit" class="btn btn-danger">Simpan Keluar</button>
                            </form>
                        </div>
                    </div>
                </div>

                <a href="/stok-barang" class="btn btn-secondary mt-3">Kembali</a>
            @endif
        </div>
    </div>

@endsection
