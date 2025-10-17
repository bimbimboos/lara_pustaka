@extends('layouts.app')
@section('content')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 0;
            margin: 0;
        }

        .container {
            max-width: 100%;
            margin: 0;
            background: white;
            padding: 20px;
            min-height: 100vh;
            /* Tambahkan padding atas untuk menghindari overlap dengan header */
            padding-top: 60px; /* Sesuaikan nilai ini berdasarkan tinggi header */
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding: 0;
            /* Pastikan header tetap di atas dan tidak overlap */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: white;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .header h2 {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #333;
            font-size: 22px;
            margin: 0;
            font-weight: 500;
        }

        .header .info-icon {
            background: #17a2b8;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: bold;
            flex-shrink: 0;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-warning {
            background-color: #ffc107;
            color: #333;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
        }

        .section {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
        }

        .section-header {
            padding: 12px 15px;
            color: white;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 15px;
        }

        .section-header i {
            margin-right: 8px;
        }

        .section-header.blue {
            background-color: #007bff;
        }

        .section-header.green {
            background-color: #28a745;
        }

        .section-header.cyan {
            background-color: #17a2b8;
        }

        .section-content {
            padding: 15px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .info-item label {
            display: block;
            color: #666;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .info-item .value {
            color: #333;
            font-size: 16px;
            font-weight: 500;
        }

        .info-item .badge {
            background-color: #28a745;
            color: white;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            display: inline-block;
        }

        .progress-bar-container {
            background-color: #e9ecef;
            border-radius: 4px;
            height: 20px;
            overflow: hidden;
            margin-top: 5px;
        }

        .progress-bar {
            background-color: #28a745;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
            font-weight: bold;
        }

        .subcategory-box {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            border: 1px solid #dee2e6;
        }

        .subcategory-box h4 {
            color: #333;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .subcategory-box .detail {
            color: #666;
            font-size: 13px;
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table thead {
            background-color: #f8f9fa;
        }

        table th {
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #dee2e6;
        }

        table td {
            padding: 12px;
            border-bottom: 1px solid #dee2e6;
            color: #666;
        }

        table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            color: #666;
            font-size: 14px;
        }

        .btn-group {
            display: flex;
            gap: 10px;
        }
    </style>

    <div class="container">
        <div class="header">
            <h2>
                <span class="info-icon"><i class="fas fa-info"></i></span>
                Detail Rak
            </h2>
            <a href="#" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>

        <!-- Informasi Rak -->
        <div class="section">
            <div class="section-header blue">
                <span><i class="fas fa-clipboard-list"></i> Informasi Rak</span>
                <button class="btn btn-danger btn-sm" onclick="hapusRak()"><i class="fas fa-trash"></i> Hapus Rak</button>
            </div>
            <div class="section-content">
                <div class="info-grid">
                    <div class="info-item">
                        <label>ID Rak</label>
                        <div class="value">1</div>
                    </div>
                    <div class="info-item">
                        <label>Nama Rak</label>
                        <div class="value">Rak 1</div>
                    </div>
                    <div class="info-item">
                        <label>Status</label>
                        <div class="badge">0001</div>
                    </div>
                    <div class="info-item">
                        <label>Jumlah Kolom</label>
                        <div class="value">4</div>
                    </div>
                    <div class="info-item">
                        <label>Kategori</label>
                        <div class="value">Aurora Teoriti</div>
                    </div>
                    <div class="info-item">
                        <label>Jumlah Baris</label>
                        <div class="value">2</div>
                    </div>
                </div>

                <div style="margin-top: 15px;">
                    <label>Rasio Eksemplar</label>
                    <div style="font-weight: bold; color: #333; margin-top: 5px;">10 / 68 Slot</div>
                    <div class="progress-bar-container">
                        <div class="progress-bar" style="width: 15%;">15%</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pemetaan Subkategori per Kolom -->
        <div class="section">
            <div class="section-header green">
                <i class="fas fa-chart-bar"></i> Pemetaan Subkategori per Kolom
            </div>
            <div class="section-content">
                <div class="subcategory-box">
                    <h4>Kolom 1</h4>
                    <div class="detail"><strong>Novel Fiksi</strong></div>
                    <div class="detail">Rentang Baris: Baris 1</div>
                    <div class="detail">ID Buku: 10 Buku</div>
                </div>
            </div>
        </div>

        <!-- Informasi Lokasi -->
        <div class="section">
            <div class="section-header cyan">
                <span><i class="fas fa-map-marker-alt"></i> Informasi Lokasi</span>
                <button class="btn btn-warning btn-sm" onclick="editLokasi()"><i class="fas fa-edit"></i> Edit Lokasi</button>
            </div>
            <div class="section-content">
                <div class="info-grid">
                    <div class="info-item">
                        <label>ID Lokasi</label>
                        <div class="value">1</div>
                    </div>
                    <div class="info-item">
                        <label>Nama Ruang</label>
                        <div class="value">Ruang Anggrek</div>
                    </div>
                    <div class="info-item">
                        <label>Lantai</label>
                        <div class="value">1</div>
                    </div>
                </div>

                <h3 style="margin-top: 20px; margin-bottom: 10px; color: #333;">Daftar Buku di Rak Ini</h3>
                <table>
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>Kategori</th>
                        <th>Subkategori</th>
                        <th>Jumlah</th>
                        <th>Posisi (Kolom-Baris)</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>Buku 1</td>
                        <td>Aurora Teoriti</td>
                        <td>Novel Fiksi</td>
                        <td>10</td>
                        <td>1-1</td>
                        <td>
                            <a href="{{ route('bookitems.index', ['buku_id' => 1]) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye"></i> Lihat Eksemplar
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div style="margin-top: 20px;">
            <button class="btn btn-secondary" onclick="window.print()"><i class="fas fa-print"></i> Ubah Eksemplar</button>
        </div>

        <div class="footer">
            ©2025 Bimantara Pustaka - All Right Reserved.
        </div>
    </div>

    <script>
        function hapusRak() {
            if (confirm('Apakah Anda yakin ingin menghapus rak ini?')) {
                alert('Rak berhasil dihapus!');
                // Tambahkan logika hapus di sini
            }
        }

        function editLokasi() {
            alert('Fitur edit lokasi akan segera tersedia!');
            // Tambahkan logika edit lokasi di sini
        }
    </script>
@endsection
