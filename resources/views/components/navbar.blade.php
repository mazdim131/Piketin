<nav class="container navbar mt-3 p-1 rounded-3 navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('images/Piketin_logo.png') }}" alt="logo Piketin" style="height: 40px">
            iketin
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav d-flex mx-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-center" href="#">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-center" href="#">Tentang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-center" href="#">Jadwal</a>
                </li>
            </ul>
            <form class="d-flex gap-2" role="search">
                @if (Auth::check())
                    <a class="btn btn-danger btn-logout rounded-3 mx-auto">
                        <i class="bi bi-box-arrow-right"></i>
                        Keluar
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-success">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-secondary">Daftar</a>
                @endif
            </form>
        </div>
    </div>
</nav>
