@extends('layouts.app')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-4">
        <div class="card shadow border-0">
            <div class="card-body p-4">

                <h4 class="text-center mb-4 fw-bold text-pink">
                    💖 ByeBill Login
                </h4>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email"
                               name="email"
                               class="form-control"
                               required
                               autofocus>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password"
                               name="password"
                               class="form-control"
                               required>
                    </div>

                    {{-- REMEMBER ME --}}
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="remember"
                                   id="remember">
                            <label class="form-check-label" for="remember">
                                Remember me
                            </label>
                        </div>

                        <a href="{{ route('password.request') }}"
                           class="text-pink text-decoration-none small">
                            Lupa kata sandi?
                        </a>
                    </div>

                    <button class="btn btn-pink w-100">
                        Login
                    </button>

                    <a href="{{ route('google.login') }}"
                        class="btn btn-outline-danger w-100 mt-3">
                        <i class="bi bi-google"></i> Login dengan Google
                        </a>

                </form>

                <p class="text-center mt-4 mb-0">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-pink fw-semibold">
                        Register
                    </a>
                </p>

            </div>
        </div>
    </div>
</div>
@endsection
