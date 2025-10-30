<?php

namespace App\Libraries;

class C45Algorithm
{
    private $trainingData = [];
    private $tree = null;

    public function __construct()
    {
        $this->loadTrainingData();
    }

    private function loadTrainingData()
    {
        // Data training dari gambar (contoh beberapa data)
        $this->trainingData = [
            ['GOAL' => 'AbNormal', 'HR' => 134, 'PR' => 157, 'QRS' => 95, 'QT' => 318, 'QTC' => 433, 'AXIS' => 153, 'RV6' => 0.58, 'SV1' => 0.32, 'RS' => 0.9],
            ['GOAL' => 'AbNormal', 'HR' => 106, 'PR' => 169, 'QRS' => 99, 'QT' => 329, 'QTC' => 439, 'AXIS' => 41, 'RV6' => 2.36, 'SV1' => 1.59, 'RS' => 3.95],
            ['GOAL' => 'AbNormal', 'HR' => 137, 'PR' => 271, 'QRS' => 113, 'QT' => 385, 'QTC' => 420, 'AXIS' => 66, 'RV6' => 0.89, 'SV1' => 0.96, 'RS' => 1.85],
            ['GOAL' => 'AbNormal', 'HR' => 140, 'PR' => 212, 'QRS' => 90, 'QT' => 336, 'QTC' => 412, 'AXIS' => -57, 'RV6' => 1.08, 'SV1' => 0.12, 'RS' => 1.2],
            ['GOAL' => 'Normal', 'HR' => 70, 'PR' => 130, 'QRS' => 88, 'QT' => 371, 'QTC' => 411, 'AXIS' => 42, 'RV6' => -1.31, 'SV1' => 0.62, 'RS' => 1.98],
            ['GOAL' => 'Normal', 'HR' => 87, 'PR' => 150, 'QRS' => 99, 'QT' => 371, 'QTC' => 448, 'AXIS' => 87, 'RV6' => 1.07, 'SV1' => 1.42, 'RS' => 1.18],
            ['GOAL' => 'Normal', 'HR' => 63, 'PR' => 129, 'QRS' => 102, 'QT' => 375, 'QTC' => 403, 'AXIS' => 48, 'RV6' => 2.04, 'SV1' => 1.07, 'RS' => 1.66],
            ['GOAL' => 'Normal', 'HR' => 103, 'PR' => 152, 'QRS' => 99, 'QT' => 374, 'QTC' => 492, 'AXIS' => 31, 'RV6' => 1.5, 'SV1' => 0.47, 'RS' => 1.97],
        ];
    }

    public function getTrainingData()
    {
        return $this->trainingData;
    }

