@extends('layouts.auth')

@push('styles')
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@700&display=swap");

        body {
            font-family: "Inter", sans-serif;
            background-color: #ffffff;
            height: 100vh;
            overflow: hidden;
        }

        .main-container {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 1.5rem 2rem 1rem 2rem;
        }

        /* Custom Input Styling */
        .custom-input {
            border: 1.5px solid #059669 !important;
            border-radius: 10px !important;
            padding: 0.6rem 1rem;
            font-size: 0.875rem;
            color: #333;
        }

        .custom-input::placeholder {
            color: #a0aec0;
            font-size: 0.85rem;
        }

        .custom-input:focus {
            box-shadow: 0 0 0 0.2rem rgba(5, 150, 105, 0.2) !important;
            border-color: #059669 !important;
        }

        /* Checkbox Styling */
        .custom-checkbox {
            border: 1.5px solid #059669 !important;
            border-radius: 4px;
            cursor: pointer;
        }

        .custom-checkbox:checked {
            background-color: #059669 !important;
            border-color: #059669 !important;
        }

        /* Right Banner */
        .banner-card {
            background-color: #059669;
            border-radius: 24px;
            height: calc(100vh - 3rem);
            padding: 4rem 3.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .text-green-brand {
            color: #059669;
        }
    </style>
@endpush

@section('contents')
    <div class="main-container">
        <div class="row h-100 g-0 align-items-center">

            <div class="col-12 col-lg-6 d-flex flex-column justify-content-between h-100 pe-lg-4">

                <header class="d-flex align-items-center gap-1">
                    <img src="{{ asset('images/Piketin_logo.png') }}" alt="Piketin Logo" style="height: 38px;"
                        class="object-fit-contain">
                    <span class="fs-4 fw-bold text-dark"
                        style="font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.5px;">IKETIN</span>
                </header>

                <main class="w-100 my-auto mx-auto" style="max-width: 420px;">
                    <div class="text-center mb-4">
                        <h1 class="fw-bold text-dark mb-2" style="font-size: 2.5rem; letter-spacing: -0.5px;">Selamat
                            Datang</h1>
                        <p class="text-secondary">Masukkan Email dan Password untuk mendaftar</p>
                    </div>

                    <form action="{{ route('register.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="username"
                                class="form-label fw-semibold text-dark small mb-1 d-flex align-items-center gap-2">
                                <i class="bi bi-person text-dark fs-6"></i> Username
                            </label>
                            <input type="text" id="username" name="username" class="form-control custom-input @error('username') is-invalid @enderror"
                                placeholder="Masukkan Username" autocomplete="off" value="{{ old('username') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email"
                                class="form-label fw-semibold text-dark small mb-1 d-flex align-items-center gap-2">
                                <i class="bi bi-envelope text-dark fs-6"></i> Email
                            </label>
                            <input type="email" id="email" name="email" class="form-control custom-input @error('email') is-invalid @enderror"
                                placeholder="Masukkan Email" autocomplete="off" value="{{ old('email') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="password"
                                class="form-label fw-semibold text-dark small mb-1 d-flex align-items-center gap-2">
                                <i class="bi bi-lock text-dark fs-6"></i> Password
                            </label>
                            <div class="position-relative">
                                <input type="password" id="password" name="password" class="form-control custom-input pe-5 @error('password') is-invalid @enderror"
                                    placeholder="Masukkan Password" autocomplete="off" value="{{ old('password') }}" required>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation"
                                class="form-label fw-semibold text-dark small mb-1 d-flex align-items-center gap-2">
                                <i class="bi bi-lock text-dark fs-6"></i> Konfirmasi Password
                            </label>
                            <div class="position-relative">
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control custom-input pe-5 @error('password_confirmation') is-invalid @enderror"
                                    placeholder="Konfirmasi Password" autocomplete="off" value="{{ old('password_confirmation') }}" required>
                            </div>
                            @error('password_confirmation')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="token"
                                class="form-label fw-semibold text-dark small mb-1 d-flex align-items-center gap-2">
                                <i class="bi bi-card-text text-dark fs-6"></i> Token
                            </label>
                            <input type="text" id="token" name="token" class="form-control custom-input @error('token') is-invalid @enderror"
                                placeholder="Masukkan Token" autocomplete="off" value="{{ old('token') }}" required>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4 pt-1">
                            <div class="form-check d-flex align-items-center gap-2 m-0 p-0">
                                <input type="checkbox" class="form-check-input custom-checkbox m-0" id="privacy" required>
                                <label class="form-check-label text-dark fw-medium" for="privacy"
                                    style="font-size: 0.78rem;">
                                    Menyetujui Kebijakan dan Privasi
                                </label>
                            </div>
                            <a href="#" class="text-decoration-none fw-bold text-green-brand"
                                style="font-size: 0.78rem;">Butuh Bantuan?</a>
                        </div>

                        <button type="submit" class="btn btn-success w-100 mb-3">
                            Daftar
                        </button>
                    </form>

                    <div class="text-center text-dark fw-medium" style="font-size: 0.85rem;">
                        Sudah mempunyai akun? <a href="{{ route('login') }}"
                            class="fw-bold text-decoration-none text-green-brand">Login</a>
                    </div>
                </main>

                <footer class="d-flex justify-content-between align-items-center text-secondary" style="font-size: 0.8rem;">
                    <span class="opacity-75">Copyright © 2026 Piketin All rights reserved.</span>
                    <a href="#" class="text-secondary text-decoration-none fw-bold opacity-75">Privacy Policy</a>
                </footer>

            </div>

            <div class="col-lg-6 d-none d-lg-block">
                <div class="banner-card">
                    <div>
                        <h1 class="text-white mt-5 fw-normal mb-3" style="font-size: 3rem; line-height: 1.25;">
                            Digitalisasi manajemen piket kelas anda
                        </h1>
                        <p class="text-white opacity-90 fs-5 fw-light">
                            Masuk untuk akses dasbor dan atur operasional piket
                        </p>
                    </div>
                    <div class="text-center my-auto">
                        <img src="{{ asset('images/cover_auth.png') }}" alt="Cover Auth" class="img-fluid"
                            style="max-width: 700px; width: auto; object-fit: contain;">
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
