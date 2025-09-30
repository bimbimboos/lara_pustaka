<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Bimantara Pustaka</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            background: #e9ecef;
            min-height: 100vh;
        }

        /* Header */
        .top-header {
            background: linear-gradient(135deg, #3a3f47 0%, #2c3136 100%);
            color: white;
            padding: 15px 0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 100%;
        }

        .library-title {
            font-size: 28px;
            font-weight: bold;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .profile-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .profile-photo {
            width: 50px;
            height: 50px;
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
            font-size: 18px;
            line-height: 1.2;
        }

        .profile-role {
            font-size: 14px;
            opacity: 0.9;
            font-style: italic;
        }

        /* Menu items */
        .menu-item {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .menu-item:hover {
            transform: translateX(10px);
            filter: drop-shadow(0 5px 15px rgba(0,0,0,0.1));
        }

        .menu-item .fa {
            transition: all 0.3s ease;
        }

        .menu-item:hover .fa {
            transform: scale(1.1);
        }

        .card {
            border-radius: 20px;
            border: none;
            background: #e9ecef;
        }

        .card-header {
            border-radius: 20px 20px 0 0 !important;
            background: #e9ecef;
            color: #343a40;
        }

        /* Welcome section */
        .welcome-section {
            background: #e9ecef;
            border-radius: 25px;
            padding: 40px;
            margin: 30px 0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .library-title {
                font-size: 20px;
            }
            .profile-section {
                gap: 10px;
            }
            .profile-photo {
                width: 40px;
                height: 40px;
            }
            .profile-name {
                font-size: 16px;
            }
            .welcome-section {
                padding: 25px;
            }
        }
    </style>
</head>
<body>
{{-- Header --}}
<div class="top-header">
    <div class="container">
        <div class="header-content">
            <h1 class="library-title">
                <i class="fas fa-book-open me-3"></i>
                Bimantara Pustaka
            </h1>
            <div class="profile-section">
                <a href="{{ route('users.index') }}" class="btn btn-outline-light me-3">
                    <i class="fa fa-users-cog me-1"></i> Manajemen User
                </a>
                @if(Auth::user()->photo)
                    <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Profile" class="profile-photo">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3a3f47&color=fff&size=50" alt="Profile" class="profile-photo">
                @endif
                <div class="profile-info">
                    <div class="profile-name">
                        {{ Auth::user()->name ?? 'Administrator' }}
                    </div>
                    <div class="profile-role">
                        {{ Auth::user()->role ?? 'Admin Perpustakaan' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Content --}}
<div class="container">
    <!-- Welcome Section -->
    <div class="welcome-section text-center">
        <h2 class="fw-bold mb-3">Selamat Datang, {{ Auth::user()->name ?? 'User' }} 👋</h2>
        <p class="text-muted fs-5">Kelola perpustakaan digital dengan mudah, cepat, dan terorganisir</p>
    </div>

    <!-- Main Cards -->
    <div class="row g-4 justify-content-center">
        <div class="col-lg-3 col-md-4 col-sm-6">
            <a href="{{ route('books.index') }}" class="text-decoration-none menu-item">
                <div class="text-center py-4">
                    <i class="fa fa-book fa-3x text-primary mb-3"></i>
                    <h5 class="fw-bold">Buku</h5>
                    <p class="text-muted">Kelola koleksi buku</p>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <a href="{{ route('kategori.index') }}" class="text-decoration-none menu-item">
                <div class="text-center py-4">
                    <i class="fa fa-folder fa-3x text-success mb-3"></i>
                    <h5 class="fw-bold">Kategori</h5>
                    <p class="text-muted">Atur kategori buku</p>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <a href="{{ route('subkategori.index') }}" class="text-decoration-none menu-item">
                <div class="text-center py-4">
                    <i class="fa fa-layer-group fa-3x text-warning mb-3"></i>
                    <h5 class="fw-bold">Subkategori</h5>
                    <p class="text-muted">Kelola sub kategori</p>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <a href="{{ route('penerbit.index') }}" class="text-decoration-none menu-item">
                <div class="text-center py-4">
                    <i class="fa fa-building fa-3x text-danger mb-3"></i>
                    <h5 class="fw-bold">Penerbit</h5>
                    <p class="text-muted">Manajemen penerbit</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Tentang Kami -->
    <div class="row justify-content-center my-5">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fa fa-info-circle me-2"></i> Tentang Kami</h5>
                </div>
                <div class="card-body">
                    <h5 class="fw-bold">Bimantara Pustaka</h5>
                    <p class="text-muted">
                        Bimantara Pustaka adalah sistem perpustakaan digital modern yang memudahkan pengelolaan buku, kategori, subkategori, penerbit, hingga manajemen pengguna.
                    </p>
                    <p class="text-muted mb-0">
                        Dengan teknologi terkini, kami berkomitmen untuk menciptakan akses literasi yang mudah, cepat, dan terorganisir bagi semua kalangan.
                        Visi kami adalah menjadi mitra literasi digital yang mendukung perkembangan pendidikan, riset, dan budaya membaca di era modern.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout & Profile Menu -->
    <div class="text-center mb-5">
        @auth
            <div class="dropdown d-inline-block me-3">
                <button class="btn btn-outline-primary btn-lg dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fa fa-user me-2"></i>{{ Auth::user()->name ?? 'Profile' }}
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.show') }}">
                            <i class="fa fa-user me-2"></i> Profil Saya
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fa fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        @endauth
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelectorAll('.menu-item').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();

            // Create sparkle effect
            for (let i = 0; i < 12; i++) {
                let sparkle = document.createElement("div");
                sparkle.style.position = 'absolute';
                sparkle.style.width = '8px';
                sparkle.style.height = '8px';
                sparkle.style.background = ['#FFD700', '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4'][Math.floor(Math.random() * 5)];
                sparkle.style.borderRadius = '50%';
                sparkle.style.pointerEvents = 'none';
                sparkle.style.left = (e.pageX - 4) + "px";
                sparkle.style.top = (e.pageY - 4) + "px";
                sparkle.style.opacity = '1';
                sparkle.style.transition = 'all 0.8s ease-out';
                document.body.appendChild(sparkle);

                setTimeout(() => {
                    sparkle.style.left = (e.pageX - 4 + (Math.random() - 0.5) * 100) + "px";
                    sparkle.style.top = (e.pageY - 4 + (Math.random() - 0.5) * 100) + "px";
                    sparkle.style.opacity = '0';
                    sparkle.style.transform = 'scale(0)';
                }, 10);

                setTimeout(() => sparkle.remove(), 800);
            }

            // Navigate after animation
            const link = this.closest('a');
            if (link) {
                setTimeout(() => {
                    window.location = link.href;
                }, 300);
            }
        });
    });
</script>
</body>
</html>
