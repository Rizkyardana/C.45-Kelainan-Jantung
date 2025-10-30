<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class HeartDetection extends BaseController
{
    public function index()
    {
        return view('heart_detection/index');
    }

    public function detect()
    {
        // Ambil input dari form
        $nik = $this->request->getPost('nik');
        $dataPribadi = [
            'nama' => $this->request->getPost('nama'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'alamat' => $this->request->getPost('alamat'),
            'no_hp' => $this->request->getPost('no_hp'),
            'email' => $this->request->getPost('email')
        ];

        $dataEkg = [
            'HR' => $this->request->getPost('hr'),
            'PR' => $this->request->getPost('pr'),
            'QRS' => $this->request->getPost('qrs'),
            'QT' => $this->request->getPost('qt'),
            'QTC' => $this->request->getPost('qtc'),
            'AXIS' => $this->request->getPost('axis'),
            'RV6' => $this->request->getPost('rv6'),
            'SV1' => $this->request->getPost('sv1'),
            'RS' => $this->request->getPost('rs'),
            'riwayat_keluarga' => $this->request->getPost('riwayat_keluarga'),
            'riwayat_penyakit' => $this->request->getPost('riwayat_penyakit'),
            'merokok' => $this->request->getPost('merokok'),
            'alkohol' => $this->request->getPost('alkohol'),
            'aktivitas_fisik' => $this->request->getPost('aktivitas_fisik')
        ];

        // Simpan data ke dalam session untuk keperluan demo (tanpa database)
        $session = session();
        $pasien = $session->get('pasien') ?? [];
        
        // Gabungkan data pribadi dan EKG
        $dataPasien = array_merge(
            ['nik' => $nik],
            $dataPribadi,
            $dataEkg,
            ['terakhir_update' => date('Y-m-d H:i:s')]
        );
        
        // Simpan/update data pasien berdasarkan NIK
        $pasien[$nik] = $dataPasien;
        $session->set('pasien', $pasien);

        // Load library C45
        $c45 = new \App\Libraries\C45Algorithm();
        
        // Lakukan klasifikasi
        $result = $c45->classify($dataEkg);

        // Tampilkan hasil
        return view('heart_detection/result', [
            'data' => $dataEkg,
            'data_pribadi' => $dataPribadi,
            'nik' => $nik,
            'result' => $result,
            'is_update' => isset($pasien[$nik]) // Flag untuk menandai apakah ini update data
        ]);
    }

    public function about()
    {
        return view('heart_detection/about');
    }

    public function riwayat()
    {
        $session = session();
        $pasien = $session->get('pasien') ?? [];
        
        return view('heart_detection/riwayat', [
            'daftar_pasien' => $pasien
        ]);
    }
    
    public function detail($nik)
    {
        $session = session();
        $pasien = $session->get('pasien') ?? [];
        
        if (!isset($pasien[$nik])) {
            return redirect()->to('/heartdetection/riwayat')->with('error', 'Data pasien tidak ditemukan');
        }
        
        return view('heart_detection/detail', [
            'pasien' => $pasien[$nik],
            'nik' => $nik
        ]);
    }
    
    public function dataset()
    {
        // Data dummy untuk keperluan prototype
        $dataset = [
            ['id' => 1, 'hr' => 72, 'pr' => 120, 'qrs' => 90, 'qt' => 340, 'qtc' => 420, 'axis' => 45, 'rv6' => 1.2, 'sv1' => 1.5, 'rs' => 2.7, 'status' => 'Normal', 'age' => 45, 'gender' => 'L', 'smoking' => 'Tidak'],
            ['id' => 2, 'hr' => 85, 'pr' => 140, 'qrs' => 95, 'qt' => 360, 'qtc' => 450, 'axis' => 60, 'rv6' => 1.8, 'sv1' => 2.1, 'rs' => 3.9, 'status' => 'AbNormal', 'age' => 52, 'gender' => 'P', 'smoking' => 'Ya'],
            ['id' => 3, 'hr' => 68, 'pr' => 110, 'qrs' => 85, 'qt' => 320, 'qtc' => 400, 'axis' => 30, 'rv6' => 0.9, 'sv1' => 1.2, 'rs' => 2.1, 'status' => 'Normal', 'age' => 38, 'gender' => 'L', 'smoking' => 'Tidak'],
            ['id' => 4, 'hr' => 92, 'pr' => 150, 'qrs' => 100, 'qt' => 380, 'qtc' => 470, 'axis' => 75, 'rv6' => 2.1, 'sv1' => 2.5, 'rs' => 4.6, 'status' => 'AbNormal', 'age' => 61, 'gender' => 'P', 'smoking' => 'Mantan'],
            ['id' => 5, 'hr' => 75, 'pr' => 130, 'qrs' => 88, 'qt' => 350, 'qtc' => 430, 'axis' => 50, 'rv6' => 1.1, 'sv1' => 1.4, 'rs' => 2.5, 'status' => 'Normal', 'age' => 42, 'gender' => 'L', 'smoking' => 'Tidak'],
            ['id' => 6, 'hr' => 88, 'pr' => 145, 'qrs' => 98, 'qt' => 370, 'qtc' => 460, 'axis' => 70, 'rv6' => 2.0, 'sv1' => 2.3, 'rs' => 4.3, 'status' => 'AbNormal', 'age' => 58, 'gender' => 'P', 'smoking' => 'Ya'],
            ['id' => 7, 'hr' => 70, 'pr' => 125, 'qrs' => 87, 'qt' => 345, 'qtc' => 425, 'axis' => 48, 'rv6' => 1.0, 'sv1' => 1.3, 'rs' => 2.3, 'status' => 'Normal', 'age' => 47, 'gender' => 'L', 'smoking' => 'Tidak'],
            ['id' => 8, 'hr' => 95, 'pr' => 155, 'qrs' => 105, 'qt' => 390, 'qtc' => 480, 'axis' => 80, 'rv6' => 2.3, 'sv1' => 2.7, 'rs' => 5.0, 'status' => 'AbNormal', 'age' => 65, 'gender' => 'P', 'smoking' => 'Ya'],
            ['id' => 9, 'hr' => 65, 'pr' => 115, 'qrs' => 82, 'qt' => 330, 'qtc' => 410, 'axis' => 40, 'rv6' => 0.8, 'sv1' => 1.1, 'rs' => 1.9, 'status' => 'Normal', 'age' => 35, 'gender' => 'L', 'smoking' => 'Tidak'],
            ['id' => 10, 'hr' => 90, 'pr' => 148, 'qrs' => 102, 'qt' => 375, 'qtc' => 465, 'axis' => 78, 'rv6' => 2.2, 'sv1' => 2.6, 'rs' => 4.8, 'status' => 'AbNormal', 'age' => 70, 'gender' => 'P', 'smoking' => 'Mantan']
        ];

        // Hitung statistik
        $totalData = count($dataset);
        $normalCount = count(array_filter($dataset, fn($item) => $item['status'] === 'Normal'));
        $abnormalCount = $totalData - $normalCount;
        $avgAge = array_sum(array_column($dataset, 'age')) / $totalData;
        $genderCount = [
            'L' => count(array_filter($dataset, fn($item) => $item['gender'] === 'L')),
            'P' => count(array_filter($dataset, fn($item) => $item['gender'] === 'P'))
        ];
        $smokingStatus = [
            'Ya' => count(array_filter($dataset, fn($item) => $item['smoking'] === 'Ya')),
            'Tidak' => count(array_filter($dataset, fn($item) => $item['smoking'] === 'Tidak')),
            'Mantan' => count(array_filter($dataset, fn($item) => $item['smoking'] === 'Mantan'))
        ];

        // Siapkan data untuk chart
        $chartData = [
            'labels' => array_column($dataset, 'id'),
            'hr' => array_column($dataset, 'hr'),
            'pr' => array_column($dataset, 'pr'),
            'qrs' => array_column($dataset, 'qrs'),
            'qt' => array_column($dataset, 'qt'),
            'qtc' => array_column($dataset, 'qtc'),
            'status' => array_column($dataset, 'status')
        ];

        return view('heart_detection/dataset_visualization', [
            'dataset' => $dataset,
            'stats' => [
                'total' => $totalData,
                'normal' => $normalCount,
                'abnormal' => $abnormalCount,
                'avgAge' => round($avgAge, 1),
                'gender' => $genderCount,
                'smoking' => $smokingStatus
            ],
            'chartData' => $chartData
        ]);
    }
}
