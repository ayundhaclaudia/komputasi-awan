<nav class="navbar navbar-expand-lg navbar-pink shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
            ByeBill
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#authNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="authNavbar">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                </li>

                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
                    <a href="{{ route('admin.users') }}">User</a>
                @endif



                <li class="nav-item">
                    <a class="nav-link" href="{{ route('profile.edit') }}">
                        Profil
                    </a>
                </li>

                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-pink btn-sm px-3">
                            Logout
                        </button>
                    </form>
                </li>

            </ul>
        </div>
    </div>
</nav>
