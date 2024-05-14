<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PemeriksaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kader_id'=> 2,
                'penduduk_id' => 9,
                'tgl_pemeriksaan' => '2024-04-15',
                'golongan' => 'lansia',
                'berat_badan' => 65.2,
                'tinggi_badan' => 168.0,
                'status' => 'sakit',
            ], [
                'kader_id'=> 2,
                'penduduk_id' => 8,
                'tgl_pemeriksaan' => '2024-04-15',
                'golongan' => 'batita',
                'berat_badan' => 3.5,
                'tinggi_badan' => 50.0,
                'status' => 'sehat',
            ], [
                'kader_id'=> 2,
                'penduduk_id' => 7,
                'tgl_pemeriksaan' => '2024-04-15',
                'golongan' => 'baduta',
                'berat_badan' => 9.5,
                'tinggi_badan' => 10.2,
                'status' => 'sakit',
            ],[
                'kader_id'=> 2,
                'penduduk_id' => 10,
                'tgl_pemeriksaan' => '2024-02-15',
                'golongan' => 'Lansia',
                'berat_badan' => 59.5,
                'tinggi_badan' => 165.2,
                'status' => 'sakit',
            ], [
                'kader_id'=> 2,
                'penduduk_id' => 13,
                'tgl_pemeriksaan' => '2024-04-15',
                'golongan' => 'batita',
                'berat_badan' => 3.7,
                'tinggi_badan' => 57.0,
                'status' => 'sakit',
            ],[
                'kader_id'=> 2,
                'penduduk_id' => 15,
                'tgl_pemeriksaan' => '2024-04-15',
                'golongan' => 'batita',
                'berat_badan' => 5.4,
                'tinggi_badan' => 70.0,
                'status' => 'sakit',
            ],[
                'kader_id'=> 2,
                'penduduk_id' => 15,
                'tgl_pemeriksaan' => '2024-05-15',
                'golongan' => 'batita',
                'berat_badan' => 7.4,
                'tinggi_badan' => 73.0,
                'status' => 'sehat',
            ],[
                'kader_id'=> 2,
                'penduduk_id' => 10,
                'tgl_pemeriksaan' => '2024-03-15',
                'golongan' => 'lansia',
                'berat_badan' => 62.4,
                'tinggi_badan' => 165.5,
                'status' => 'sehat',
            ],
        ];

        DB::table('pemeriksaans')->insert($data);
    }
}
