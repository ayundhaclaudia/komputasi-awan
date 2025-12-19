@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3 class="mb-3">Dashboard</h3>

    {{-- STATUS --}}
    <div class="alert {{ auth()->user()->is_premium ? 'alert-warning' : 'alert-secondary' }}">
        Status Akun:
        <strong>{{ auth()->user()->is_premium ? 'Premium ⭐' : 'Free' }}</strong>

        @if(!auth()->user()->is_premium)
            <a href="{{ route('upgrade') }}" class="btn btn-warning btn-sm float-end">
                Upgrade ke Premium
            </a>
        @endif
    </div>

    {{-- AKSI --}}
    <div class="mb-3">
        @if(auth()->user()->is_premium)
            <a href="{{ route('bills.create') }}" class="btn btn-primary">
                + Tambah Tagihan
            </a>
        @else
            <button class="btn btn-secondary" disabled>
                + Tambah Tagihan (Premium Only)
            </button>

            <button class="btn btn-outline-warning ms-2"
                data-bs-toggle="modal"
                data-bs-target="#premiumModal">
                Lihat Fitur Premium
            </button>
        @endif
    </div>

    {{-- INFO --}}
    @if(!auth()->user()->is_premium)
        <div class="alert alert-info">
            Akun <strong>Free</strong> hanya bisa melihat tagihan.
            Upgrade ke <strong>Premium</strong> untuk akses penuh.
        </div>
    @endif

    {{-- TAGIHAN --}}
    <div class="card">
        <div class="card-header fw-bold">Daftar Tagihan</div>
        <table class="table mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Nama</th>
                    <th>Nominal</th>
                    <th>Jatuh Tempo</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Listrik</td>
                    <td>Rp 500.000</td>
                    <td>20 Desember 2025</td>
                    <td><span class="badge bg-success">Lunas</span></td>
                    <td>
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </td>
                </tr>

                <tr>
                    <td>Internet</td>
                    <td>Rp 300.000</td>
                    <td>25 Desember 2025</td>
                    <td><span class="badge bg-danger">Belum Lunas</span></td>
                    <td>
                        @if(auth()->user()->is_premium)
                            <button class="btn btn-success btn-sm">Tandai Lunas</button>
                        @else
                            <span class="badge bg-secondary">Premium Only</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

{{-- MODAL --}}
@include('partials.premium-modal')
@endsection
