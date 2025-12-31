@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-2">

    <div>
        <h3 class="fw-bold mb-1 text-pink">📋 Daftar Tagihan</h3>

        {{-- Badge Status Akun --}}
        @if(auth()->user()->isPremium())
            <span class="badge text-pink ">⭐ Premium</span>
        @else
            <span class="badge bg-secondary">Free</span>
        @endif
    </div>

    <div class="d-flex gap-2">
        {{-- Upgrade Button (FREE ONLY) --}}
        @if(!auth()->user()->isPremium())
            <a href="{{ route('upgrade.index') }}"
               class="btn btn-pink">
                ⭐ Upgrade
            </a>
        @endif

        {{-- Button Tambah Tagihan --}}
        @if(auth()->user()->isPremium() || auth()->user()->bills->count() < 3)
            <a href="{{ route('bills.create') }}" class="btn btn-pink">
                + Tambah Tagihan
            </a>
        @else
            <button class="btn btn-outline-secondary" disabled>
                🔒 Upgrade untuk tambah tagihan
            </button>
        @endif
    </div>
</div>

{{-- ================= FREE REMINDER ALERT ================= --}}
@if(!auth()->user()->isPremium() && $dueSoonBills->count() > 0)
<div class="alert alert-pink">
    ⏰ Kamu punya <strong>{{ $dueSoonBills->count() }}</strong>
    tagihan yang akan jatuh tempo dalam 3 hari!
</div>
@endif

{{-- Alert Success --}}
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

{{-- ================= PROGRESS BAR (FREE ONLY) ================= --}}
@if(!auth()->user()->isPremium())
@php
    $count = auth()->user()->bills->count();
@endphp

<div class="mb-3">
    <small>{{ $count }} / 3 tagihan</small>
    <div class="progress">
        <div class="progress-bar bg-pink" style="width: {{ ($count/3)*100 }}%"></div>
    </div>
</div>

@if($count >= 3)
<div class="alert alert-pink d-flex justify-content-between align-items-center">
    <div>
        Kamu sudah mencapai batas tagihan Free.
        <strong>Upgrade ke Premium</strong> untuk fitur tanpa batas ⭐
    </div>

    <a href="{{ route('upgrade.index') }}"
       class="btn btn-sm btn-pink">
        Upgrade Sekarang
    </a>
</div>
@endif

@endif

{{-- ================= EXPORT (PREMIUM ONLY) ================= --}}
<div class="mb-3">
    @if(!auth()->user()->isPremium())
    <!-- fitur premium -->

        <a href="{{ route('bills.export') }}" class="btn btn-pink">
            📤 Export Excel
        </a>
    @else
        <button class="btn btn-outline-secondary" disabled>
            🔒 Export Premium Only
        </button>
    @endif
</div>

{{-- ================= TABLE ================= --}}
<div class="card shadow-sm border-0 border-pink">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-pink">
                <tr>
                    <th>Nama Tagihan</th>
                    <th>Jumlah</th>
                    <th>Jatuh Tempo</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bills as $bill)
                <tr>
                    <td class="fw-semibold">{{ $bill->bill_name }}</td>

                    <td>Rp {{ number_format($bill->amount) }}</td>

                    <td>
                        {{ \Carbon\Carbon::parse($bill->due_date)->format('d M Y') }}

                        {{-- Reminder Due Soon --}}
                        @if(
                            \Carbon\Carbon::parse($bill->due_date)->lte(now()->addDays(3)) &&
                            $bill->status !== 'Sudah Dibayar'
                        )
                            <span class="badge ms-1 text-pink">
                                ⏰ Due Soon
                            </span>
                        @endif
                    </td>

                    <td>
                        <span class="badge
                            {{ $bill->status == 'Sudah Dibayar' ? 'bg-success' : 'text-pink' }}">
                            {{ $bill->status }}
                        </span>
                    </td>

                    <td class="text-end">
                        <a href="{{ route('bills.edit', $bill) }}" class="btn btn-sm btn-outline-pink">
                            Edit
                        </a>

                        <form action="{{ route('bills.destroy', $bill) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Hapus tagihan ini?')"
                                class="btn btn-sm btn-outline-danger">
                                Hapus
                            </button>
                        </form>

                        {{-- 🔔 TOMBOL REMINDER TIDAK DIHAPUS --}}
                        <form action="{{ route('bills.testReminder', $bill) }}"
                            method="POST"
                            class="d-inline">
                            @csrf
                            <button type="submit"
                                class="btn btn-sm btn-outline-warning"
                                title="Test Reminder">
                                🔔
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        Belum ada tagihan 😴
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ================= FREE BROWSER NOTIFICATION ================= --}}
@if(!auth()->user()->isPremium())
<script>
const hasReminder = {{ $dueSoonBills->count() > 0 ? 'true' : 'false' }};
const cookieExists = document.cookie.includes('reminder_today');

if ("Notification" in window) {

    if (Notification.permission === "default") {
        Notification.requestPermission();
    }

    if (
        Notification.permission === "granted" &&
        hasReminder &&
        !cookieExists
    ) {
        new Notification("⏰ BillRemind", {
            body: "Kamu punya {{ $dueSoonBills->count() }} tagihan yang akan jatuh tempo!",
            icon: "/images/logo.png"
        });

        document.cookie = "reminder_today=1; max-age=86400; path=/";
    }
}
</script>
@endif

@endsection
