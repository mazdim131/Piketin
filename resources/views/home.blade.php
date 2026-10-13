@extends('layouts.app')

@section('content')
    <div class="container py-4">

        {{-- alert --}}
        @if (Session::get('success'))
            <div class="alert alert-important alert-success alert-dismissible" role="alert">
                <div class="d-flex gap-3">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M5 12l5 5l10 -10"></path>
                        </svg>
                    </div>
                    <div>{{ Session::get('success') }}</div>
                </div>
                <a class="btn-close btn-close-black" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        @endif

        @if (Session::get('error'))
            <div class="alert alert-important alert-danger alert-dismissible" role="alert">
                <div class="d-flex gap-3">
                    <div>
                        <i class="bi bi-x-circle"></i>
                    </div>
                    <div>{{ Session::get('error') }}</div>
                </div>
                <a class="btn-close btn-close-black" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        @endif


        <!-- Section 1: Ringkasan Kehadiran -->
        <div class="row g-4 mb-4">
            <!-- Card Jumlah Kehadiran (Hijau) -->
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm p-3 p-md-4 rounded-5 text-white h-100"
                    style="background-color: #039855;">
                    <div class="row h-100 align-items-center">
                        <div class="col-7 d-flex flex-column justify-content-between h-100">
                            <div>
                                <h2 class="fw-bold mb-0" style="max-width: 170px">Hadir Piket</h2>
                                <div class="display-1 fw-bold my-2" style="font-size: 5rem;">4</div>
                            </div>
                            <p class="small opacity-75 mb-0">Total siswa hadir piket hari ini</p>
                        </div>
                        <div class="col-5 text-end d-flex flex-column justify-content-between align-items-end h-100">
                            <img src="{{ asset('images/Piketin_maskot3.png') }}" alt="Piko" class="img-fluid"
                                style="max-height: 200px;">
                            <button
                                class="btn btn-warning text-dark fw-bold rounded-4 px-3 py-2 w-100 d-flex align-items-center justify-content-center gap-2 mt-3"
                                style="background-color: #FFEE00; border: none;" data-bs-toggle="modal"
                                data-bs-target="#modalAbsensi">
                                <i class="bi bi-wallet2 fs-5"></i> Absen Piket
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Jumlah Ketidakhadiran (Biru Muda) -->
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm p-3 p-md-4 rounded-5 h-100" style="background-color: #F2F7FB;">
                    <div class="row h-100 align-items-center">
                        <div class="col-7 d-flex flex-column justify-content-between h-100">
                            <div>
                                <h2 class="fw-bold text-dark mb-0">Tidak Hadir Piket</h2>
                                <div class="display-1 fw-bold my-2 text-dark" style="font-size: 5rem;">2</div>
                            </div>
                            <p class="small text-muted mb-0">Total siswa tidak hadir piket hari ini</p>
                        </div>
                        <div class="col-5 text-end d-flex flex-column justify-content-between align-items-end h-100">
                            <img src="{{ asset('images/Piketin_maskot3.png') }}" alt="Piko" class="img-fluid"
                                style="max-height: 200px;">
                            <button
                                class="btn btn-warning text-dark fw-bold rounded-4 px-3 py-2 w-100 d-flex align-items-center justify-content-center gap-2 mt-3"
                                style="background-color: #FFEE00; border: none;" data-bs-toggle="modal"
                                data-bs-target="#modalTidakHadir">
                                <i class="bi bi-person-fill fs-5"></i> Kehadiran
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Kondisi Keuangan -->
        <div class="mb-4">
            <h3 class="fw-bold text-dark mb-3">Kondisi Keuangan</h3>
            <div class="row g-3">

                @if (Auth::check() && Auth::user()->role == 'admin')
                    <!-- Card 1: Uang Kas Terkumpul -->
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="card border border-light-subtle rounded-4 p-3 bg-white h-100">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-3 d-flex align-items-center justify-content-center text-white flex-shrink-0"
                                    style="width: 48px; height: 48px; background-color: #039855;">
                                    <i class="bi bi-wallet2 fs-4"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark fs-5">Rp. 200.000</div>
                                    <small class="text-muted">Pemasukkan Uang</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Uang Kas Dikeluarkan -->
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="card border border-light-subtle rounded-4 p-3 bg-white h-100">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-3 d-flex align-items-center justify-content-center text-white flex-shrink-0"
                                    style="width: 48px; height: 48px; background-color: #E53E3E;">
                                    <i class="bi bi-credit-card-2-front fs-4"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark fs-5">- Rp. 2.000</div>
                                    <small class="text-muted">Pengeluaran Uang</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: Siswa Iuran Kas -->
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="card border border-light-subtle rounded-4 p-3 bg-white h-100">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-3 d-flex align-items-center justify-content-center text-white flex-shrink-0"
                                    style="width: 48px; height: 48px; background-color: #039855;">
                                    <i class="bi bi-people-fill fs-4"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark fs-5">23+</div>
                                    <small class="text-muted">Siswa iuran kas</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4: Siswa Belum Iuran -->
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="card border border-light-subtle rounded-4 p-3 bg-white h-100">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-3 d-flex align-items-center justify-content-center text-white flex-shrink-0"
                                    style="width: 48px; height: 48px; background-color: #E53E3E;">
                                    <i class="bi bi-person-exclamation fs-4"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark fs-5">6</div>
                                    <small class="text-muted">Siswa belum iuran</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Card 1: Uang Kas Terkumpul -->
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="card border border-light-subtle rounded-4 p-3 bg-white h-100">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-3 d-flex align-items-center justify-content-center text-white flex-shrink-0"
                                    style="width: 48px; height: 48px; background-color: #039855;">
                                    <i class="bi bi-wallet2 fs-4"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark fs-5">Rp. 200.000</div>
                                    <small class="text-muted">Uang kas terkumpul</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Uang Kas Dikeluarkan -->
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="card border border-light-subtle rounded-4 p-3 bg-white h-100">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-3 d-flex align-items-center justify-content-center text-white flex-shrink-0"
                                    style="width: 48px; height: 48px; background-color: #E53E3E;">
                                    <i class="bi bi-credit-card-2-front fs-4"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark fs-5">- Rp. 2.000</div>
                                    <small class="text-muted">Uang kas Dikeluarkan</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: Siswa Iuran Kas -->
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="card border border-light-subtle rounded-4 p-3 bg-white h-100">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-3 d-flex align-items-center justify-content-center text-white flex-shrink-0"
                                    style="width: 48px; height: 48px; background-color: #039855;">
                                    <i class="bi bi-people-fill fs-4"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark fs-5">23+</div>
                                    <small class="text-muted">Siswa iuran kas</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4: Siswa Belum Iuran -->
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="card border border-light-subtle rounded-4 p-3 bg-white h-100">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-3 d-flex align-items-center justify-content-center text-white flex-shrink-0"
                                    style="width: 48px; height: 48px; background-color: #E53E3E;">
                                    <i class="bi bi-person-exclamation fs-4"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark fs-5">6</div>
                                    <small class="text-muted">Siswa belum iuran</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>

        <!-- Section 3: Fitur Lainnya -->
        <div class="mb-4">
            <h3 class="fw-bold text-dark mb-3">Fitur Lainnya</h3>
            <div class="row g-4">
                @if (Auth::check() && Auth::user()->role == 'admin')
                    <!-- Fitur 1: Pendataan -->
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card border border-light-subtle rounded-4 p-3 bg-white h-100 position-relative">
                            <a href="{{ route('set_job') }}" class="text-decoration-none">
                                <div class="card-body p-0 d-flex flex-column justify-content-between h-100">
                                    <div>
                                        <h4 class="fw-bold text-dark mb-1">Pendataan</h4>
                                        <p class="text-muted small">Pendataan tugas piket masing-masing siswa</p>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <img src="{{ asset('images/Piketin_maskot2.png') }}" alt="Piko"
                                            class="img-fluid" style="max-height: 150px;">
                                        <a href="#"
                                            class="btn rounded-3 d-flex align-items-center justify-content-center text-white p-2"
                                            style="background-color: #039855; width: 44px; height: 44px;">
                                            <i class="bi bi-exclamation-lg fs-4"></i>
                                        </a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Fitur 2: Konfirmasi -->
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card border border-light-subtle rounded-4 p-3 bg-white h-100 position-relative">
                            <a href="{{ route('confirmation') }}" class="text-decoration-none">
                                <div class="card-body p-0 d-flex flex-column justify-content-between h-100">
                                    <div>
                                        <h4 class="fw-bold text-dark mb-1">Konfirmasi</h4>
                                        <p class="text-muted small">Konfirmasi setiap kehadiran piket kelas</p>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <img src="{{ asset('images/Piketin_maskot2.png') }}" alt="Piko"
                                            class="img-fluid" style="max-height: 150px;">
                                        <a href="#"
                                            class="btn rounded-3 d-flex align-items-center justify-content-center text-white p-2"
                                            style="background-color: #039855; width: 44px; height: 44px;">
                                            <i class="bi bi-people-fill fs-5"></i>
                                        </a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Fitur 3: Kas Kelas -->
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card border border-light-subtle rounded-4 p-3 bg-white h-100 position-relative">
                            <a href="{{ route('kas') }}" class="text-decoration-none">
                                <div class="card-body p-0 d-flex flex-column justify-content-between h-100">
                                    <div>
                                        <h4 class="fw-bold text-dark mb-1">Kas Kelas</h4>
                                        <p class="text-muted small">Data kas rutin kelas</p>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <img src="{{ asset('images/Piketin_maskot2.png') }}" alt="Piko"
                                            class="img-fluid" style="max-height: 150px;">
                                        <a href="#"
                                            class="btn rounded-3 d-flex align-items-center justify-content-center text-white p-2"
                                            style="background-color: #039855; width: 44px; height: 44px;">
                                            <i class="bi bi-hourglass-split fs-5"></i>
                                        </a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Fitur 4: Riwayat Kas -->
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card border border-light-subtle rounded-4 p-3 bg-white h-100 position-relative">
                            <a href="{{ route('historyKas') }}" class="text-decoration-none">
                                <div class="card-body p-0 d-flex flex-column justify-content-between h-100">
                                    <div>
                                        <h4 class="fw-bold text-dark mb-1">Riwayat Kas</h4>
                                        <p class="text-muted small">Pantau setiap riwayat pemasukan dan pengeluaran kas</p>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <img src="{{ asset('images/Piketin_maskot2.png') }}" alt="Piko"
                                            class="img-fluid" style="max-height: 150px;">
                                        <a href="#"
                                            class="btn rounded-3 d-flex align-items-center justify-content-center text-white p-2"
                                            style="background-color: #039855; width: 44px; height: 44px;">
                                            <i class="bi bi-calendar-event fs-5"></i>
                                        </a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @else
                    {{-- Fitur 1: Peringatan --}}
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card border border-light-subtle rounded-4 p-3 bg-white h-100 position-relative">
                            <a href="{{ route('warningLog') }}" class="text-decoration-none">
                                <div class="card-body p-0 d-flex flex-column justify-content-between h-100">
                                    <div>
                                        <h4 class="fw-bold text-dark mb-1">Peringatan</h4>
                                        <p class="text-muted small">Pantau jumlah peringatan tidak hadir piket</p>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <img src="{{ asset('images/Piketin_maskot2.png') }}" alt="Piko"
                                            class="img-fluid" style="max-height: 150px;">
                                        <a href="#"
                                            class="btn rounded-3 d-flex align-items-center justify-content-center text-white p-2"
                                            style="background-color: #039855; width: 44px; height: 44px;">
                                            <i class="bi bi-exclamation-lg fs-4"></i>
                                        </a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Fitur 2: Bayar Kas -->
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card border border-light-subtle rounded-4 p-3 bg-white h-100 position-relative">
                            <a href="{{ route('payKas') }}" class="text-decoration-none">
                                <div class="card-body p-0 d-flex flex-column justify-content-between h-100">
                                    <div>
                                        <h4 class="fw-bold text-dark mb-1">Bayar Kas</h4>
                                        <p class="text-muted small">Data pembayaran uang kas kelas</p>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <img src="{{ asset('images/Piketin_maskot2.png') }}" alt="Piko"
                                            class="img-fluid" style="max-height: 150px;">
                                        <a href="#"
                                            class="btn rounded-3 d-flex align-items-center justify-content-center text-white p-2"
                                            style="background-color: #039855; width: 44px; height: 44px;">
                                            <i class="bi bi-people-fill fs-5"></i>
                                        </a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Fitur 3: Riwayat Piket -->
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card border border-light-subtle rounded-4 p-3 bg-white h-100 position-relative">
                            <a href="{{ route('piketLog') }}" class="text-decoration-none">
                                <div class="card-body p-0 d-flex flex-column justify-content-between h-100">
                                    <div>
                                        <h4 class="fw-bold text-dark mb-1">Riwayat Piket</h4>
                                        <p class="text-muted small">Pantau Kapan terakhir kali anda piket kelas</p>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <img src="{{ asset('images/Piketin_maskot2.png') }}" alt="Piko"
                                            class="img-fluid" style="max-height: 150px;">
                                        <a href="#"
                                            class="btn rounded-3 d-flex align-items-center justify-content-center text-white p-2"
                                            style="background-color: #039855; width: 44px; height: 44px;">
                                            <i class="bi bi-hourglass-split fs-5"></i>
                                        </a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Fitur 4: Jadwal Piket -->
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card border border-light-subtle rounded-4 p-3 bg-white h-100 position-relative">
                            <a href="{{ route('schedulePiket') }}" class="text-decoration-none">
                                <div class="card-body p-0 d-flex flex-column justify-content-between h-100">
                                    <div>
                                        <h4 class="fw-bold text-dark mb-1">Jadwal Piket</h4>
                                        <p class="text-muted small">Lihat jadwal piket kelas</p>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <img src="{{ asset('images/Piketin_maskot2.png') }}" alt="Piko"
                                            class="img-fluid" style="max-height: 150px;">
                                        <a href="#"
                                            class="btn rounded-3 d-flex align-items-center justify-content-center text-white p-2"
                                            style="background-color: #039855; width: 44px; height: 44px;">
                                            <i class="bi bi-calendar-event fs-5"></i>
                                        </a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endif

            </div>
        </div>

    </div>

    {{-- modal absensi piket --}}
    <div class="modal fade" id="modalAbsensi" tabindex="-1" aria-labelledby="modalAbsensiLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 520px;">
            <div class="modal-content border-0 p-4"
                style="border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">

                <!-- Modal Header (Tombol Close) -->
                <div class="d-flex justify-content-end mb-2">
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"
                        style="font-size: 0.9rem;"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body p-0">
                    <!-- User Profile Section -->
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <!-- Avatar Circle Icon -->
                        <div class="d-flex align-items-center justify-content-center bg-secondary-subtle rounded-circle flex-shrink-0"
                            style="width: 70px; height: 70px;">
                            <i class="bi bi-person-fill text-dark" style="font-size: 2.5rem;"></i>
                        </div>
                        <!-- User Info -->
                        <div>
                            <h4 class="fw-bold text-dark mb-1" style="font-size: 1.5rem; letter-spacing: -0.3px;">
                                Dimas Hadi Syandana</h4>
                            <p class="text-secondary mb-0 fw-medium" style="font-size: 1rem;">Cicurug 4 <span
                                    class="mx-1">|</span> PPLG XI-3</p>
                        </div>
                    </div>

                    <!-- Form Absensi -->
                    <form action="#" method="POST">
                        @csrf

                        <!-- Lupa Password Link (Rata Kanan Atas Input) -->
                        <div class="d-flex justify-content-end mb-1">
                            <a href="#" class="text-decoration-none fw-bold text-dark"
                                style="font-size: 0.8rem;">Lupa Password?</a>
                        </div>

                        <!-- Input Password -->
                        <div class="mb-3">
                            <input type="password" name="password" class="form-control py-2 px-3 border-secondary-subtle"
                                placeholder="Masukkan Password"
                                style="border-radius: 10px; font-size: 0.9rem; color: #555;" required>
                        </div>

                        <!-- Checkbox Konfirmasi -->
                        <div class="form-check d-flex align-items-start gap-2 mb-4">
                            <input class="form-check-input mt-1 flex-shrink-0" type="checkbox" id="checkPiket"
                                style="border-color: #ccc; cursor: pointer;" required>
                            <label class="form-check-label text-dark fw-medium" for="checkPiket"
                                style="font-size: 0.78rem; line-height: 1.35; cursor: pointer;">
                                Saya menyatakan sudah melaksanakan piket dengan penuh tanggung jawab dan jujur
                            </label>
                        </div>

                        <!-- Submit Button Hijau -->
                        <button type="submit" class="btn w-100 py-2.5 text-white fw-medium border-0"
                            style="background-color: #059669; border-radius: 10px; font-size: 0.95rem; transition: background 0.2s;"
                            onmouseover="this.style.backgroundColor='#047857'"
                            onmouseout="this.style.backgroundColor='#059669'">
                            Kirim Absensi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- modal tidak hadir piket --}}
    <div class="modal fade" id="modalTidakHadir" tabindex="-1" aria-labelledby="modalTidakHadirLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 520px;">
            <div class="modal-content border-0 p-4"
                style="border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">

                <!-- Modal Header (Tombol Close) -->
                <div class="d-flex mb-2">
                    <p><b>{{ now()->translatedFormat('l, d F Y') }}</b> | {{ now()->format('H:i') }}</p>

                    <button type="button" class="btn-close d-flex ms-auto shadow-none" data-bs-dismiss="modal"
                        aria-label="Close" style="font-size: 0.9rem;"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body p-0">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-3">
                                <i class="bi bi-person-circle fs-1"></i>

                                <div>
                                    <b>Dimas Hadi Syandana</b>
                                    <p class="mb-0">Menyapu</p>
                                </div>

                                <div class="ms-auto">
                                    @if (Auth::check() && Auth::user()->role == 'admin')
                                        <button type="button" class="btn btn-success btn-sm" name="btn-confirmation"><i
                                                class="bi bi-check-lg me-1"></i> Konfirmasi</button>
                                    @else
                                        <button class="btn btn-danger btn-sm">Belum Mengerjakan</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
