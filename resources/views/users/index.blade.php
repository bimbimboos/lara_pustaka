
@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
    <div class="container-fluid mt-4" style="margin-left: 260px;"> <!-- Adjusted margin to avoid sidebar -->
        <div class="row">
            <div class="col-12">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fa-solid fa-users me-2"></i>Manajemen User</h2>
                    @unless(Auth::user()->role == 'user')
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
                            <i class="fa-solid fa-user-plus me-2"></i>Tambah User
                        </button>
                    @endunless
                </div>

                <!-- Search Bar -->
                <div class="input-group w-50 mb-4">
                    <input type="text" class="form-control" id="searchInput" placeholder="Cari user..."
                           aria-label="Cari user">
                    <span class="input-group-text"><i class="fa-solid fa-search"></i></span>
                </div>

                <!-- Table -->
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="table-responsive" style="max-width: 1000px; overflow-x: auto;">
                            <table class="table table-hover align-middle" style="min-width: 600px; width: 100%; max-width: 1000px;">
                                <thead class="table-dark">
                                <tr>
                                    <th style="width: 5%;">#</th>
                                    <th style="width: 20%;">Nama</th>
                                    <th style="width: 25%;">Email</th>
                                    <th style="width: 15%;">Role</th>
                                    <th style="width: 20%;">Dibuat</th>
                                    <th style="width: 15%;">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($users as $index => $user)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td class="text-truncate" style="max-width: 200px;" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $user->email }}">
                                            {{ $user->email }}
                                        </td>
                                        <td>
                                            <span class="badge
                                                {{ $user->role == 'admin' ? 'bg-danger' : 'bg-secondary' }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td>{{ $user->created_at->format('d M Y') }}</td>
                                        <td>
                                            @unless(Auth::user()->role == 'user')
                                                <button type="button" class="btn btn-sm btn-warning me-2"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editUserModal{{ $user->id_user }}">
                                                    <i class="fa-solid fa-pen me-1"></i>Edit
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteUserModal{{ $user->id_user }}">
                                                    <i class="fa-solid fa-trash me-1"></i>Hapus
                                                </button>
                                            @else
                                                <span class="text-muted">Tidak ada aksi</span>
                                            @endunless
                                        </td>
                                    </tr>

                                    <!-- Edit User Modal -->
                                    <div class="modal fade" id="editUserModal{{ $user->id_user }}" tabindex="-1"
                                         aria-labelledby="editUserModalLabel{{ $user->id_user }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow-lg">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title" id="editUserModalLabel{{ $user->id_user }}">
                                                        <i class="fa-solid fa-pen me-2"></i>Edit User
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('users.update', $user->id_user) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="name{{ $user->id_user }}" class="form-label">Nama</label>
                                                            <input type="text" class="form-control" id="name{{ $user->id_user }}"
                                                                   name="name" value="{{ $user->name }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="email{{ $user->id_user }}" class="form-label">Email</label>
                                                            <input type="email" class="form-control" id="email{{ $user->id_user }}"
                                                                   name="email" value="{{ $user->email }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="role{{ $user->id_user }}" class="form-label">Role</label>
                                                            <select class="form-select" id="role{{ $user->id_user }}" name="role" required>
                                                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                                                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete User Modal -->
                                    <div class="modal fade" id="deleteUserModal{{ $user->id_user }}" tabindex="-1"
                                         aria-labelledby="deleteUserModalLabel{{ $user->id_user }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow-lg">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title" id="deleteUserModalLabel{{ $user->id_user }}">
                                                        <i class="fa-solid fa-trash me-2"></i>Hapus User
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Yakin ingin menghapus user <strong>{{ $user->name }}</strong>?</p>
                                                    <p class="text-muted">Tindakan ini tidak dapat dibatalkan.</p>
                                                </div>
                                                <form action="{{ route('users.destroy', $user->id_user) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">Belum ada user.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create User Modal -->
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="createUserModalLabel">
                        <i class="fa-solid fa-user-plus me-2"></i>Tambah User
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            // Search functionality
            document.getElementById('searchInput').addEventListener('input', function() {
                const searchValue = this.value.toLowerCase();
                const rows = document.querySelectorAll('#userTable tbody tr');

                rows.forEach(row => {
                    const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                    const email = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                    const role = row.querySelector('td:nth-child(4)').textContent.toLowerCase();

                    if (name.includes(searchValue) || email.includes(searchValue) || role.includes(searchValue)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });

            // Modal animations
            document.querySelectorAll('.modal').forEach(modal => {
                modal.addEventListener('show.bs.modal', function () {
                    this.querySelector('.modal-content').style.animation = 'modalFadeIn 0.3s ease-in-out';
                });
                modal.addEventListener('hide.bs.modal', function () {
                    this.querySelector('.modal-content').style.animation = 'modalFadeOut 0.3s ease-in-out';
                });
            });

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        </script>

        <style>
            @keyframes modalFadeIn {
                from { transform: scale(0.8); opacity: 0; }
                to { transform: scale(1); opacity: 1; }
            }
            @keyframes modalFadeOut {
                from { transform: scale(1); opacity: 1; }
                to { transform: scale(0.8); opacity: 0; }
            }
            .modal-content {
                border-radius: 0.5rem;
                transition: all 0.3s ease-in-out;
            }
            .table-hover tbody tr:hover {
                background-color: rgba(0, 0, 0, 0.05);
            }
            .input-group-text {
                background-color: #f8f9fa;
            }
            .text-truncate {
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
                max-width: 150px; /* Kept at 150px but constrained by table width */
            }
            .table-responsive {
                max-width: 1000px; /* Fixed max width for the table container */
            }
            table {
                table-layout: fixed; /* Ensures columns respect defined widths */
                width: 100%; /* Ensures table fills the responsive container */
                max-width: 1000px; /* Caps the table width */
            }
        </style>
    @endsection
