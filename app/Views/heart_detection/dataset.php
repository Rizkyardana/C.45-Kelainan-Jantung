<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dataset - Sistem Deteksi Kelainan Jantung</title>
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
        body {
            background: linear-gradient(135deg, #059669 0%, #10b981 50%, #84cc16 100%);
            min-height: 100vh;
        }
        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }
        .navbar-brand {
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-green), var(--accent-teal));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 1.6rem;
            padding: 0;
        }
        .nav-link {
            font-weight: 500;
            padding: 0.5rem 1rem;
            margin: 0 0.2rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }
        .nav-link:hover {
            background: rgba(16, 185, 129, 0.1);
        }
        .nav-link.active {
            color: var(--primary-green) !important;
            font-weight: 600;
        }
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            margin: 30px 0;
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
        .table {
            font-size: 0.9rem;
        }
        .badge-normal {
            background: #28a745;
        }
        .badge-abnormal {
            background: #dc3545;
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
                <h3><i class="fas fa-database"></i> Dataset Training</h3>
                <p class="mb-0">Data Rekam Medis Elektrokardiogram untuk Training Algoritma C4.5</p>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Info:</strong> Dataset ini berisi <?= count($dataset) ?> data training dari rekam medis elektrokardiogram.
                </div>

                <div class="table-responsive">
                    <table id="datasetTable" class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>GOAL</th>
                                <th>HR</th>
                                <th>P-R</th>
                                <th>QRS</th>
                                <th>QT</th>
                                <th>QTC</th>
                                <th>AXIS</th>
                                <th>RV6</th>
                                <th>SV1</th>
                                <th>R+S</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($dataset as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <span class="badge badge-<?= $row['GOAL'] == 'Normal' ? 'normal' : 'abnormal' ?>">
                                        <?= $row['GOAL'] ?>
                                    </span>
                                </td>
                                <td><?= $row['HR'] ?></td>
                                <td><?= $row['PR'] ?></td>
                                <td><?= $row['QRS'] ?></td>
                                <td><?= $row['QT'] ?></td>
                                <td><?= $row['QTC'] ?></td>
                                <td><?= $row['AXIS'] ?></td>
                                <td><?= $row['RV6'] ?></td>
                                <td><?= $row['SV1'] ?></td>
                                <td><?= $row['RS'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <h5>Statistik Dataset:</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h3><?= count(array_filter($dataset, fn($d) => $d['GOAL'] == 'Normal')) ?></h3>
                                    <p>Data Normal</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-danger text-white">
                                <div class="card-body">
                                    <h3><?= count(array_filter($dataset, fn($d) => $d['GOAL'] == 'AbNormal')) ?></h3>
                                    <p>Data AbNormal</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#datasetTable').DataTable({
                pageLength: 10,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
                }
            });
        });
    </script>
</body>
</html>
