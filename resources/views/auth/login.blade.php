@php
    use Illuminate\Support\Facades\Route;
@endphp

@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #2c3e50, #4b6584);
        min-height: 100vh;
        font-family: 'Segoe UI', sans-serif;
    }

    /* NAVBAR */
    .navbar {
        position: fixed;
        top: 0;
        width: 100%;
        height: 60px;
        z-index: 1000;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(8px);
        padding: 10px 25px;
    }

    .navbar-brand {
        color: #fff !important;
        font-weight: bold;
        letter-spacing: 1px;
    }

    /* CARD */
    .card {
        background: #ffffff;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.3);
        max-width: 520px;
        width: 100%;
        border: none;
    }

    .card-header {
        background: none;
        border: none;
        font-size: 24px;
        font-weight: bold;
        color: #2c3e50;
    }

    /* INPUT */
    .form-control {
        border-radius: 10px;
        padding: 10px;
        border: 1px solid #ccc;
        transition: 0.2s;
    }

    .form-control:focus {
        border-color: #2980b9;
        box-shadow: 0 0 0 2px rgba(41, 128, 185, 0.2);
    }

    /* BUTTON */
    .btn-primary {
        background: #2980b9;
        border: none;
        border-radius: 10px;
        padding: 10px;
        font-weight: bold;
        transition: 0.2s;
    }

    .btn-primary:hover {
        background: #1f6690;
    }

    /* LINK */
    a {
        color: #2980b9;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    /* CONTAINER */
    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding-top: 60px;
    }
    </style>

    <nav class="navbar">
        <div class="container-fluid">
            <span class="navbar-brand">
                🏗️ Sahachoke Metal Roof
            </span>
            <div class="nav-links">
                <a class="btn btn-outline-primary" href="{{ route('login') }}">เข้าสู่ระบบ</a>
                <a class="btn btn-primary" href="{{ route('register') }}">สมัครสมาชิก</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <div>🔐 เข้าสู่ระบบ</div>
                <small class="text-muted">ระบบจัดการร้านวัสดุก่อสร้าง</small>
            </div>


            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3 row">
                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('อีเมล') }}</label>
                        <div class="col-md-8">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('รหัสผ่าน') }}</label>
                        <div class="col-md-8">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4 row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('Remember Me') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('จดจำฉัน') }}
                                    </label>
                                </div>
                                @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">ลืมรหัสผ่าน?</a>

                                <a class="btn btn-link p-0 text-decoration-underline" href="{{ route('password.request') }}">
                                    {{ __('คุณลืมรหัสใช่หรือไม่ ?') }}
                                </a>
                            @endif

                            </div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary w-100">
                                {{ __('เข้าสู่ระบบ') }}
                            </button>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
@endsection
