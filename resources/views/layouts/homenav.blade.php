<nav id="homenav" class="navbar navbar-expand-lg navbar-light bg-white fixed-top navbar-custom">
    <div class="container">
        <!-- Logo and Brand Name -->
        <a href="{{ route('homepage') }}" class="navbar-brand d-flex align-items-center navbarbrand-logo">
            <x-application-logo width="200" height="80" />
        </a>

        <!-- Toggler Button -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav mx-auto text-center">
                <!-- Other navigation links -->
                <li class="nav-item px-2 py-2 navitem-custom">
                    <a class="nav-link text-uppercase text-dark navlink-custom" href="{{ request()->is('/') ? '' : '/' }}#home">Home</a>
                </li>
                <li class="nav-item px-2 py-2 navitem-custom">
                    <a class="nav-link text-uppercase text-dark navlink-custom" href="{{ request()->is('/') ? '' : '/' }}#units">Units</a>
                </li>
                <li class="nav-item px-2 py-2 navitem-custom">
                    <a class="nav-link text-uppercase text-dark navlink-custom" href="{{ request()->is('/') ? '' : '/' }}#gallery">Gallery</a>
                </li>
                <li class="nav-item px-2 py-2 navitem-custom">
                    <a class="nav-link text-uppercase text-dark navlink-custom " href="{{ request()->is('/') ? '' : '/' }}#aboutus">About</a>
                </li>
            </ul>
            
            @if (Route::has('login'))
                <ul class="navbar-nav text-center">
                    @auth
                        <li class="nav-item">
                            <a
                                href="
                                    @if (Auth::user()->usertype == 'customer')
                                        {{ route('customerdashboard') }}
                                    @else
                                        {{ route('managerdashboard') }}
                                    @endif
                                "
                                class="btn btn-blackbean fs-5 fw-medium px-4 rounded-0"
                            >
                                Dashboard
                            </a>
                        </li>
                    @else
                        <li class="nav-item p-2 text-center">
                            <a
                                href="{{ route('login') }}"
                                class="btn btn-blackbean me-2 px-4 py-2 fw-medium rounded-0"
                            >
                                Log in
                            </a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item p-2 text-center">
                                <a
                                    href="{{ route('register') }}"
                                    class="btn btn-blackbean px-4 py-2 fw-medium rounded-0"
                                >
                                    Register
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>
            @endif

        </div>
    </div>
</nav>
