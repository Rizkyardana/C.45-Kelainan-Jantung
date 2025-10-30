<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Detail Pasien - <?= $pasien['nama'] ?? 'Tidak Diketahui' ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <a href="<?= base_url('heartdetection/riwayat') ?>" class="text-decoration-none text-dark">
                <i class="fas fa-arrow-left me-2"></i>
            </a>
            Detail Pasien
        </h2>
        <a href="<?= base_url('heartdetection') ?>?nik=<?= $nik ?>" class="btn btn-primary">
            <i class="fas fa-edit me-2"></i>Update Data
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-user me-2"></i>Data Pribadi</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">NIK</th>
                            <td><?= $nik ?></td>
                        </tr>
                        <tr>
                            <th>Nama Lengkap</th>
                            <td><?= esc($pasien['nama'] ?? '-') ?></td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td><?= ($pasien['jenis_kelamin'] ?? '') == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Tanggal Lahir</th>
                            <td><?= !empty($pasien['tanggal_lahir']) ? date('d/m/Y', strtotime($pasien['tanggal_lahir'])) : '-' ?></td>
                        </tr>
                        <tr>
                            <th>No. HP</th>
                            <td><?= esc($pasien['no_hp'] ?? '-') ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?= esc($pasien['email'] ?? '-') ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-12">
                    <table class="table table-borderless">
                        <tr>
                            <th width="15%">Alamat</th>
                            <td><?= esc($pasien['alamat'] ?? '-') ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Kesehatan -->
    <div class="card shadow mb-4">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-notes-medical me-2"></i>Riwayat Kesehatan</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="60%">Riwayat Penyakit Jantung Keluarga</th>
                            <td><?= !empty($pasien['riwayat_keluarga']) ? $pasien['riwayat_keluarga'] : 'Tidak Ada' ?></td>
                        </tr>
                        <tr>
                            <th>Riwayat Penyakit Lainnya</th>
                            <td><?= !empty($pasien['riwayat_penyakit']) ? $pasien['riwayat_penyakit'] : 'Tidak Ada' ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Gaya Hidup -->
    <div class="card shadow mb-4">
        <div class="card-header bg-warning">
            <h5 class="mb-0"><i class="fas fa-heartbeat me-2"></i>Gaya Hidup</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="60%">Status Merokok</th>
                            <td><?= $pasien['merokok'] ?? '-' ?></td>
                        </tr>
                        <tr>
                            <th>Konsumsi Alkohol</th>
                            <td><?= $pasien['alkohol'] ?? '-' ?></td>
                        </tr>
                        <tr>
                            <th>Aktivitas Fisik</th>
                            <td><?= $pasien['aktivitas_fisik'] ?? '-' ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Hasil EKG -->
    <div class="card shadow mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0"><i class="fas fa-heartbeat me-2"></i>Hasil Pemeriksaan EKG</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Parameter</th>
                            <th>Nilai</th>
                            <th>Satuan</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Heart Rate (HR)</td>
                            <td><?= $pasien['HR'] ?? '-' ?></td>
                            <td>bpm</td>
                            <td>Normal: 60-100 bpm</td>
                        </tr>
                        <tr>
                            <td>Interval PR</td>
                            <td><?= $pasien['PR'] ?? '-' ?></td>
                            <td>ms</td>
                            <td>Normal: 120-200 ms</td>
                        </tr>
                        <tr>
                            <td>Interval QRS</td>
                            <td><?= $pasien['QRS'] ?? '-' ?></td>
                            <td>ms</td>
                            <td>Normal: 60-100 ms</td>
                        </tr>
                        <tr>
                            <td>Interval QT</td>
                            <td><?= $pasien['QT'] ?? '-' ?></td>
                            <td>ms</td>
                            <td>Bergantung pada HR</td>
                        </tr>
                        <tr>
                            <td>QTC</td>
                            <td><?= $pasien['QTC'] ?? '-' ?></td>
                            <td>ms</td>
                            <td>Normal: &lt;440 ms</td>
                        </tr>
                        <tr>
                            <td>Axis</td>
                            <td><?= $pasien['AXIS'] ?? '-' ?></td>
                            <td>derajat</td>
                            <td>Normal: -30° sampai +90°</td>
                        </tr>
                        <tr>
                            <td>RV6</td>
                            <td><?= $pasien['RV6'] ?? '-' ?></td>
                            <td>mm</td>
                            <td>Normal: &lt;20 mm</td>
                        </tr>
                        <tr>
                            <td>SV1</td>
                            <td><?= $pasien['SV1'] ?? '-' ?></td>
                            <td>mm</td>
                            <td>Normal: &lt;30 mm</td>
                        </tr>
                        <tr>
                            <td>R + S</td>
                            <td><?= $pasien['RS'] ?? '-' ?></td>
                            <td>mm</td>
                            <td>Normal: &lt;35 mm</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="text-center mb-5">
        <a href="<?= base_url('heartdetection') ?>" class="btn btn-primary me-2">
            <i class="fas fa-plus-circle me-2"></i>Pemeriksaan Baru
        </a>
        <a href="<?= base_url('heartdetection/riwayat') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
        </a>
    </div>
</div>
<?= $this->endSection() ?>
