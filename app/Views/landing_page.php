<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Heart Detection System - Deteksi Kelainan Jantung dengan C4.5</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-green: #10b981;
            --secondary-green: #059669;
            --accent-teal: #14b8a6;
            --dark-green: #065f46;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* Hero Section */
        .hero-section {
            min-height: 100vh;
            background: linear-gradient(135deg, #059669 0%, #10b981 50%, #84cc16 100%);
            position: relative;
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            border-radius: 50%;
            top: -100px;
            right: -100px;
            animation: float 6s ease-in-out infinite;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            border-radius: 50%;
            bottom: -50px;
            left: -50px;
            animation: float 8s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .hero-content {
            position: relative;
            z-index: 2;
            color: white;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
            animation: slideInLeft 1s ease-out;
        }

        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 30px;
            opacity: 0.95;
            animation: slideInLeft 1.2s ease-out;
        }

        .hero-description {
            font-size: 1.1rem;
            margin-bottom: 40px;
            opacity: 0.9;
            animation: slideInLeft 1.4s ease-out;
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .btn-hero {
            padding: 18px 50px;
            font-size: 1.2rem;
            font-weight: 700;
            border-radius: 50px;
            border: none;
            background: white;
            color: var(--primary-green);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
            animation: slideInUp 1.6s ease-out;
            text-decoration: none;
            display: inline-block;
        }

        .btn-hero:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.3);
            background: var(--light-green);
            color: var(--dark-green);
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .heart-icon {
            font-size: 5rem;
            animation: heartbeat 2s ease-in-out infinite;
            display: inline-block;
            margin-bottom: 20px;
        }

        @keyframes heartbeat {
            0%, 100% { transform: scale(1); }
            10%, 30% { transform: scale(1.1); }
            20%, 40% { transform: scale(1); }
        }

        .hero-image {
            position: relative;
            animation: fadeInRight 1.5s ease-out;
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(16, 185, 129, 0.2);
        }

        .feature-icon {
            font-size: 3.5rem;
            background: linear-gradient(135deg, var(--primary-green), var(--accent-teal));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 20px;
        }

        .feature-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark-green);
            margin-bottom: 15px;
        }

        .feature-description {
            color: #6b7280;
            line-height: 1.6;
        }

        /* Features Section */
        .features-section {
            padding: 100px 0;
            background: linear-gradient(180deg, #f9fafb 0%, white 100%);
        }

        .section-title {
            text-align: center;
            font-size: 3rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-green), var(--accent-teal));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 20px;
        }

        .section-subtitle {
            text-align: center;
            font-size: 1.2rem;
            color: #6b7280;
            margin-bottom: 60px;
        }

        /* Stats Section */
        .stats-section {
            background: linear-gradient(135deg, var(--dark-green), var(--primary-green));
            padding: 80px 0;
            color: white;
        }

        .stat-item {
            text-align: center;
            padding: 20px;
        }

        .stat-number {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        /* CTA Section */
        .cta-section {
            background: white;
            padding: 100px 0;
            text-align: center;
        }

        .cta-card {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            border-radius: 30px;
            padding: 60px;
            color: white;
            box-shadow: 0 20px 60px rgba(16, 185, 129, 0.3);
        }

        .cta-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 20px;
        }

        .cta-text {
            font-size: 1.2rem;
            margin-bottom: 40px;
            opacity: 0.95;
        }

        .btn-cta {
            padding: 18px 50px;
            font-size: 1.2rem;
            font-weight: 700;
            border-radius: 50px;
            border: 3px solid white;
            background: white;
            color: var(--primary-green);
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-cta:hover {
            background: transparent;
            color: white;
            transform: scale(1.05);
        }

        /* Floating Animation */
        .float-animation {
            animation: floatSlow 3s ease-in-out infinite;
        }

        @keyframes floatSlow {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            .hero-subtitle {
                font-size: 1.2rem;
            }
            .section-title {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
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
                        <a class="nav-link" href="<?= base_url('heartdetection') ?>">
                            <i class="fas fa-home"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= base_url('heartdetection/dataset') ?>">
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

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <div class="heart-icon">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <h1 class="hero-title">
                        Heart Detection<br>System
                    </h1>
                    <p class="hero-subtitle">
                        Deteksi Kelainan Jantung dengan Algoritma C4.5
                    </p>
                    <p class="hero-description">
                        Sistem cerdas berbasis AI untuk menganalisis data elektrokardiogram (EKG) dan memberikan klasifikasi kelainan jantung dengan akurasi tinggi.
                    </p>
                    <a href="<?= base_url('heartdetection') ?>" class="btn-hero">
                        <i class="fas fa-stethoscope"></i> Mulai Deteksi Sekarang
                    </a>
                </div>
                <div class="col-lg-6 hero-image">
                    <div class="text-center float-animation">
                        <i class="fas fa-heart-pulse" style="font-size: 20rem; color: rgba(255,255,255,0.9);"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <h2 class="section-title">Fitur Unggulan</h2>
            <p class="section-subtitle">Teknologi terdepan untuk kesehatan jantung Anda</p>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-brain"></i>
                        </div>
                        <h3 class="feature-title">Algoritma C4.5</h3>
                        <p class="feature-description">
                            Menggunakan Decision Tree dengan perhitungan Entropy, Information Gain, dan Gain Ratio untuk klasifikasi akurat.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="feature-title">Visualisasi Data</h3>
                        <p class="feature-description">
                            Grafik interaktif dengan Chart.js menampilkan hasil analisis dalam bentuk Doughnut, Bar, dan Radar Chart.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3 class="feature-title">Akurat & Terpercaya</h3>
                        <p class="feature-description">
                            Berdasarkan data rekam medis EKG yang telah divalidasi dengan tingkat kepercayaan hingga 95%.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h3 class="feature-title">Hasil Instan</h3>
                        <p class="feature-description">
                            Dapatkan hasil klasifikasi dan rekomendasi dalam hitungan detik setelah input parameter EKG.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-calculator"></i>
                        </div>
                        <h3 class="feature-title">Perhitungan Detail</h3>
                        <p class="feature-description">
                            Lihat proses perhitungan lengkap dengan analisis per parameter dan rumus matematika yang digunakan.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h3 class="feature-title">Responsive Design</h3>
                        <p class="feature-description">
                            Tampilan modern dan mobile-friendly, dapat diakses dari berbagai perangkat kapan saja.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 stat-item">
                    <div class="stat-number">
                        <i class="fas fa-database"></i> 9
                    </div>
                    <div class="stat-label">Parameter EKG</div>
                </div>
                <div class="col-md-3 stat-item">
                    <div class="stat-number">95%</div>
                    <div class="stat-label">Tingkat Akurasi</div>
                </div>
                <div class="col-md-3 stat-item">
                    <div class="stat-number">
                        <i class="fas fa-clock"></i> 3s
                    </div>
                    <div class="stat-label">Waktu Deteksi</div>
                </div>
                <div class="col-md-3 stat-item">
                    <div class="stat-number">100%</div>
                    <div class="stat-label">Gratis & Open</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-card">
                <h2 class="cta-title">Siap Memulai Deteksi?</h2>
                <p class="cta-text">
                    Masukkan data EKG Anda dan dapatkan hasil klasifikasi kelainan jantung<br>
                    dengan teknologi algoritma C4.5 yang terpercaya.
                </p>
                <a href="<?= base_url('heartdetection') ?>" class="btn-cta">
                    <i class="fas fa-heartbeat"></i> Deteksi Sekarang
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer style="background: #065f46; color: white; padding: 40px 0; text-align: center;">
        <div class="container">
            <p style="margin: 0; font-size: 1.1rem;">
                <i class="fas fa-heartbeat"></i> <strong>Heart Detection System</strong>
            </p>
            <p style="margin: 10px 0 0 0; opacity: 0.8;">
                Sistem Deteksi Kelainan Jantung dengan Algoritma C4.5 | Made with 💚
            </p>
            <div style="margin-top: 20px;">
                <a href="<?= base_url('heartdetection') ?>" style="color: white; margin: 0 15px; text-decoration: none;">
                    <i class="fas fa-home"></i> Beranda
                </a>
                <a href="<?= base_url('heartdetection/dataset') ?>" style="color: white; margin: 0 15px; text-decoration: none;">
                    <i class="fas fa-database"></i> Dataset
                </a>
                <a href="<?= base_url('heartdetection/about') ?>" style="color: white; margin: 0 15px; text-decoration: none;">
                    <i class="fas fa-info-circle"></i> Tentang
                </a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
