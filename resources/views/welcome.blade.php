@extends('layouts.app')

@section('content')

<div class="row align-items-center">
    <div class="col-md-6">
        <h1 class="fw-bold">
            Kelola Tagihan Bulanan <br>
            Jadi Lebih Mudah
        </h1>

        <p class="text-muted mt-3">
            ByeBill membantu kamu mencatat, memantau, dan mengingat
            semua tagihan bulanan dalam satu aplikasi.
        </p>

        <a href="{{ route('register') }}" class="btn btn-primary btn-lg mt-3">
            Mulai Sekarang
        </a>
    </div>

    <div class="col-md-6 text-center">
        <img src="{{ asset('images/byebill-logo.png') }}" alt="Logo ByeBill"
             class="img-fluid"
             alt="ByeBill">
    </div>
</div>

@endsection
