<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Pengguna;
use Carbon\Carbon;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        // Pastikan pengguna dengan id 6 ada
        $pengguna = Pengguna::find(6);
        if (!$pengguna) {
            // Buat pengguna dengan id 6 jika tidak ada
            Pengguna::create([
                'id_pengguna' => 6,
                'nama' => 'Customer Enam',
                'username' => 'cust6',
                'password' => bcrypt('cust123'),
                'peran' => 'cust',
                'no_hp' => '08123456786',
            ]);
        }

        // Buat beberapa dummy service dengan status finished untuk pengguna id 6
        Service::create([
            'id_pengguna' => 6,
            'id_tipe_service' => 4, // Daily service
            'tanggal' => Carbon::now()->subDays(30),
            'id_cabang' => 1, // Pakis
            'keluhan' => 'Motor tidak bisa distarter, bunyi aneh saat mesin hidup',
            'jadwal' => '09:00:00',
            'started_at' => Carbon::now()->subDays(30)->setTime(9, 0, 0),
            'finished_at' => Carbon::now()->subDays(30)->setTime(11, 30, 0),
            'status' => 'fin', // finished
        ]);

        Service::create([
            'id_pengguna' => 6,
            'id_tipe_service' => 4, // Daily service
            'tanggal' => Carbon::now()->subDays(15),
            'id_cabang' => 2, // Sulfat
            'keluhan' => 'Performa motor menurun, perlu tune up',
            'jadwal' => '14:00:00',
            'started_at' => Carbon::now()->subDays(15)->setTime(14, 0, 0),
            'finished_at' => Carbon::now()->subDays(15)->setTime(16, 45, 0),
            'status' => 'fin', // finished
        ]);

        Service::create([
            'id_pengguna' => 6,
            'id_tipe_service' => 4, // Daily service
            'tanggal' => Carbon::now()->subDays(7),
            'id_cabang' => 1, // Pakis
            'keluhan' => 'Ganti oli dan filter, cek sistem pendingin',
            'jadwal' => '10:30:00',
            'started_at' => Carbon::now()->subDays(7)->setTime(10, 30, 0),
            'finished_at' => Carbon::now()->subDays(7)->setTime(12, 15, 0),
            'status' => 'fin', // finished
        ]);

        // Buat service dengan status lain untuk variasi
        Service::create([
            'id_pengguna' => 6,
            'id_tipe_service' => 4, // Daily service
            'tanggal' => Carbon::now()->addDays(5),
            'id_cabang' => 2, // Sulfat
            'keluhan' => 'Service rutin bulanan',
            'jadwal' => '13:00:00',
            'started_at' => null,
            'finished_at' => null,
            'status' => 'pend', // pending
        ]);

        // Buat service untuk pengguna lain juga
        Service::create([
            'id_pengguna' => 3, // Customer Satu dari PenggunaSeeder
            'id_tipe_service' => 4, // Daily service
            'tanggal' => Carbon::now()->subDays(20),
            'id_cabang' => 1, // Pakis
            'keluhan' => 'Motor bergetar saat idle',
            'jadwal' => '08:00:00',
            'started_at' => Carbon::now()->subDays(20)->setTime(8, 0, 0),
            'finished_at' => Carbon::now()->subDays(20)->setTime(10, 0, 0),
            'status' => 'fin', // finished
        ]);

        Service::create([
            'id_pengguna' => 3, // Customer Satu
            'id_tipe_service' => 4, // Daily service
            'tanggal' => Carbon::now()->subDays(10),
            'id_cabang' => 2, // Sulfat
            'keluhan' => 'Service rutin untuk performa optimal',
            'jadwal' => '15:00:00',
            'started_at' => Carbon::now()->subDays(10)->setTime(15, 0, 0),
            'finished_at' => Carbon::now()->subDays(10)->setTime(17, 30, 0),
            'status' => 'fin', // finished
        ]);
    }
} 