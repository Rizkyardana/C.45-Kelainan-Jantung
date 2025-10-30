<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualisasi Dataset - Sistem Deteksi Kelainan Jantung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background: rgba(255, 255, 255, 0.98) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-green), var(--accent-teal));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
        .card-header {
            background: linear-gradient(135deg, var(--primary-green), var(--accent-teal));
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 15px 25px;
        }
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-value {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--primary-green);
            margin: 10px 0;
        }
        .stat-label {
            color: #6b7280;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .table th {
            background-color: #f3f4f6;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }
        .badge-normal {
            background-color: #d1fae5;
            color: #065f46;
        }
        .badge-abnormal {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .chart-container {
            position: relative;
            height: 300px;
            margin-bottom: 30px;
        }
        .progress {
            height: 8px;
            border-radius: 4px;
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

    <div class="container py-5">
        <!-- Header -->
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h1 class="fw-bold" style="color: var(--dark-green);">
                    <i class="fas fa-chart-line me-2"></i>Visualisasi Dataset
                </h1>
                <p class="text-muted">Analisis data rekam medis untuk deteksi dini kelainan jantung</p>
            </div>
        </div>

        <!-- Statistik Utama -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-value"><?= $stats['total'] ?></div>
                    <div class="stat-label">Total Data</div>
                    <div class="d-flex justify-content-center mt-2">
                        <i class="fas fa-database fa-2x" style="color: var(--accent-teal);"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-value text-success"><?= $stats['normal'] ?></div>
                    <div class="stat-label">Normal</div>
                    <div class="d-flex justify-content-center mt-2">
                        <i class="fas fa-check-circle fa-2x" style="color: #10b981;"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-value text-danger"><?= $stats['abnormal'] ?></div>
                    <div class="stat-label">Abnormal</div>
                    <div class="d-flex justify-content-center mt-2">
                        <i class="fas fa-exclamation-triangle fa-2x" style="color: #ef4444;"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-value"><?= $stats['avgAge'] ?> <small class="text-muted">tahun</small></div>
                    <div class="stat-label">Rata-rata Usia</div>
                    <div class="d-flex justify-content-center mt-2">
                        <i class="fas fa-user-clock fa-2x" style="color: var(--accent-lime);"></i>
                    </div>
                </div>
            </div>
        </div>


        <!-- Tabel Data -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-table me-2"></i>Data Pemeriksaan EKG</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usia</th>
                                <th>Gender</th>
                                <th>HR</th>
                                <th>PR</th>
                                <th>QRS</th>
                                <th>QT</th>
                                <th>QTC</th>
                                <th>AXIS</th>
                                <th>RV6</th>
                                <th>SV1</th>
                                <th>R+S</th>
                                <th>Merokok</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dataset as $data): ?>
                            <tr>
                                <td>#<?= $data['id'] ?></td>
                                <td><?= $data['age'] ?> thn</td>
                                <td><?= $data['gender'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                                <td><?= $data['hr'] ?> bpm</td>
                                <td><?= $data['pr'] ?> ms</td>
                                <td><?= $data['qrs'] ?> ms</td>
                                <td><?= $data['qt'] ?> ms</td>
                                <td><?= $data['qtc'] ?> ms</td>
                                <td><?= $data['axis'] ?>°</td>
                                <td><?= $data['rv6'] ?> mV</td>
                                <td><?= $data['sv1'] ?> mV</td>
                                <td><?= $data['rs'] ?> mV</td>
                                <td><?= $data['smoking'] ?></td>
                                <td>
                                    <span class="badge rounded-pill <?= $data['status'] == 'Normal' ? 'badge-normal' : 'badge-abnormal' ?>">
                                        <?= $data['status'] ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Grafik Parameter EKG -->
        <div class="card mt-5">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Parameter EKG</h5>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="parameterTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="hr-tab" data-bs-toggle="tab" data-bs-target="#hr" type="button">
                            <i class="fas fa-heartbeat me-1"></i> Heart Rate
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pr-tab" data-bs-toggle="tab" data-bs-target="#pr" type="button">
                            <i class="fas fa-wave-square me-1"></i> PR Interval
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="qrs-tab" data-bs-toggle="tab" data-bs-target="#qrs" type="button">
                            <i class="fas fa-ruler-horizontal me-1"></i> QRS Duration
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="qt-tab" data-bs-toggle="tab" data-bs-target="#qt" type="button">
                            <i class="fas fa-stopwatch me-1"></i> QT Interval
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="qtc-tab" data-bs-toggle="tab" data-bs-target="#qtc" type="button">
                            <i class="fas fa-stopwatch-20 me-1"></i> QTc Interval
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="axis-tab" data-bs-toggle="tab" data-bs-target="#axis" type="button">
                            <i class="fas fa-compass me-1"></i> Heart Axis
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="rv6-tab" data-bs-toggle="tab" data-bs-target="#rv6" type="button">
                            <i class="fas fa-wave-square me-1"></i> RV6
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="sv1-tab" data-bs-toggle="tab" data-bs-target="#sv1" type="button">
                            <i class="fas fa-wave-square me-1"></i> SV1
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="rs-tab" data-bs-toggle="tab" data-bs-target="#rs" type="button">
                            <i class="fas fa-plus-circle me-1"></i> R+S
                        </button>
                    </li>
                </ul>
                <div class="tab-content p-3 border border-top-0 rounded-bottom" id="parameterTabsContent">
                    <!-- HR Chart -->
                    <div class="tab-pane fade show active" id="hr" role="tabpanel">
                        <div class="chart-container">
                            <canvas id="hrChart"></canvas>
                        </div>
                        <div class="mt-3">
                            <p class="mb-1"><strong>Kisaran Normal:</strong> 60-100 bpm</p>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small>0 bpm</small>
                                <small>60 bpm</small>
                                <small>100 bpm</small>
                                <small>200+ bpm</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- PR Interval Chart -->
                    <div class="tab-pane fade" id="pr" role="tabpanel">
                        <div class="chart-container">
                            <canvas id="prChart"></canvas>
                        </div>
                        <div class="mt-3">
                            <p class="mb-1"><strong>Kisaran Normal:</strong> 120-200 ms</p>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small>0 ms</small>
                                <small>120 ms</small>
                                <small>200 ms</small>
                                <small>300+ ms</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- QRS Duration Chart -->
                    <div class="tab-pane fade" id="qrs" role="tabpanel">
                        <div class="chart-container">
                            <canvas id="qrsChart"></canvas>
                        </div>
                        <div class="mt-3">
                            <p class="mb-1"><strong>Kisaran Normal:</strong> 80-120 ms</p>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small>0 ms</small>
                                <small>80 ms</small>
                                <small>120 ms</small>
                                <small>200+ ms</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- QT Interval Chart -->
                    <div class="tab-pane fade" id="qt" role="tabpanel">
                        <div class="chart-container">
                            <canvas id="qtChart"></canvas>
                        </div>
                        <div class="mt-3">
                            <p class="mb-1"><strong>Kisaran Normal:</strong> 350-450 ms</p>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small>0 ms</small>
                                <small>350 ms</small>
                                <small>450 ms</small>
                                <small>600+ ms</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- QTc Interval Chart -->
                    <div class="tab-pane fade" id="qtc" role="tabpanel">
                        <div class="chart-container">
                            <canvas id="qtcChart"></canvas>
                        </div>
                        <div class="mt-3">
                            <p class="mb-1"><strong>Kisaran Normal:</strong> &lt;440 ms (Pria), &lt;460 ms (Wanita)</p>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small>0 ms</small>
                                <small>350 ms</small>
                                <small>440/460 ms</small>
                                <small>500+ ms</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Heart Axis Chart -->
                    <div class="tab-pane fade" id="axis" role="tabpanel">
                        <div class="chart-container">
                            <canvas id="axisChart"></canvas>
                        </div>
                        <div class="mt-3">
                            <p class="mb-1"><strong>Kisaran Normal:</strong> -30° hingga +90°</p>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small>-90°</small>
                                <small>-30°</small>
                                <small>+90°</small>
                                <small>+180°</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- RV6 Chart -->
                    <div class="tab-pane fade" id="rv6" role="tabpanel">
                        <div class="chart-container">
                            <canvas id="rv6Chart"></canvas>
                        </div>
                        <div class="mt-3">
                            <p class="mb-1"><strong>Kisaran Normal:</strong> &lt; 2.5 mV</p>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small>0 mV</small>
                                <small>2.5 mV</small>
                                <small>5+ mV</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- SV1 Chart -->
                    <div class="tab-pane fade" id="sv1" role="tabpanel">
                        <div class="chart-container">
                            <canvas id="sv1Chart"></canvas>
                        </div>
                        <div class="mt-3">
                            <p class="mb-1"><strong>Kisaran Normal:</strong> &lt; 2.0 mV</p>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small>0 mV</small>
                                <small>2.0 mV</small>
                                <small>4+ mV</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- R+S Chart -->
                    <div class="tab-pane fade" id="rs" role="tabpanel">
                        <div class="chart-container">
                            <canvas id="rsChart"></canvas>
                        </div>
                        <div class="mt-3">
                            <p class="mb-1"><strong>Kisaran Normal:</strong> &lt; 3.5 mV</p>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small>0 mV</small>
                                <small>3.5 mV</small>
                                <small>7+ mV</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Inisialisasi variabel global
        const chartInstances = {};
        
        // Fungsi untuk memuat data dari tabel
        function loadChartData() {
            const table = document.querySelector('table tbody');
            const rows = Array.from(table.rows);
            
            const data = {
                labels: [],
                hr: [], pr: [], qrs: [], qt: [], qtc: [], 
                axis: [], rv6: [], sv1: [], rs: [],
                status: []
            };
            
            rows.forEach(row => {
                const cells = row.cells;
                if (cells.length >= 13) {
                    data.labels.push(cells[0].textContent);
                    data.hr.push(parseFloat(cells[3].textContent) || 0);
                    data.pr.push(parseFloat(cells[4].textContent) || 0);
                    data.qrs.push(parseFloat(cells[5].textContent) || 0);
                    data.qt.push(parseFloat(cells[6].textContent) || 0);
                    data.qtc.push(parseFloat(cells[7].textContent) || 0);
                    data.axis.push(parseFloat(cells[8].textContent) || 0);
                    data.rv6.push(parseFloat(cells[9].textContent) || 0);
                    data.sv1.push(parseFloat(cells[10].textContent) || 0);
                    data.rs.push(parseFloat(cells[11].textContent) || 0);
                    data.status.push(cells[13].textContent.trim());
                }
            });
            
            return data;
        }
        
        // Fungsi untuk membuat chart
        function createChart(chartId, data, label, unit, minY, maxY) {
            const ctx = document.getElementById(chartId);
            if (!ctx) return null;
            
            // Hapus chart yang sudah ada
            if (chartInstances[chartId]) {
                chartInstances[chartId].destroy();
            }
            
            // Buat chart baru
            chartInstances[chartId] = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: label,
                        data: data.data,
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2,
                        pointBackgroundColor: data.status.map(s => 
                            s === 'Normal' ? '#10b981' : '#ef4444'
                        ),
                        pointBorderColor: '#fff',
                        pointHoverRadius: 5,
                        pointHoverBorderWidth: 2,
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${label}: ${context.raw} ${unit}`;
                                }
                            }
                        },
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            min: minY,
                            max: maxY,
                            title: {
                                display: true,
                                text: unit
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }
        
        // Inisialisasi saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            // Muat data dari tabel
            const chartData = loadChartData();
            
            // Inisialisasi chart pertama (HR)
            createChart('hrChart', chartData.hr, 'Heart Rate', 'bpm', 40, 120);
            
            // Tambahkan event listener untuk tab
            const tabEls = document.querySelectorAll('button[data-bs-toggle="tab"]');
            tabEls.forEach(tabEl => {
                tabEl.addEventListener('shown.bs.tab', function (event) {
                    const targetId = event.target.getAttribute('data-bs-target').substring(1);
                    const chartId = `${targetId}Chart`;
                    
                    // Pastikan chart belum dibuat sebelumnya
                    if (!chartInstances[chartId]) {
                        switch(targetId) {
                            case 'hr':
                                createChart(chartId, {
                                    labels: chartData.labels,
                                    data: chartData.hr,
                                    status: chartData.status
                                }, 'Heart Rate', 'bpm', 40, 120);
                                break;
                            case 'pr':
                                createChart(chartId, {
                                    labels: chartData.labels,
                                    data: chartData.pr,
                                    status: chartData.status
                                }, 'PR Interval', 'ms', 100, 200);
                                break;
                            case 'qrs':
                                createChart(chartId, {
                                    labels: chartData.labels,
                                    data: chartData.qrs,
                                    status: chartData.status
                                }, 'QRS Duration', 'ms', 60, 120);
                                break;
                            case 'qt':
                                createChart(chartId, {
                                    labels: chartData.labels,
                                    data: chartData.qt,
                                    status: chartData.status
                                }, 'QT Interval', 'ms', 300, 500);
                                break;
                            case 'qtc':
                                createChart(chartId, {
                                    labels: chartData.labels,
                                    data: chartData.qtc,
                                    status: chartData.status
                                }, 'QTC Interval', 'ms', 350, 500);
                                break;
                            case 'axis':
                                createChart(chartId, {
                                    labels: chartData.labels,
                                    data: chartData.axis,
                                    status: chartData.status
                                }, 'QRS Axis', '°', -90, 180);
                                break;
                            case 'rv6':
                                createChart(chartId, {
                                    labels: chartData.labels,
                                    data: chartData.rv6,
                                    status: chartData.status
                                }, 'RV6', 'mV', 0, 5);
                                break;
                            case 'sv1':
                                createChart(chartId, {
                                    labels: chartData.labels,
                                    data: chartData.sv1,
                                    status: chartData.status
                                }, 'SV1', 'mV', 0, 4);
                                break;
                            case 'rs':
                                createChart(chartId, {
                                    labels: chartData.labels,
                                    data: chartData.rs,
                                    status: chartData.status
                                }, 'R+S', 'mV', 0, 7);
                                break;
                        }
                    }
                });
            });
        });
        
        // Fungsi untuk memuat data dari tabel
        function loadChartData() {
            const table = document.querySelector('table tbody');
            const rows = Array.from(table.rows);
            
            const data = {
                labels: [],
                hr: [], pr: [], qrs: [], qt: [], qtc: [], 
                axis: [], rv6: [], sv1: [], rs: [],
                status: []
            };
            
            rows.forEach(row => {
                const cells = row.cells;
                if (cells.length >= 13) {
                    data.labels.push(cells[0].textContent);
                    data.hr.push(parseFloat(cells[3].textContent) || 0);
                    data.pr.push(parseFloat(cells[4].textContent) || 0);
                    data.qrs.push(parseFloat(cells[5].textContent) || 0);
                    data.qt.push(parseFloat(cells[6].textContent) || 0);
                    data.qtc.push(parseFloat(cells[7].textContent) || 0);
                    data.axis.push(parseFloat(cells[8].textContent) || 0);
                    data.rv6.push(parseFloat(cells[9].textContent) || 0);
                    data.sv1.push(parseFloat(cells[10].textContent) || 0);
                    data.rs.push(parseFloat(cells[11].textContent) || 0);
                    data.status.push(cells[13].textContent.trim());
                }
            });
            
            return data;
        }
        
        // Fungsi untuk membuat chart
        function createChart(chartId, data, label, unit, minY, maxY) {
            const ctx = document.getElementById(chartId);
            if (!ctx) return null;
            
            // Hapus chart yang sudah ada
            if (chartInstances[chartId]) {
                chartInstances[chartId].destroy();
            }
            
            // Buat chart baru
            chartInstances[chartId] = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: label,
                        data: data,
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2,
                        pointBackgroundColor: chartData.status.map(s => 
                            s === 'Normal' ? '#10b981' : '#ef4444'
                        ),
                        pointBorderColor: '#fff',
                        pointHoverRadius: 5,
                        pointHoverBorderWidth: 2,
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${label}: ${context.raw} ${unit}`;
                                }
                            }
                        },
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            min: minY,
                            max: maxY,
                            title: {
                                display: true,
                                text: unit
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }
        
        // Inisialisasi saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            // Muat data dari tabel
            chartData = loadChartData();
            
            // Inisialisasi chart pertama (HR)
            createChart('hrChart', chartData.hr, 'Heart Rate', 'bpm', 40, 120);
            
            // Tambahkan event listener untuk tab
            const tabEls = document.querySelectorAll('button[data-bs-toggle="tab"]');
            tabEls.forEach(tabEl => {
                tabEl.addEventListener('shown.bs.tab', function (event) {
                    const targetId = event.target.getAttribute('data-bs-target').substring(1);
                    const chartId = `${targetId}Chart`;
                    
                    // Pastikan chart belum dibuat sebelumnya
                    if (!chartInstances[chartId]) {
                        switch(targetId) {
                            case 'hr':
                                createChart(chartId, chartData.hr, 'Heart Rate', 'bpm', 40, 120);
                                break;
                            case 'pr':
                                createChart(chartId, chartData.pr, 'PR Interval', 'ms', 100, 200);
                                break;
                            case 'qrs':
                                createChart(chartId, chartData.qrs, 'QRS Duration', 'ms', 60, 120);
                                break;
                            case 'qt':
                                createChart(chartId, chartData.qt, 'QT Interval', 'ms', 300, 500);
                                break;
                            case 'qtc':
                                createChart(chartId, chartData.qtc, 'QTC Interval', 'ms', 350, 500);
                                break;
                            case 'axis':
                                createChart(chartId, chartData.axis, 'QRS Axis', '°', -90, 180);
                                break;
                        }
                    }
                });
            });
        });
        
        // Fungsi untuk membuat chart
        function createChart(chartId, data, label, unit, yMin, yMax) {
            const ctx = document.getElementById(chartId);
            if (!ctx) {
                console.error(`Elemen dengan ID ${chartId} tidak ditemukan`);
                return null;
            }
            
            // Hapus chart yang sudah ada
            if (chartInstances[chartId]) {
                chartInstances[chartId].destroy();
            }

            // Format data untuk kompatibilitas
            let chartData, statusData, labels;
            
            if (Array.isArray(data)) {
                // Format lama: data langsung berupa array
                chartData = data;
                statusData = [];
                labels = [];
                
                // Ambil data dari tabel jika tersedia
                const table = document.querySelector('table tbody');
                if (table) {
                    const rows = Array.from(table.rows);
                    labels = rows.map((_, i) => `Data ${i + 1}`);
                    statusData = Array(rows.length).fill('Normal'); // Default status
                }
            } else if (data && data.data) {
                // Format baru: data dalam format object {data: [...], status: [...], labels: [...]}
                chartData = data.data;
                statusData = data.status || [];
                labels = data.labels || [];
            } else {
                console.error('Format data tidak valid', data);
                return null;
            }

            // Siapkan dataset
            const dataset = {
                label: label,
                data: chartData,
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 2,
                pointBorderColor: '#fff',
                pointHoverRadius: 5,
                pointHoverBorderWidth: 2,
                tension: 0.3,
                fill: true
            };

            // Tambahkan warna point jika status tersedia
            if (statusData.length > 0) {
                dataset.pointBackgroundColor = statusData.map(s => 
                    s === 'Normal' ? '#10b981' : '#ef4444'
                );
            }
            
            // Buat chart baru
            chartInstances[chartId] = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [dataset]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${label}: ${context.raw} ${unit}`;
                                }
                            }
                        },
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            min: yMin,
                            max: yMax,
                            title: {
                                display: true,
                                text: unit
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }
    </script>
</body>
</html>
