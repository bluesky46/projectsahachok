@extends('layouts.app')

@section('content')
<style>
/* Navbar */
.navbar {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 60px;
    z-index: 1100;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(5px);
    padding: 10px 20px;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.2);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.navbar .btn {
    margin-left: 10px;
}

/* ปรับพื้นหลังเต็มหน้าจอ */
body {
    background: linear-gradient(to right, #ff758c, #ff7eb3, #a29bfe);
    min-height: 100vh;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding-top: 60px; /* ป้องกัน navbar บัง card */
}

/* ทำให้ container กึ่งกลางแนวตั้ง */
.container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: calc(100vh - 60px);
    width: 100%;
}

/* Card - ปรับให้ใหญ่ขึ้น */
.card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(20px);
    border-radius: 15px;
    padding: 40px;
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
    max-width: 800px;
    width: 150%;
}

/* ปุ่ม */
.btn-primary {
    background-color: #6c5ce7;
    border: none;
}

.btn-primary:hover {
    background-color: #a29bfe;
}

.alert {
    border-radius: 10px;
}
</style>

<nav class="navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">My App</a>
        <div class="d-flex ms-auto">
            <a href="{{ route('login') }}" class="btn btn-outline-primary">Log In</a>
            <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
        </div>
    </div>
</nav>

{{-- <div class="container">
    <div class="card">
        <div class="card-header text-center fs-4 fw-bold">{{ __('Reset Password') }}</div> --}}
        <div class="container">
            <div class="card">
                <div class="card-header text-center">
                    {{ __('Reset Password') }}
                </div>
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                {{-- <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div> --}}
                <div class="mb-3 row">
                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                    <div class="col-md-8">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary w-100">
                        {{ __('Send Password Reset Link') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
