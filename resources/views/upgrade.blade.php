@extends('layouts.app')

@section('content')
<div class="container mt-4" style="max-width: 700px">

    <h3 class="text-center mb-3">ByeBill Premium ⭐</h3>

    <div class="card shadow-sm">
        <div class="card-body">

            <ul class="list-group list-group-flush mb-3">
                <li class="list-group-item">✅ Tambah tagihan tanpa batas</li>
                <li class="list-group-item">✅ Tandai lunas kapan saja</li>
                <li class="list-group-item">✅ Kelola semua tagihan</li>
                <li class="list-group-item">✅ Akses penuh fitur ByeBill</li>
            </ul>

            @if(auth()->user()->plan !== 'premium')
                <form action="{{ route('upgrade.activate') }}" method="POST">
                    @csrf
                    <button class="btn btn-warning w-100">
                        Aktifkan Premium Sekarang
                    </button>
                </form>
            @else
                <button class="btn btn-secondary w-100" disabled>
                    Kamu Sudah Premium ⭐
                </button>
            @endif

            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary w-100 mt-2">
                Kembali ke Dashboard
            </a>

        </div>
    </div>

</div>
@endsection
