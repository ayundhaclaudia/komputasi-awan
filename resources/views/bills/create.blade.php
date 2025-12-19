@extends('layouts.app')

@section('content')
<div class="container mt-4" style="max-width: 600px">

    <h3 class="mb-3">Tambah Tagihan</h3>

    <div class="card shadow-sm">
        <div class="card-body">

            <form>
                <div class="mb-3">
                    <label class="form-label">Nama Tagihan</label>
                    <input type="text" class="form-control" placeholder="Contoh: Listrik">
                </div>

                <div class="mb-3">
                    <label class="form-label">Nominal</label>
                    <input type="number" class="form-control" placeholder="500000">
                </div>

                <div class="mb-3">
                    <label class="form-label">Jatuh Tempo</label>
                    <input type="date" class="form-control">
                </div>

                <button class="btn btn-primary w-100">
                    Simpan Tagihan
                </button>
            </form>

            <a href="{{ route('dashboard') }}" class="btn btn-secondary w-100 mt-2">
                Batal
            </a>

        </div>
    </div>

</div>
@endsection
