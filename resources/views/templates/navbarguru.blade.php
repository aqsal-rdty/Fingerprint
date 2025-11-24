<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    #sidebar {
        width: 240px;
        height: calc(100vh - 56px);
        margin-top: 56px;
        overflow-y: hidden;
        transition: all 0.3s ease;
    }

    #sidebar:hover {
        overflow-y: auto;
    }

    #sidebar::-webkit-scrollbar {
        width: 8px;
    }

    #sidebar::-webkit-scrollbar-thumb {
        background-color: rgba(0, 123, 255, 0.2);
        border-radius: 4px;
    }

    .nav-link {
        transition: all 0.2s ease;
    }

    .nav-link:hover {
        background-color: rgba(59, 130, 246, 0.1);
        border-radius: 6px;
        font-weight: 600;
    }

    .nav-link.active {
        color: #0d6efd !important;
        font-weight: 700;
    }

    .btn-login {
        background: #3B82F6;
        font-weight: 600;
    }
    .btn-login:hover {
        background: #2563EB;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow-sm" style="background-color: #3B82F6;">
    <div class="container-fluid">
        <button class="btn btn-outline-light me-3" id="toggleSidebar">
            <i class="bi bi-list"></i>
        </button>
        <a class="navbar-brand fw-bold fs-4" href="{{ route('guru.dashboard') }}">SIM Absensi</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="topNavbar">
            <ul class="navbar-nav mb-2 mb-lg-0 align-items-center">
                <li class="nav-item me-3 text-white">
                    <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->username ?? 'Guru' }}
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="d-flex">
    <nav id="sidebar" class="bg-light border-end position-fixed shadow-sm text-start">
        <div class="w-100" style="
            background-image: url('{{ asset('img/nav.png') }}');
            background-size: cover;
            background-position: center;
            height: 100px;">
        </div>

        <div class="mt-4 mb-3 text-center">
            <h1 id="timeDisplay" style="font-size: 64px; color: #8c8c8c;">12:34</h1>
            <p id="dateDisplay" class="text-muted">Senin, 20 Oktober 2025</p>
        </div>

        <div class="p-3">
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link d-flex align-items-center {{ request()->routeIs('guru.kehadiran') ? 'active text-primary fw-bold' : 'text-dark' }}" href="{{ route('guru.kehadiran') }}">
                        <i class="bi bi-house-door me-2 fs-5"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a class="nav-link d-flex align-items-center {{ request()->routeIs('guru.rekapbulanan') ? 'active text-primary fw-bold' : 'text-dark' }}" href="{{ route('guru.rekapbulanan') }}">
                        <i class="bi bi-calendar-check me-2 fs-5"></i> Rekap Bulanan
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a class="nav-link d-flex align-items-center {{ request()->routeIs('guru.detail_rekapsemua') ? 'active text-primary fw-bold' : 'text-dark' }}" href="{{ route('guru.detail_rekapsemua') }}">
                        <i class="bi bi-card-list me-2 fs-5"></i> Rekap Semua
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->routeIs('guru.rekapabsensi') ? 'active text-primary fw-bold' : 'text-dark' }}" href="{{ route('guru.rekapabsensi') }}">
                        <i class="bi bi-clock-history me-2 fs-5"></i> Rekap Absensi
                    </a>
                </li>
                <li class="nav-item mt-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link text-dark d-flex align-items-center border-0 bg-transparent w-100">
                            <i class="bi bi-box-arrow-in-right me-2 fs-5"></i> Login
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <div id="mainContent" class="flex-grow-1" style="margin-left: 240px; margin-top: 56px; transition: all 0.3s;">
        @yield('content')
    </div>
</div>

<script>
    function updateTime() {
        const now = new Date();
        const hours = now.getHours().toString().padStart(2,'0');
        const minutes = now.getMinutes().toString().padStart(2,'0');
        document.getElementById('timeDisplay').textContent = `${hours}:${minutes}`;

        const options = { weekday:'long', year:'numeric', month:'long', day:'numeric' };
        document.getElementById('dateDisplay').textContent = now.toLocaleDateString('id-ID', options);
    }
    setInterval(updateTime, 1000);
    updateTime();

    document.getElementById('toggleSidebar').addEventListener('click', function() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        if(sidebar.style.marginLeft === '-240px'){
            sidebar.style.marginLeft = '0';
            mainContent.style.marginLeft = '240px';
        } else {
            sidebar.style.marginLeft = '-240px';
            mainContent.style.marginLeft = '0';
        }
    });
</script>