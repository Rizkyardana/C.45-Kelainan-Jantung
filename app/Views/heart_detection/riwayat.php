<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Riwayat Pemeriksaan<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container my-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-history me-2"></i>Riwayat Pemeriksaan</h4>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <?php if (empty($daftar_pasien)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                    <h5>Belum ada riwayat pemeriksaan</h5>
                    <p class="text-muted">Lakukan pemeriksaan terlebih dahulu untuk melihat riwayat</p>
                    <a href="<?= base_url('heartdetection') ?>" class="btn btn-primary mt-3">
                        <i class="fas fa-plus-circle me-2"></i>Pemeriksaan Baru
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Usia</th>
                                <th>Terakhir Update</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($daftar_pasien as $nik => $pasien): ?>
                                <tr>
                                    <td><?= $nik ?></td>
                                    <td><?= esc($pasien['nama'] ?? '-') ?></td>
                                    <td><?= ($pasien['jenis_kelamin'] ?? '') == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                                    <td>
                                        <?php 
                                        if (!empty($pasien['tanggal_lahir'])) {
                                            $birthDate = new \DateTime($pasien['tanggal_lahir']);
                                            $today = new \DateTime('today');
                                            $umur = $birthDate->diff($today)->y;
                                            echo $umur . ' tahun';
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                    <td><?= !empty($pasien['terakhir_update']) ? date('d/m/Y H:i', strtotime($pasien['terakhir_update'])) : '-' ?></td>
                                    <td>
                                        <a href="<?= base_url('heartdetection/detail/' . $nik) ?>" class="btn btn-sm btn-info text-white">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
