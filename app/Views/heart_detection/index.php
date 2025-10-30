<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Deteksi Kelainan Jantung - C4.5</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .form-section-title {
            color: var(--primary-green);
            border-bottom: 2px solid var(--light-green);
            padding-bottom: 8px;
            margin: 20px 0 15px;
            font-weight: 600;
        }
        .info-box {
            background-color: #e6f7f0;
            border-left: 4px solid var(--primary-green);
            padding: 10px 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-size: 0.9rem;
        }
        .info-box i {
            color: var(--primary-green);
            margin-right: 8px;
        }
        :root {
            --primary-green: #10b981;
            --secondary-green: #059669;
            --accent-teal: #14b8a6;
            --accent-lime: #84cc16;
            --dark-green: #065f46;
            --light-green: #d1fae5;
        }
        body {
            background: linear-gradient(135deg, #059669 0%, #10b981 50%, #84cc16 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(15px);
            box-shadow: 0 4px 30px rgba(16, 185, 129, 0.1);
            border-bottom: 2px solid rgba(16, 185, 129, 0.1);
        }
        .navbar-brand {
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-green), var(--accent-teal));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 1.6rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .navbar-brand i {
            background: linear-gradient(135deg, var(--primary-green), var(--accent-teal));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: heartbeat 1.5s ease-in-out infinite;
        }
        @keyframes heartbeat {
            0%, 100% { transform: scale(1); }
            25% { transform: scale(1.1); }
            50% { transform: scale(1); }
        }
        .main-container {
            margin-top: 30px;
            margin-bottom: 30px;
        }
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .card-header {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            padding: 25px;
            border: none;
            position: relative;
            overflow: hidden;
        }
        .card-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: shimmer 3s linear infinite;
        }
        @keyframes shimmer {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .card-header h3 {
            margin: 0;
            font-weight: 600;
        }
        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 8px;
        }
        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e0e0e0;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.25);
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            border: none;
            padding: 12px 40px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.5);
            background: linear-gradient(135deg, var(--secondary-green), var(--accent-teal));
        }
        .info-box {
            background: linear-gradient(135deg, var(--light-green), #fff);
            border-left: 4px solid var(--accent-teal);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(16, 185, 129, 0.1);
        }
        .parameter-icon {
            font-size: 1.2rem;
            background: linear-gradient(135deg, var(--primary-green), var(--accent-teal));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-right: 10px;
        }
        .hero-section {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            text-align: center;
        }
        .hero-section h1 {
            color: var(--dark-color);
            font-weight: 700;
            margin-bottom: 15px;
        }
        .hero-section p {
            color: #7f8c8d;
            font-size: 1.1rem;
        }
        .feature-card {
            background: white;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
        .feature-card i {
            font-size: 2.5rem;
            background: linear-gradient(135deg, var(--primary-green), var(--accent-lime));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <i class="fas fa-heartbeat"></i> Heart Detection System
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('heartdetection/riwayat') ?>">
                            <i class="fas fa-history me-1"></i> Riwayat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= base_url('heartdetection') ?>">
                            <i class="fas fa-home"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('heartdetection/dataset') ?>">
                            <i class="fas fa-database"></i> Dataset
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('heartdetection/about') ?>">
                            <i class="fas fa-info-circle"></i> Tentang
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container main-container">
        <!-- Hero Section -->
        <div class="hero-section">
            <h1>
                <i class="fas fa-heartbeat" style="background: linear-gradient(135deg, #10b981, #14b8a6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; animation: pulse 2s infinite;"></i> 
                Sistem Deteksi Kelainan Jantung
            </h1>
            <p class="lead" style="color: #065f46;">Menggunakan Algoritma C4.5 (Decision Tree) untuk Klasifikasi Data Elektrokardiogram</p>
            <div style="display: inline-flex; gap: 10px; margin-top: 15px;">
                <span class="badge" style="background: linear-gradient(135deg, #10b981, #059669); padding: 8px 15px; font-size: 0.9rem;">
                    <i class="fas fa-shield-alt"></i> Akurat
                </span>
                <span class="badge" style="background: linear-gradient(135deg, #14b8a6, #0d9488); padding: 8px 15px; font-size: 0.9rem;">
                    <i class="fas fa-bolt"></i> Cepat
                </span>
                <span class="badge" style="background: linear-gradient(135deg, #84cc16, #65a30d); padding: 8px 15px; font-size: 0.9rem;">
                    <i class="fas fa-check-circle"></i> Terpercaya
                </span>
            </div>
        </div>

        <div class="row">
            <!-- Features -->
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <i class="fas fa-chart-line"></i>
                    <h5>Akurat</h5>
                    <p class="text-muted">Menggunakan algoritma C4.5 yang terbukti akurat</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <i class="fas fa-bolt"></i>
                    <h5>Cepat</h5>
                    <p class="text-muted">Hasil diagnosa dalam hitungan detik</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <i class="fas fa-user-md"></i>
                    <h5>Terpercaya</h5>
                    <p class="text-muted">Berdasarkan data rekam medis EKG</p>
                </div>
            </div>
        </div>

        <!-- Form Input -->
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header">
                        <h3><i class="fas fa-file-medical"></i> Input Data Elektrokardiogram (EKG)</h3>
                        <p class="mb-0" style="opacity: 0.9;">Masukkan parameter EKG untuk deteksi kelainan jantung</p>
                    </div>
                    <div class="card-body p-4">
                        <div class="info-box">
                            <i class="fas fa-info-circle"></i>
                            <strong>Petunjuk:</strong> Masukkan nilai parameter dari hasil pemeriksaan elektrokardiogram (EKG) Anda
                        </div>

                        <form action="<?= base_url('heartdetection/detect') ?>" method="POST">
                            <?= csrf_field() ?>
                            
                            <!-- Data Pribadi -->
                            <div class="mb-4">
                                <h5 class="form-section-title"><i class="fas fa-user me-2"></i>Data Pribadi</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nik" class="form-label">NIK KTP <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nik" name="nik" required
                                            placeholder="Masukkan NIK KTP (16 digit)" 
                                            pattern="\d{16}" 
                                            title="NIK harus 16 digit angka"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16)">
                                        <div class="form-text">NIK akan digunakan untuk update data jika sudah pernah input sebelumnya</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="nama" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="nama" name="nama" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                            <option value="">Pilih...</option>
                                            <option value="L">Laki-laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="berat_badan" class="form-label">Berat Badan (kg)</label>
                                        <input type="number" step="0.1" class="form-control" id="berat_badan" name="berat_badan" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="tinggi_badan" class="form-label">Tinggi Badan (cm)</label>
                                        <input type="number" class="form-control" id="tinggi_badan" name="tinggi_badan" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Riwayat Kesehatan -->
                            <div class="mb-4">
                                <h5 class="form-section-title"><i class="fas fa-notes-medical me-2"></i>Riwayat Kesehatan</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="riwayat_keluarga" class="form-label">Riwayat Penyakit Jantung Keluarga</label>
                                        <textarea class="form-control" id="riwayat_keluarga" name="riwayat_keluarga" rows="2"></textarea>
                                        <small class="text-muted">Contoh: Ayah pernah serangan jantung di usia 50 tahun</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="obat" class="form-label">Obat yang Sedang Dikonsumsi</label>
                                        <input type="text" class="form-control" id="obat" name="obat" placeholder="Contoh: Obat hipertensi, statin, dll">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="tekanan_darah" class="form-label">Tekanan Darah (mmHg)</label>
                                        <input type="text" class="form-control" id="tekanan_darah" name="tekanan_darah" placeholder="Contoh: 120/80">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="kolesterol" class="form-label">Kolesterol Total (mg/dL)</label>
                                        <input type="text" class="form-control" id="kolesterol" name="kolesterol">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="gula_darah" class="form-label">Gula Darah Puasa (mg/dL)</label>
                                        <input type="text" class="form-control" id="gula_darah" name="gula_darah">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Diabetes</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="diabetes" id="diabetes_ya" value="1">
                                            <label class="form-check-label" for="diabetes_ya">Ya</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="diabetes" id="diabetes_tidak" value="0" checked>
                                            <label class="form-check-label" for="diabetes_tidak">Tidak</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Gaya Hidup -->
                            <div class="mb-4">
                                <h5 class="form-section-title"><i class="fas fa-heartbeat me-2"></i>Gaya Hidup</h5>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="merokok" class="form-label">Status Merokok</label>
                                        <select class="form-select" id="merokok" name="merokok">
                                            <option value="Tidak">Tidak Pernah</option>
                                            <option value="Ya">Ya, Masih Merokok</option>
                                            <option value="Mantan">Mantan Perokok</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="aktivitas_fisik" class="form-label">Aktivitas Fisik</label>
                                        <select class="form-select" id="aktivitas_fisik" name="aktivitas_fisik">
                                            <option value="Jarang">< 1x/minggu</option>
                                            <option value="Sedang" selected>1-3x/minggu</option>
                                            <option value="Sering">> 3x/minggu</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="konsumsi_alkohol" class="form-label">Konsumsi Alkohol</label>
                                        <select class="form-select" id="konsumsi_alkohol" name="konsumsi_alkohol">
                                            <option value="Tidak">Tidak Pernah</option>
                                            <option value="Jarang">Jarang (1-3x/bulan)</option>
                                            <option value="Sering">Sering (>1x/minggu)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="stres" class="form-label">Tingkat Stres (1-10)</label>
                                        <input type="range" class="form-range" min="1" max="10" id="stres" name="stres">
                                        <div class="d-flex justify-content-between">
                                            <small>Rendah</small>
                                            <small>Sedang</small>
                                            <small>Tinggi</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="tidur" class="form-label">Durasi Tidur (jam/hari)</label>
                                        <input type="number" step="0.5" min="0" max="24" class="form-control" id="tidur" name="tidur" value="7">
                                    </div>
                                </div>
                            </div>

                            <!-- Data EKG -->
                            <h5 class="form-section-title"><i class="fas fa-heartbeat me-2"></i>Data Elektrokardiogram (EKG)</h5>
                            <div class="info-box mb-4">
                                <i class="fas fa-info-circle"></i>
                                <strong>Petunjuk:</strong> Masukkan nilai parameter dari hasil pemeriksaan elektrokardiogram (EKG) Anda
                            </div>
                            
                            <div class="row">
                                <!-- HR (Heart Rate) -->
                                <div class="col-md-6 mb-3">
                                    <label for="hr" class="form-label">
                                        <i class="fas fa-heart parameter-icon"></i>HR (Heart Rate)
                                    </label>
                                    <input type="number" class="form-control" id="hr" name="hr" 
                                           placeholder="Contoh: 70" required min="40" max="200" step="1">
                                    <small class="text-muted">Normal: 60-100 bpm</small>
                                </div>

                                <!-- P-R Interval -->
                                <div class="col-md-6 mb-3">
                                    <label for="pr" class="form-label">
                                        <i class="fas fa-wave-square parameter-icon"></i>P-R Interval
                                    </label>
                                    <input type="number" class="form-control" id="pr" name="pr" 
                                           placeholder="Contoh: 150" required min="80" max="300" step="1">
                                    <small class="text-muted">Normal: 120-200 ms</small>
                                </div>

                                <!-- QRS Complex -->
                                <div class="col-md-6 mb-3">
                                    <label for="qrs" class="form-label">
                                        <i class="fas fa-wave-square parameter-icon"></i>QRS Complex
                                    </label>
                                    <input type="number" class="form-control" id="qrs" name="qrs" 
                                           placeholder="Contoh: 95" required min="60" max="150" step="1">
                                    <small class="text-muted">Normal: 80-120 ms</small>
                                </div>

                                <!-- QT Interval -->
                                <div class="col-md-6 mb-3">
                                    <label for="qt" class="form-label">
                                        <i class="fas fa-wave-square parameter-icon"></i>QT Interval
                                    </label>
                                    <input type="number" class="form-control" id="qt" name="qt" 
                                           placeholder="Contoh: 370" required min="250" max="500" step="1">
                                    <small class="text-muted">Normal: 320-440 ms</small>
                                </div>

                                <!-- QTC (Corrected QT) -->
                                <div class="col-md-6 mb-3">
                                    <label for="qtc" class="form-label">
                                        <i class="fas fa-wave-square parameter-icon"></i>QTC (Corrected QT)
                                    </label>
                                    <input type="number" class="form-control" id="qtc" name="qtc" 
                                           placeholder="Contoh: 410" required min="300" max="550" step="1">
                                    <small class="text-muted">Normal: 350-450 ms</small>
                                </div>

                                <!-- AXIS -->
                                <div class="col-md-6 mb-3">
                                    <label for="axis" class="form-label">
                                        <i class="fas fa-compass parameter-icon"></i>AXIS
                                    </label>
                                    <input type="number" class="form-control" id="axis" name="axis" 
                                           placeholder="Contoh: 45" required min="-90" max="180" step="1">
                                    <small class="text-muted">Normal: -30 sampai +100 derajat</small>
                                </div>

                                <!-- RV6 -->
                                <div class="col-md-4 mb-3">
                                    <label for="rv6" class="form-label">
                                        <i class="fas fa-chart-bar parameter-icon"></i>RV6
                                    </label>
                                    <input type="number" class="form-control" id="rv6" name="rv6" 
                                           placeholder="Contoh: 1.5" required step="0.01">
                                    <small class="text-muted">Amplitudo gelombang R di V6</small>
                                </div>

                                <!-- SV1 -->
                                <div class="col-md-4 mb-3">
                                    <label for="sv1" class="form-label">
                                        <i class="fas fa-chart-bar parameter-icon"></i>SV1
                                    </label>
                                    <input type="number" class="form-control" id="sv1" name="sv1" 
                                           placeholder="Contoh: 0.8" required step="0.01">
                                    <small class="text-muted">Amplitudo gelombang S di V1</small>
                                </div>

                                <!-- R+S -->
                                <div class="col-md-4 mb-3">
                                    <label for="rs" class="form-label">
                                        <i class="fas fa-plus parameter-icon"></i>R+S
                                    </label>
                                    <input type="number" class="form-control" id="rs" name="rs" 
                                           placeholder="Contoh: 2.0" required step="0.01">
                                    <small class="text-muted">Jumlah amplitudo R dan S</small>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-search"></i> Deteksi Kelainan Jantung
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
