<nav class="navbar sticky-top navbar-expand-lg bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Laravel Core</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" aria-current="page" href="/">Home</a>
                </li>
                @guest
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('login') ? 'active' : '' }}" href="{{ route('login') }}"><i class="fa-solid fa-user"></i> Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('register') ? 'active' : '' }}" href="{{ route('register') }}"><i class="fa-solid fa-right-to-bracket"></i> Register</a>
                    </li>
                @else
                    <li class="nav-item">
                        <span class="nav-link">Welcome, {{ auth()->user()->name }}</span>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf

                            <button class="nav-link" style="border: none; background: none"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
                        </form>
                    </li>
                @endguest
            </ul>
            <form action="/" class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>

