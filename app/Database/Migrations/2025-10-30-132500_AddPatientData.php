<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPatientData extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pasien', [
            'jenis_kelamin' => [
                'type' => 'ENUM',
                'constraint' => ['L', 'P'],
                'null' => true,
                'after' => 'nama'
            ],
            'tanggal_lahir' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'jenis_kelamin'
            ],
            'berat_badan' => [
                'type' => 'FLOAT',
                'constraint' => '5,2',
                'null' => true,
                'after' => 'tanggal_lahir'
            ],
            'tinggi_badan' => [
                'type' => 'INT',
                'constraint' => 3,
                'null' => true,
                'after' => 'berat_badan'
            ],
            'riwayat_keluarga' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'tinggi_badan'
            ],
            'merokok' => [
                'type' => 'ENUM',
                'constraint' => ['Ya', 'Tidak', 'Mantan'],
                'null' => true,
                'after' => 'riwayat_keluarga'
            ],
            'aktivitas_fisik' => [
                'type' => 'ENUM',
                'constraint' => ['Jarang', 'Sedang', 'Sering'],
                'null' => true,
                'after' => 'merokok'
            ],
            'konsumsi_alkohol' => [
                'type' => 'ENUM',
                'constraint' => ['Tidak', 'Jarang', 'Sering'],
                'null' => true,
                'after' => 'aktivitas_fisik'
            ],
            'tekanan_darah' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
                'after' => 'konsumsi_alkohol'
            ],
            'kolesterol' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
                'after' => 'tekanan_darah'
            ],
            'gula_darah' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
                'after' => 'kolesterol'
            ],
            'diabetes' => [
                'type' => 'BOOLEAN',
                'default' => 0,
                'null' => true,
                'after' => 'gula_darah'
            ],
            'obat' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'diabetes'
            ],
            'stres' => [
                'type' => 'TINYINT',
                'constraint' => 2,
                'null' => true,
                'after' => 'obat'
            ],
            'tidur' => [
                'type' => 'FLOAT',
                'constraint' => '3,1',
                'null' => true,
                'after' => 'stres'
            ],
            'gejala' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'tidur'
            ],
            'kondisi_lingkungan' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'gejala'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pasien', [
            'jenis_kelamin',
            'tanggal_lahir',
            'berat_badan',
            'tinggi_badan',
            'riwayat_keluarga',
            'merokok',
            'aktivitas_fisik',
            'konsumsi_alkohol',
            'tekanan_darah',
            'kolesterol',
            'gula_darah',
            'diabetes',
            'obat',
            'stres',
            'tidur',
            'gejala',
            'kondisi_lingkungan'
        ]);
    }
}
