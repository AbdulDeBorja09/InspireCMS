<nav class="navbar navbar-expand-lg fixed-top p-md-3">
    <div class="container">
        <!-- ISA LOGO -->
        <a class="navbar-brand" href="{{url('/')}}">
            @if ($navLogo)
            <img src="{{ asset($navLogo->value) }}" class="img-fluid" alt="Logo" width="180" />
            @else
            <img src=" {{asset('images/logo/inspire-logo.png')}}" alt="Inspire Sports Academy" width="180" />
            @endif
        </a>

        <!-- BURGER FOR MOBILE -->
        <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-menu-button-wide"></i>
        </button>

        <!-- NAVBAR TABS -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav d-flex align-items-center gap-5">
                <!-- SERVICES DROPDOWN -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="servicesDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Services
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="servicesDropdown">
                        <li>
                            <a class="dropdown-item" href="{{url('/Facilities')}}">Facilities</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{url('/Academies')}}">Academies</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/Articles')}}">Articles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/Faqs')}}">FAQ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/About')}}">About</a>
                </li>

                <!-- USER ICON DROPDOWN -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        @auth
                        <li><a class="dropdown-item" href="{{url('/Profile')}}">Profile</a></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                        @else
                        <li><a class="dropdown-item" href="{{url('/login')}}">Log In</a></li>
                        <li>
                            <a class="dropdown-item" href="{{url('/register')}}">Create an Account</a>
                        </li>
                        @endauth

                    </ul>
                </li>

                <a href="{{url('/Quotation')}}" class="btn shadow-none quote-btn" type="button">
                    Request a Quote
                </a>
            </ul>
        </div>
    </div>
</nav>