<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
    #sidebar {
        width: 240px;
        height: calc(100vh - 56px);
        margin-top: 56px;
        overflow-y: hidden;
        transition: all 0.3s;
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
</style>

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow-sm" style="background-color: #3B82F6;">
    <div class="container-fluid">
        <button class="btn btn-outline-light me-3" id="toggleSidebar">
            <i class="bi bi-list"></i>
        </button>
        <a class="navbar-brand fw-bold fs-4" href="{{ route('dashboard') }}">FingerPrint</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="topNavbar">
            <ul class="navbar-nav mb-2 mb-lg-0 align-items-center">
                <li class="nav-item me-3 text-white">
                    <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->username ?? 'Admin' }}
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">
                        <img src="{{ asset('img/wikrama.png') }}" class="rounded-circle me-1" width="30" height="30" alt="User">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Profil Saya</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

{{-- Sidebar --}}
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
            <p id="dateDisplay" class="text-muted">Tuesday, October 14th 2025</p>
        </div>

        <div class="p-3">
            <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a class="nav-link d-flex align-items-center {{ request()->routeIs('dashboard') ? 'active text-primary fw-bold' : 'text-dark' }}" href="{{ route('dashboard') }}">
                            <i class="bi bi-house-door me-2 fs-5"></i> Dashboard
                        </a>
                    </li>
                    {{-- <li class="nav-item mb-2">
                        <a class="nav-link d-flex align-items-center {{ request()->routeIs('laporan.*') ? 'active text-primary fw-bold' : 'text-dark' }}" href="{{ route('laporan.index') }}">
                            <i class="bi bi-briefcase me-2 fs-5"></i> Laporan
                        </a>
                    </li> --}}
                    {{-- <li class="nav-item mb-2">
                        <a class="nav-link d-flex align-items-center {{ request()->routeIs('master.*') ? 'active text-primary fw-bold' : 'text-dark' }}" href="{{ route('master.index') }}">
                            <i class="bi bi-pencil-square me-2 fs-5"></i> Master
                        </a>
                    </li> --}}
                    <li class="nav-item mb-2">
                        <a class="nav-link d-flex align-items-center {{ request()->routeIs('guru.*') ? 'active text-primary fw-bold' : 'text-dark' }}" href="{{ route('guru.index') }}">
                            <i class="bi bi-person-badge me-2 fs-5"></i> Guru
                        </a>
                    </li>
                    {{-- <li class="nav-item mb-2">
                        <a class="nav-link d-flex align-items-center {{ request()->routeIs('fingerprint.*') ? 'active text-primary fw-bold' : 'text-dark' }}" href="{{ route('fingerprint_index') }}">
                            <i class="bi bi-folder2-open me-2 fs-5"></i> Mesin Absen
                        </a>
                    </li> --}}
                    <!-- Tambahan Fingerprint Guru -->
                    <li class="nav-item mb-2">
                        <a class="nav-link d-flex align-items-center {{ request()->routeIs('fingerprintguru.*') ? 'active text-primary fw-bold' : 'text-dark' }}" href="{{ route('fingerprintguru_index') }}">
                            <i class="bi bi-folder2-open me-2 fs-5"></i> Mesin Absen Guru
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link d-flex align-items-center {{ request()->routeIs('keteranganguru.*') ? 'active text-primary fw-bold' : 'text-dark' }}" href="{{ route('keteranganguru.index') }}">
                            <i class="bi bi-card-text me-2 fs-5"></i> Keterangan Guru
                        </a>
                    </li>
                </ul>
            </ul>
        </div>
    </nav>

    {{-- Konten utama --}}
    <div id="mainContent" class="flex-grow-1" style="margin-left: 240px; margin-top: 56px; transition: all 0.3s;">
        @yield('content')
    </div>
</div>

<script>
    // Waktu real-time
    function updateTime() {
        const now = new Date();
        const hours = now.getHours().toString().padStart(2,'0');
        const minutes = now.getMinutes().toString().padStart(2,'0');
        document.getElementById('timeDisplay').textContent = `${hours}:${minutes}`;

        const options = { weekday:'long', year:'numeric', month:'long', day:'numeric' };
        document.getElementById('dateDisplay').textContent = now.toLocaleDateString('en-US', options);
    }
    setInterval(updateTime, 1000);
    updateTime();

    // Toggle Sidebar
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