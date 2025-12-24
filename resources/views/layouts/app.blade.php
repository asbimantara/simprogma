<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMPROGMA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @stack('styles')
</head>

<body>
    @if ((request()->is('/') || request()->is('register')) && !auth()->check())
        <nav class="navbar navbar-expand-lg"
            style="background: linear-gradient(90deg, #26c6da 0%, #43e97b 100%); border-bottom: 2px solid #b2dfdb; box-shadow: 0 2px 12px 0 rgba(44,62,80,0.07); border-radius:0 0 18px 18px;">
            <div class="container justify-content-center">
                <a class="navbar-brand d-flex align-items-center" href="/"
                    style="font-weight:700; font-size:1.35rem; color:#00897b;">
                    <i class="fas fa-project-diagram me-2" style="font-size:1.5rem; color:#00897b;"></i> SIMPROGMA
                </a>
            </div>
        </nav>
    @endif
    @if (!request()->is('/') && !request()->is('register'))
        <nav class="navbar navbar-expand-lg"
            style="background: linear-gradient(90deg, #26c6da 0%, #43e97b 100%); border-bottom: 2px solid #b2dfdb; box-shadow: 0 2px 12px 0 rgba(44,62,80,0.07); border-radius:0 0 18px 18px;">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="/"
                    style="font-weight:700; font-size:1.35rem; color:#00897b;">
                    <i class="fas fa-project-diagram me-2" style="font-size:1.5rem; color:#00897b;"></i> SIMPROGMA
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="/dashboard"
                                    style="font-weight:600; border-radius:8px; transition:background 0.2s;">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/progja"
                                    style="font-weight:600; border-radius:8px; transition:background 0.2s;">Progja</a>
                            </li>
                            @if(auth()->check() && auth()->user()->role === 'admin')
                                <li class="nav-item">
                                    <a class="nav-link" href="/ormawa"
                                        style="font-weight:600; border-radius:8px; transition:background 0.2s;">Ormawa</a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <form action="/logout" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-link nav-link" type="submit"
                                        style="font-weight:600; color:#d32f2f; border-radius:8px;">Logout</button>
                                </form>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="/login"
                                    style="font-weight:600; border-radius:8px; transition:background 0.2s;">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/register"
                                    style="font-weight:600; border-radius:8px; transition:background 0.2s;">Register</a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
        <style>
            .navbar-nav .nav-link:hover {
                background: #e0f7fa;
                color: #00897b !important;
            }

            .navbar {
                margin-bottom: 0.5rem;
            }
        </style>
    @endif
    <main>
        @yield('content')
    </main>
    <footer class="text-center py-4 mt-5" style="background:rgba(0,0,0,0.03); color:#00897b; font-size:1.05em;">
        <div>
            &copy; {{ date('Y') }} <b>SIMPROGMA</b> — Sistem Informasi Manajemen Program Kerja Ormawa UNISNU Jepara.<br>
            Dikembangkan untuk kebutuhan internal kampus.
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>