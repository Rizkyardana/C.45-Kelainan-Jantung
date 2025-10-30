<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Deteksi - Sistem Deteksi Kelainan Jantung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
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
        .main-container {
            margin-top: 30px;
            margin-bottom: 30px;
        }
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            background: white;
        }
        .result-header {
            padding: 40px;
            text-align: center;
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            position: relative;
            overflow: hidden;
        }
        .result-header::before {
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
        .result-header.normal {
            background: linear-gradient(135deg, #56ab2f 0%, #a8e063 100%);
        }
        .result-header.abnormal {
            background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);
        }
        .result-icon {
            font-size: 5rem;
            margin-bottom: 20px;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        .result-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .confidence-badge {
            display: inline-block;
            padding: 10px 30px;
            border-radius: 50px;
            background: rgba(255,255,255,0.2);
            font-size: 1.2rem;
            font-weight: 600;
        }
        .data-table {
            margin: 30px 0;
        }
        .table-parameter {
            background: #f8f9fa;
        }
        .table-parameter th {
            background: linear-gradient(135deg, var(--dark-color), #34495e);
            color: white;
            font-weight: 600;
            padding: 15px;
        }
        .table-parameter td {
            padding: 12px 15px;
            font-weight: 500;
        }
        .recommendation-box {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        .recommendation-box.danger {
            background: #f8d7da;
            border-left-color: #dc3545;
        }
        .recommendation-box.success {
            background: #d4edda;
            border-left-color: #28a745;
        }
        .btn-back {
            padding: 12px 40px;
            border-radius: 10px;
            font-weight: 600;
        }
        .progress-confidence {
            height: 30px;
            border-radius: 15px;
            background: #e9ecef;
            overflow: hidden;
        }
        .progress-bar-confidence {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            transition: width 1s ease;
        }
        .card-header h5 {
            position: relative;
            z-index: 1;
        }
        .alert code {
            background: rgba(0,0,0,0.1);
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.85rem;
        }
        canvas {
            max-height: 300px;
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
                        <a class="nav-link" href="<?= base_url('heartdetection') ?>">
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
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <!-- Result Header -->
                    <div class="result-header <?= $result['status'] == 'success' ? 'normal' : 'abnormal' ?>">
                        <div class="result-icon">
                            <?php if ($result['status'] == 'success'): ?>
                                <i class="fas fa-check-circle"></i>
                            <?php else: ?>
                                <i class="fas fa-exclamation-triangle"></i>
                            <?php endif; ?>
                        </div>
                        <h1 class="result-title"><?= $result['classification'] ?></h1>
                        <p class="lead mb-3">Hasil Klasifikasi Algoritma C4.5</p>
                        <div class="confidence-badge">
                            <i class="fas fa-chart-line"></i> Confidence: <?= $result['confidence'] ?>%
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <!-- Confidence Progress -->
                        <div class="mb-4">
                            <label class="form-label"><strong>Tingkat Kepercayaan:</strong></label>
                            <div class="progress-confidence">
                                <div class="progress-bar-confidence bg-<?= $result['status'] == 'success' ? 'success' : 'danger' ?>" 
                                     style="width: <?= $result['confidence'] ?>%">
                                    <?= $result['confidence'] ?>%
                                </div>
                            </div>
                        </div>

                        <!-- Recommendation -->
                        <div class="recommendation-box <?= $result['status'] ?>">
                            <h5>
                                <i class="fas fa-lightbulb"></i> Rekomendasi:
                            </h5>
                            <p class="mb-0"><?= $result['recommendation'] ?></p>
                        </div>

                        <!-- C4.5 Calculations -->
                        <div class="card mt-4" style="border: 2px solid var(--accent-teal); border-radius: 15px;">
                            <div class="card-header" style="background: linear-gradient(135deg, var(--accent-teal), var(--secondary-green)); color: white;">
                                <h5 class="mb-0"><i class="fas fa-calculator"></i> Perhitungan Algoritma C4.5</h5>
                            </div>
                            <div class="card-body">
                                <h6 class="text-primary"><i class="fas fa-brain"></i> Analisis Per Parameter:</h6>
                                <div class="table-responsive mb-3">
                                    <table class="table table-sm table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Parameter</th>
                                                <th>Status</th>
                                                <th>Alasan</th>
                                                <th>Score</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($result['details'] as $param => $detail): ?>
                                            <tr>
                                                <td><strong><?= $param ?></strong></td>
                                                <td>
                                                    <span class="badge bg-<?= $detail['status'] == 'Normal' ? 'success' : 'danger' ?>">
                                                        <?= $detail['status'] ?>
                                                    </span>
                                                </td>
                                                <td><?= $detail['reason'] ?></td>
                                                <td><span class="badge bg-info"><?= $detail['score'] ?></span></td>
                                            </tr>
                                            <?php endforeach; ?>
                                            <tr class="table-primary fw-bold">
                                                <td colspan="3">TOTAL SCORE</td>
                                                <td><span class="badge bg-primary fs-6"><?= $result['score'] ?></span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <h6 class="text-primary mt-4"><i class="fas fa-chart-pie"></i> Metrik C4.5:</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="alert alert-info">
                                            <strong>Entropy (E):</strong> <?= $result['c45_calculations']['entropy'] ?><br>
                                            <small>Mengukur ketidakpastian dalam dataset</small><br>
                                            <code>E(S) = -Σ(p × log₂(p))</code>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="alert alert-success">
                                            <strong>Information Gain:</strong> <?= $result['c45_calculations']['information_gain'] ?><br>
                                            <small>Pengurangan ketidakpastian setelah split</small><br>
                                            <code>Gain = 1 - Entropy</code>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="alert alert-warning">
                                            <strong>Gain Ratio:</strong> <?= $result['c45_calculations']['gain_ratio'] ?><br>
                                            <small>Normalisasi Information Gain</small><br>
                                            <code>GainRatio = Gain / SplitInfo</code>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="alert alert-primary">
                                            <strong>Purity:</strong> <?= $result['c45_calculations']['purity'] ?>%<br>
                                            <small>Tingkat kemurnian klasifikasi</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-light border">
                                    <h6><i class="fas fa-check-circle text-success"></i> Kesimpulan Algoritma C4.5:</h6>
                                    <p class="mb-2">
                                        Dari <strong><?= $result['c45_calculations']['total_params'] ?> parameter</strong> yang dianalisis:
                                    </p>
                                    <ul class="mb-0">
                                        <li><strong><?= $result['c45_calculations']['normal_count'] ?> parameter</strong> menunjukkan nilai Normal</li>
                                        <li><strong><?= $result['c45_calculations']['abnormal_count'] ?> parameter</strong> menunjukkan nilai Abnormal</li>
                                        <li>Total Score: <strong><?= $result['score'] ?></strong> <?= $result['score'] >= 4 ? '(≥ 4 = AbNormal)' : '(< 4 = Normal)' ?></li>
                                        <li>Confidence: <strong><?= $result['confidence'] ?>%</strong></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Grafik Visualisasi -->
                        <div class="card mt-4" style="border: 2px solid var(--accent-lime); border-radius: 15px;">
                            <div class="card-header" style="background: linear-gradient(135deg, var(--accent-lime), var(--primary-green)); color: white;">
                                <h5 class="mb-0"><i class="fas fa-chart-bar"></i> Visualisasi Hasil Deteksi</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="text-center">Distribusi Parameter</h6>
                                        <canvas id="parameterChart"></canvas>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-center">Score per Parameter</h6>
                                        <canvas id="scoreChart"></canvas>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <h6 class="text-center">Radar Chart - Nilai Parameter EKG</h6>
                                        <canvas id="radarChart" style="max-height: 400px;"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Data Input Table -->
                        <div class="data-table">
                            <h4 class="mb-3"><i class="fas fa-table"></i> Data Parameter EKG</h4>
                            <div class="table-responsive">
                                <table class="table table-parameter table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Parameter</th>
                                            <th>Nilai</th>
                                            <th>Rentang Normal</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>HR (Heart Rate)</strong></td>
                                            <td><?= $data['HR'] ?> bpm</td>
                                            <td>60-100 bpm</td>
                                            <td>
                                                <?php if ($data['HR'] >= 60 && $data['HR'] <= 100): ?>
                                                    <span class="badge bg-success">Normal</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Abnormal</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>P-R Interval</strong></td>
                                            <td><?= $data['PR'] ?> ms</td>
                                            <td>120-200 ms</td>
                                            <td>
                                                <?php if ($data['PR'] >= 120 && $data['PR'] <= 200): ?>
                                                    <span class="badge bg-success">Normal</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Abnormal</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>QRS Complex</strong></td>
                                            <td><?= $data['QRS'] ?> ms</td>
                                            <td>80-120 ms</td>
                                            <td>
                                                <?php if ($data['QRS'] >= 80 && $data['QRS'] <= 120): ?>
                                                    <span class="badge bg-success">Normal</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Abnormal</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>QT Interval</strong></td>
                                            <td><?= $data['QT'] ?> ms</td>
                                            <td>320-440 ms</td>
                                            <td>
                                                <?php if ($data['QT'] >= 320 && $data['QT'] <= 440): ?>
                                                    <span class="badge bg-success">Normal</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Abnormal</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>QTC (Corrected QT)</strong></td>
                                            <td><?= $data['QTC'] ?> ms</td>
                                            <td>350-450 ms</td>
                                            <td>
                                                <?php if ($data['QTC'] >= 350 && $data['QTC'] <= 450): ?>
                                                    <span class="badge bg-success">Normal</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Abnormal</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>AXIS</strong></td>
                                            <td><?= $data['AXIS'] ?>°</td>
                                            <td>-30° sampai +100°</td>
                                            <td>
                                                <?php if ($data['AXIS'] >= -30 && $data['AXIS'] <= 100): ?>
                                                    <span class="badge bg-success">Normal</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Abnormal</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>RV6</strong></td>
                                            <td><?= $data['RV6'] ?></td>
                                            <td>-</td>
                                            <td><span class="badge bg-secondary">-</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>SV1</strong></td>
                                            <td><?= $data['SV1'] ?></td>
                                            <td>-</td>
                                            <td><span class="badge bg-secondary">-</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>R+S</strong></td>
                                            <td><?= $data['RS'] ?></td>
                                            <td>-</td>
                                            <td><span class="badge bg-secondary">-</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="text-center mt-4">
                            <a href="<?= base_url('heartdetection') ?>" class="btn btn-primary btn-back">
                                <i class="fas fa-redo"></i> Deteksi Ulang
                            </a>
                            <button onclick="window.print()" class="btn btn-secondary btn-back">
                                <i class="fas fa-print"></i> Cetak Hasil
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // Animate progress bar
        window.addEventListener('load', function() {
            const progressBar = document.querySelector('.progress-bar-confidence');
            const width = progressBar.style.width;
            progressBar.style.width = '0%';
            setTimeout(() => {
                progressBar.style.width = width;
            }, 100);
        });

        // Data dari PHP
        const normalCount = <?= $result['c45_calculations']['normal_count'] ?>;
        const abnormalCount = <?= $result['c45_calculations']['abnormal_count'] ?>;
        
        // Data detail parameter
        const paramDetails = <?= json_encode($result['details']) ?>;
        const paramLabels = Object.keys(paramDetails);
        const paramScores = paramLabels.map(key => paramDetails[key].score);
        const paramStatuses = paramLabels.map(key => paramDetails[key].status);
        
        // Data input EKG
        const ekgData = {
            HR: <?= $data['HR'] ?>,
            PR: <?= $data['PR'] ?>,
            QRS: <?= $data['QRS'] ?>,
            QT: <?= $data['QT'] ?>,
            QTC: <?= $data['QTC'] ?>,
            AXIS: Math.abs(<?= $data['AXIS'] ?>)
        };

        // Chart 1: Pie Chart - Distribusi Parameter
        const ctx1 = document.getElementById('parameterChart').getContext('2d');
        new Chart(ctx1, {
            type: 'doughnut',
            data: {
                labels: ['Normal', 'Abnormal'],
                datasets: [{
                    data: [normalCount, abnormalCount],
                    backgroundColor: ['#10b981', '#ef4444'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: { size: 14, weight: 'bold' },
                            padding: 15
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = normalCount + abnormalCount;
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });

        // Chart 2: Bar Chart - Score per Parameter
        const ctx2 = document.getElementById('scoreChart').getContext('2d');
        const barColors = paramScores.map(score => {
            if (score >= 2) return '#ef4444'; // Red
            if (score == 1) return '#f59e0b'; // Orange
            return '#10b981'; // Green
        });
        
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: paramLabels,
                datasets: [{
                    label: 'Score',
                    data: paramScores,
                    backgroundColor: barColors,
                    borderColor: barColors.map(c => c),
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 3,
                        ticks: { stepSize: 1 }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            afterLabel: function(context) {
                                const param = paramLabels[context.dataIndex];
                                return paramDetails[param].reason;
                            }
                        }
                    }
                }
            }
        });

        // Chart 3: Radar Chart - Nilai Parameter EKG
        const ctx3 = document.getElementById('radarChart').getContext('2d');
        new Chart(ctx3, {
            type: 'radar',
            data: {
                labels: ['HR', 'P-R', 'QRS', 'QT', 'QTC', 'AXIS'],
                datasets: [{
                    label: 'Nilai Pasien',
                    data: [
                        ekgData.HR,
                        ekgData.PR,
                        ekgData.QRS,
                        ekgData.QT,
                        ekgData.QTC,
                        ekgData.AXIS
                    ],
                    backgroundColor: 'rgba(16, 185, 129, 0.2)',
                    borderColor: '#10b981',
                    borderWidth: 3,
                    pointBackgroundColor: '#10b981',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5
                }, {
                    label: 'Batas Normal (Max)',
                    data: [120, 200, 120, 440, 450, 100],
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    borderColor: '#ef4444',
                    borderWidth: 2,
                    borderDash: [5, 5],
                    pointBackgroundColor: '#ef4444',
                    pointRadius: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    r: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 50
                        },
                        pointLabels: {
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: { size: 12 },
                            padding: 15
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
