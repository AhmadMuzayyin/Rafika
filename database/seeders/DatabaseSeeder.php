<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Carbon\Carbon;
use App\Models\Pak;
use App\Models\Bulan;
use App\Models\Pengadaan;
use App\Models\SumberDana;
use App\Models\Pelaksanaan;
use App\Models\KunciInputan;
use App\Models\KunciPak;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(1)->create();

        // KunciInputan::create([
        //     'nama_inputan' => 'Entry Kegiatan',
        //     'aktif' => Carbon::now()->format('Y-m-d'),
        //     'tidak_aktif' => Carbon::now()->format('Y-m-d'),
        //     'status' => true
        // ]);
        // KunciInputan::create([
        //     'nama_inputan' => 'Target Fisik & Target Keuangan',
        //     'aktif' => Carbon::now()->format('Y-m-d'),
        //     'tidak_aktif' => Carbon::now()->format('Y-m-d'),
        //     'status' => true
        // ]);
        // KunciInputan::create([
        //     'nama_inputan' => 'Laporan RFK',
        //     'aktif' => Carbon::now()->format('Y-m-d'),
        //     'tidak_aktif' => Carbon::now()->format('Y-m-d'),
        //     'status' => true
        // ]);
        // SumberDana::create([
        //     'nama_sumber_dana' => 'APBD KABUPATEN PAMEKSAN',
        // ]);
        // SumberDana::create([
        //     'nama_sumber_dana' => 'APBD PROVINSI',
        // ]);
        // SumberDana::create([
        //     'nama_sumber_dana' => 'APBN',
        // ]);

        // Pengadaan::create([
        //     'nama_pengadaan' => 'Konstruksi'
        // ]);
        // Pengadaan::create([
        //     'nama_pengadaan' => 'Barang'
        // ]);
        // Pengadaan::create([
        //     'nama_pengadaan' => 'Konsultansi'
        // ]);
        // Pengadaan::create([
        //     'nama_pengadaan' => 'Jasa Lainya'
        // ]);
        // Pelaksanaan::create([
        //     'nama_pelaksanaan' => 'Tender'
        // ]);
        // Pelaksanaan::create([
        //     'nama_pelaksanaan' => 'Penunjukan Langsung'
        // ]);
        // Pelaksanaan::create([
        //     'nama_pelaksanaan' => 'Pengadaan Langsung'
        // ]);
        // Pelaksanaan::create([
        //     'nama_pelaksanaan' => 'ePucrhasing'
        // ]);
        // Pelaksanaan::create([
        //     'nama_pelaksanaan' => 'Swakelola'
        // ]);
        // Pelaksanaan::create([
        //     'nama_pelaksanaan' => 'Seleksi'
        // ]);
        // $pak = Pak::create([
        //     'tahun_anggaran' => Carbon::now()->format('Y'),
        // ]);
        // for ($i = 0; $i < 2; $i++) {
        //     KunciPak::create([
        //         'pak_id' => $pak->id,
        //         'pelaksanaan' => $i,
        //         'status' => true
        //     ]);
        // }
        // $bulan = array(
        //     'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        // );
        // foreach ($bulan as $key => $value) {
        //     Bulan::create([
        //         'nama_bulan' => $value
        //     ]);
        // }
    }
}
