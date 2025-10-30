<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang - Sistem Deteksi Kelainan Jantung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-green: #10b981;
            --secondary-green: #059669;
            --accent-teal: #14b8a6;
            --dark-green: #065f46;
        }
        body {
            background: linear-gradient(135deg, #059669 0%, #10b981 50%, #84cc16 100%);
            min-height: 100vh;
        }
        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-green), var(--accent-teal));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 1.6rem;
        }
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            margin: 30px 0;
            background: white;
        }
        .card-header {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            padding: 25px;
            border-radius: 20px 20px 0 0 !important;
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
        .feature-box {
            padding: 20px;
            border-left: 4px solid var(--accent-teal);
            background: linear-gradient(135deg, #d1fae5, #fff);
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(16, 185, 129, 0.1);
        }
        .algorithm-flow {
            background: #e3f2fd;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
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

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-info-circle"></i> Tentang Sistem</h3>
                <p class="mb-0">Sistem Deteksi Kelainan Jantung Menggunakan Algoritma C4.5</p>
            </div>
            <div class="card-body p-4">
                <h4><i class="fas fa-laptop-medical"></i> Deskripsi Sistem</h4>
                <p>
                    Sistem ini merupakan aplikasi berbasis web yang dirancang untuk membantu mendeteksi kelainan jantung 
                    berdasarkan data elektrokardiogram (EKG) menggunakan algoritma C4.5 (Decision Tree). Sistem ini dapat 
                    mengklasifikasikan kondisi jantung menjadi dua kategori: <strong>Normal</strong> dan <strong>AbNormal</strong>.
                </p>

                <div class="feature-box">
                    <h5><i class="fas fa-star text-warning"></i> Fitur Utama:</h5>
                    <ul>
                        <li>Input data parameter EKG secara manual</li>
                        <li>Klasifikasi otomatis menggunakan algoritma C4.5</li>
                        <li>Tampilan hasil dengan tingkat kepercayaan (confidence)</li>
                        <li>Rekomendasi berdasarkan hasil klasifikasi</li>
                        <li>Visualisasi data training</li>
                        <li>Interface yang user-friendly dan responsif</li>
                    </ul>
                </div>

                <h4 class="mt-4"><i class="fas fa-sitemap"></i> Algoritma C4.5</h4>
                <p>
                    C4.5 adalah algoritma klasifikasi yang menggunakan struktur pohon keputusan (decision tree). 
                    Algoritma ini bekerja dengan cara membagi data berdasarkan atribut yang memiliki gain ratio tertinggi.
                </p>

                <div class="algorithm-flow">
                    <h6><strong>Cara Kerja Algoritma:</strong></h6>
                    <ol>
                        <li>Sistem menerima input 9 parameter EKG dari pengguna</li>
                        <li>Algoritma C4.5 memproses data berdasarkan decision tree yang telah dibangun</li>
                        <li>Setiap parameter dievaluasi terhadap threshold yang telah ditentukan</li>
                        <li>Sistem memberikan klasifikasi: Normal atau AbNormal</li>
                        <li>Confidence score dihitung berdasarkan jumlah parameter yang abnormal</li>
                        <li>Rekomendasi diberikan sesuai dengan hasil klasifikasi</li>
                    </ol>
                </div>

                <h4 class="mt-4"><i class="fas fa-heartbeat"></i> Parameter EKG</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6><strong>HR (Heart Rate)</strong></h6>
                                <p class="mb-0 small">Denyut jantung per menit. Normal: 60-100 bpm</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6><strong>P-R Interval</strong></h6>
                                <p class="mb-0 small">Waktu konduksi dari atrium ke ventrikel. Normal: 120-200 ms</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6><strong>QRS Complex</strong></h6>
                                <p class="mb-0 small">Durasi depolarisasi ventrikel. Normal: 80-120 ms</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6><strong>QT Interval</strong></h6>
                                <p class="mb-0 small">Waktu depolarisasi dan repolarisasi ventrikel. Normal: 320-440 ms</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6><strong>QTC (Corrected QT)</strong></h6>
                                <p class="mb-0 small">QT interval yang dikoreksi terhadap heart rate. Normal: 350-450 ms</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6><strong>AXIS</strong></h6>
                                <p class="mb-0 small">Arah vektor listrik jantung. Normal: -30° sampai +100°</p>
                            </div>
                        </div>
                    </div>
                </div>

                <h4 class="mt-4"><i class="fas fa-tools"></i> Teknologi yang Digunakan</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-center p-3">
                            <i class="fab fa-php fa-3x text-primary mb-2"></i>
                            <h6>CodeIgniter 4</h6>
                            <small>PHP Framework</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3">
                            <i class="fab fa-bootstrap fa-3x text-purple mb-2"></i>
                            <h6>Bootstrap 5</h6>
                            <small>CSS Framework</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3">
                            <i class="fas fa-brain fa-3x text-danger mb-2"></i>
                            <h6>Algoritma C4.5</h6>
                            <small>Machine Learning</small>
                        </div>
                    </div>
                </div>

                <div class="alert alert-warning mt-4">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Disclaimer:</strong> Sistem ini merupakan prototype untuk tujuan edukasi dan penelitian. 
                    Hasil klasifikasi tidak dapat menggantikan diagnosis medis profesional. Selalu konsultasikan 
                    dengan dokter untuk diagnosis yang akurat.
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
