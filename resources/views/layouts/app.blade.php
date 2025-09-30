<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Control System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            overflow-x: hidden;
            padding-top: 70px;
        }

        /* Header */
        .top-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 70px;
            background: linear-gradient(135deg, #3a3f47 0%, #2c3136 100%);
            color: white;
            z-index: 1050;
            border-bottom: 3px solid #1e2226;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 100%;
            padding: 0 20px;
            max-width: 100%;
        }

        .library-title {
            font-size: 22px;
            font-weight: bold;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            flex-shrink: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 50%;
        }

        .profile-section {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            background-color: rgba(50, 55, 60, 0.8);
            padding: 5px 15px;
            border-radius: 8px;
            text-decoration: none;
            color: white;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .profile-section:hover {
            background-color: rgba(50, 55, 60, 1);
            transform: translateY(-2px);
            color: white;
        }

        .profile-photo {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            object-fit: cover;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            text-align: right;
        }

        .profile-name {
            font-weight: bold;
            font-size: 15px;
            line-height: 1.2;
        }

        .profile-role {
            font-size: 11px;
            opacity: 0.9;
            font-style: italic;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 70px;
            left: 0;
            height: calc(100vh - 70px);
            width: 250px;
            background-color: #2c3136;
            padding-top: 1rem;
            overflow-y: auto;
            transition: all 0.3s ease;
            box-shadow: 2px 0 5px rgba(0,0,0,0.2);
        }

        .sidebar.hide {
            width: 60px;
            overflow: hidden;
        }

        .sidebar h4 {
            color: #fff;
            padding: 10px 15px;
            margin-bottom: 1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            font-size: 18px;
            border-bottom: 1px solid #1e2226;
        }

        .sidebar .menu-title {
            font-size: 11px;
            text-transform: uppercase;
            font-weight: bold;
            color: #adb5bd;
            padding: 12px 15px 8px;
            letter-spacing: 0.5px;
        }

        .sidebar .menu-title.hide {
            display: none;
        }

        .sidebar a, .sidebar button {
            color: #c2c7d0;
            text-decoration: none;
            padding: 12px 15px;
            display: flex;
            align-items: center;
            border-radius: 0;
            transition: all 0.2s ease;
            white-space: nowrap;
            border-left: 3px solid transparent;
        }

        .sidebar a:hover, .sidebar button:hover,
        .sidebar a.active, .sidebar button.active {
            background-color: #3a3f47;
            color: #fff;
            border-left: 3px solid #5c636a;
        }

        .sidebar a i, .sidebar button i {
            width: 20px;
            margin-right: 12px;
            text-align: center;
            font-size: 16px;
        }

        .sidebar.hide a, .sidebar.hide button {
            padding: 12px;
            justify-content: center;
        }

        .sidebar.hide a .text,
        .sidebar.hide button .text,
        .sidebar.hide h4 .text {
            display: none;
        }

        .sidebar.hide a i, .sidebar.hide button i {
            margin-right: 0;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .content.full {
            margin-left: 60px;
        }

        /* Button Logout */
        .sidebar button {
            background: none;
            border: none;
            width: 100%;
            text-align: left;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .library-title {
                font-size: 16px;
                max-width: 40%;
            }

            .profile-section {
                gap: 8px;
                padding: 5px 10px;
            }

            .profile-photo {
                width: 35px;
                height: 35px;
            }

            .profile-name {
                font-size: 13px;
            }

            .profile-role {
                font-size: 10px;
            }

            .sidebar {
                width: 60px;
            }

            .sidebar .menu-title,
            .sidebar a .text,
            .sidebar button .text,
            .sidebar h4 .text {
                display: none;
            }

            .sidebar a, .sidebar button {
                justify-content: center;
                padding: 12px;
            }

            .sidebar a i, .sidebar button i {
                margin-right: 0;
            }

            .content {
                margin-left: 60px;
            }
        }

        /* Scrollbar Sidebar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: #1e2226;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #3a3f47;
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: #5c636a;
        }
    </style>

    @stack('styles')
</head>
<body>
{{-- Header --}}
<div class="top-header">
    <div class="header-content">
        <h1 class="library-title">
            <i class="fas fa-book-reader me-2"></i>
            Bimantara Pustaka
        </h1>
        <a href="{{ route('profile.show') }}" class="profile-section">
            @if(Auth::user()->photo)
                <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Profile" class="profile-photo">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3a3f47&color=fff&size=45" alt="Profile" class="profile-photo">
            @endif
            <div class="profile-info">
                <div class="profile-name">
                    {{ Auth::user()->name ?? 'Administrator' }}
                </div>
                <div class="profile-role">
                    {{ Auth::user()->role ?? 'Admin Perpustakaan' }}
                </div>
            </div>
        </a>
    </div>
</div>

{{-- Sidebar --}}
<div class="sidebar" id="sidebar">
    <h4 id="toggleSidebar">
        <i class="fas fa-bars me-2"></i>
        <span class="text">Menu</span>
    </h4>

    <div class="menu-title">PERPUSTAKAAN</div>
    <a href="{{ route('dashboard') }}">
        <i class="fas fa-tachometer-alt"></i>
        <span class="text">Dashboard</span>
    </a>
    <a href="{{ route('books.index') }}">
        <i class="fas fa-book"></i>
        <span class="text">Daftar Buku</span>
    </a>
    <a href="{{ route('kategori.index') }}">
        <i class="fas fa-tags"></i>
        <span class="text">Kategori</span>
    </a>
    <a href="{{ route('subkategori.index') }}">
        <i class="fas fa-layer-group"></i>
        <span class="text">Subkategori</span>
    </a>
    <a href="{{ route('penerbit.index') }}">
        <i class="fas fa-building"></i>
        <span class="text">Penerbit</span>
    </a>
    <a href="{{ route('raks.index') }}">
        <i class="fas fa-archive"></i>
        <span class="text">Raks</span>
    </a>

    <div class="menu-title">SISTEM</div>
    <a href="{{ route('users.index') }}">
        <i class="fas fa-users-cog"></i>
        <span class="text">Manajemen User</span>
    </a>
    <a href="#">
        <i class="fas fa-cog"></i>
        <span class="text">Pengaturan</span>
    </a>
    <a href="{{ route('books.create') }}">
        <i class="fas fa-plus-circle"></i>
        <span class="text">Tambah Buku</span>
    </a>

    @auth
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">
                <i class="fas fa-sign-out-alt"></i>
                <span class="text">Logout</span>
            </button>
        </form>
    @endauth
</div>

<!-- Content -->
<div class="content" id="content">
    <main class="container-fluid">
        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('content');
    const toggleBtn = document.getElementById('toggleSidebar');
    const menuTitles = document.querySelectorAll('.menu-title');

    function initializeSidebar() {
        const sidebarHidden = localStorage.getItem('sidebarHidden');

        // Untuk mobile, default hide
        if (window.innerWidth <= 768) {
            sidebar.classList.add('hide');
            content.classList.add('full');
            menuTitles.forEach(title => title.classList.add('hide'));
            return;
        }

        if (sidebarHidden === 'true') {
            sidebar.classList.add('hide');
            content.classList.add('full');
            menuTitles.forEach(title => title.classList.add('hide'));
        }
    }

    toggleBtn.addEventListener('click', (e) => {
        e.preventDefault();
        sidebar.classList.toggle('hide');
        content.classList.toggle('full');
        menuTitles.forEach(title => title.classList.toggle('hide'));

        const isHidden = sidebar.classList.contains('hide');
        localStorage.setItem('sidebarHidden', isHidden);
    });

    document.addEventListener('DOMContentLoaded', initializeSidebar);

    // Handle resize
    window.addEventListener('resize', () => {
        if (window.innerWidth <= 768) {
            sidebar.classList.add('hide');
            content.classList.add('full');
            menuTitles.forEach(title => title.classList.add('hide'));
        }
    });
</script>

@stack('scripts')
</body>
</html>
