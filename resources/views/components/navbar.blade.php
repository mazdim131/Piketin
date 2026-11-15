<nav class="piketin-navbar container">
    <div class="container">
        <div class="piketin-navbar-inner">
        <a href="{{ route('home') }}" class="piketin-logo">
            <span class="logo-p"><img src="{{ asset('images/Piketin_logo.png') }}" alt=""></span>
            <span class="logo-text">IKETIN</span>
        </a>

        <ul class="piketin-menu">
            <li>
                <a href="{{ route('home') }}"
                   class="piketin-menu-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    Beranda
                </a>
            </li>
            <li>
                <a href="{{ route('about') }}"
                   class="piketin-menu-link {{ request()->routeIs('about') ? 'active' : '' }}">
                    Tentang
                </a>
            </li>
            <li>
                <a href="{{ route('piketSchedule.index') }}"
                   class="piketin-menu-link {{ request()->routeIs('piketSchedule.*') ? 'active' : '' }}">
                    Jadwal
                </a>
            </li>
        </ul>

        <div class="piketin-auth">

            {{-- profile --}}
            <div class="piketin-profile">
                @if (Auth::check())
                    <a href="{{ route('profile') }}" class="navbar-profile-avatar" title="Profil">
                        <i class="bi bi-person-circle"></i>
                    </a>
                @else
                    <span class="navbar-profile-avatar guest">
                        <i class="bi bi-person"></i>
                    </span>
                @endif
            </div>

            @if (Auth::check())
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Log out</span>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-login">Masuk</a>
                <a href="{{ route('register') }}" class="btn-register">Daftar</a>
            @endif
        </div>

        <button class="piketin-hamburger" type="button" data-bs-toggle="collapse"
            data-bs-target="#piketinMobileMenu" aria-controls="piketinMobileMenu"
            aria-expanded="false" aria-label="Toggle navigation">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>

    <div class="piketin-mobile-menu collapse" id="piketinMobileMenu">
        <a href="{{ route('home') }}" class="piketin-mobile-link">Beranda</a>
        <a href="{{ route('about') }}" class="piketin-mobile-link">Tentang</a>
        <a href="{{ route('piketSchedule.index') }}" class="piketin-mobile-link">Jadwal</a>

        @if (Auth::check())
            <form action="{{ route('logout') }}" method="POST" class="piketin-mobile-logout">
                @csrf
                <button type="submit" class="btn-logout w-100">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Log out</span>
                </button>
            </form>
        @else
            <div class="piketin-mobile-auth">
                <a href="{{ route('login') }}" class="btn-login w-100 text-center">Masuk</a>
                <a href="{{ route('register') }}" class="btn-register w-100 text-center">Daftar</a>
            </div>
        @endif
    </div>
    </div>
</nav>