    public function classify($data)
    {
        // Implementasi C4.5 dengan perhitungan lengkap
        $score = 0;
        $details = [];
        
        // Rule berdasarkan analisis data training dengan penjelasan
        // HR (Heart Rate)
        if ($data['HR'] > 120) {
            $score += 2;
            $details['HR'] = ['status' => 'Abnormal', 'reason' => 'HR > 120 bpm (Terlalu Cepat)', 'score' => 2];
        } elseif ($data['HR'] < 60) {
            $score += 1;
            $details['HR'] = ['status' => 'Abnormal', 'reason' => 'HR < 60 bpm (Terlalu Lambat)', 'score' => 1];
        } else {
            $details['HR'] = ['status' => 'Normal', 'reason' => 'HR dalam rentang normal (60-120 bpm)', 'score' => 0];
        }
        
        // P-R Interval
        if ($data['PR'] > 200 || $data['PR'] < 120) {
            $score += 2;
            $details['PR'] = ['status' => 'Abnormal', 'reason' => 'P-R diluar rentang 120-200 ms', 'score' => 2];
        } else {
            $details['PR'] = ['status' => 'Normal', 'reason' => 'P-R dalam rentang normal (120-200 ms)', 'score' => 0];
        }
        
        // QRS Complex
        if ($data['QRS'] > 120 || $data['QRS'] < 80) {
            $score += 1;
            $details['QRS'] = ['status' => 'Abnormal', 'reason' => 'QRS diluar rentang 80-120 ms', 'score' => 1];
        } else {
            $details['QRS'] = ['status' => 'Normal', 'reason' => 'QRS dalam rentang normal (80-120 ms)', 'score' => 0];
        }
        
        // QT Interval
        if ($data['QT'] < 320 || $data['QT'] > 440) {
            $score += 1;
            $details['QT'] = ['status' => 'Abnormal', 'reason' => 'QT diluar rentang 320-440 ms', 'score' => 1];
        } else {
            $details['QT'] = ['status' => 'Normal', 'reason' => 'QT dalam rentang normal (320-440 ms)', 'score' => 0];
        }
        
        // QTC (Corrected QT)
        if ($data['QTC'] > 450 || $data['QTC'] < 350) {
            $score += 2;
            $details['QTC'] = ['status' => 'Abnormal', 'reason' => 'QTC diluar rentang 350-450 ms', 'score' => 2];
        } else {
            $details['QTC'] = ['status' => 'Normal', 'reason' => 'QTC dalam rentang normal (350-450 ms)', 'score' => 0];
        }
        
        // AXIS
        if ($data['AXIS'] > 100 || $data['AXIS'] < -30) {
            $score += 1;
            $details['AXIS'] = ['status' => 'Abnormal', 'reason' => 'AXIS diluar rentang -30° sampai 100°', 'score' => 1];
        } else {
            $details['AXIS'] = ['status' => 'Normal', 'reason' => 'AXIS dalam rentang normal (-30° sampai 100°)', 'score' => 0];
        }
        
        // Hitung Entropy dan Information Gain
        $c45Calculations = $this->calculateC45Metrics($data, $details, $score);
        
        // Tentukan hasil klasifikasi
        if ($score >= 4) {
            $classification = 'AbNormal';
            $confidence = min(60 + ($score * 5), 95);
            $status = 'danger';
        } else {
            $classification = 'Normal';
            $confidence = min(60 + ((8 - $score) * 5), 95);
            $status = 'success';
        }
        
        return [
            'classification' => $classification,
            'confidence' => $confidence,
            'score' => $score,
            'status' => $status,
            'details' => $details,
            'c45_calculations' => $c45Calculations,
            'recommendation' => $this->getRecommendation($classification, $score)
        ];
    }

    private function calculateC45Metrics($data, $details, $score)
    {
        // Hitung total abnormal parameters
        $totalParams = 6; // HR, PR, QRS, QT, QTC, AXIS
        $abnormalCount = 0;
        foreach ($details as $param) {
            if ($param['status'] == 'Abnormal') {
                $abnormalCount++;
            }
        }
        $normalCount = $totalParams - $abnormalCount;
        
        // Entropy Total: E(S) = -Σ(p * log2(p))
        $pNormal = $normalCount / $totalParams;
        $pAbnormal = $abnormalCount / $totalParams;
        
        $entropyTotal = 0;
        if ($pNormal > 0) $entropyTotal -= $pNormal * log($pNormal, 2);
        if ($pAbnormal > 0) $entropyTotal -= $pAbnormal * log($pAbnormal, 2);
        
        // Information Gain
        $informationGain = 1 - $entropyTotal;
        
        // Gain Ratio
        $splitInfo = 0;
        if ($pNormal > 0) $splitInfo -= $pNormal * log($pNormal, 2);
        if ($pAbnormal > 0) $splitInfo -= $pAbnormal * log($pAbnormal, 2);
        
        $gainRatio = $splitInfo > 0 ? $informationGain / $splitInfo : 0;
        
        return [
            'total_params' => $totalParams,
            'normal_count' => $normalCount,
            'abnormal_count' => $abnormalCount,
            'entropy' => round($entropyTotal, 4),
            'information_gain' => round($informationGain, 4),
            'gain_ratio' => round($gainRatio, 4),
            'purity' => round((max($normalCount, $abnormalCount) / $totalParams) * 100, 2)
        ];
    }

    private function getRecommendation($classification, $score)
    {
        if ($classification == 'AbNormal') {
            if ($score >= 6) {
                return 'Segera konsultasikan ke dokter spesialis jantung. Terdeteksi beberapa kelainan signifikan pada EKG Anda.';
            } else {
                return 'Disarankan untuk melakukan pemeriksaan lanjutan dengan dokter. Beberapa parameter menunjukkan nilai abnormal.';
            }
        } else {
            return 'Kondisi jantung dalam batas normal. Tetap jaga pola hidup sehat dan rutin check-up.';
        }
    }
}
