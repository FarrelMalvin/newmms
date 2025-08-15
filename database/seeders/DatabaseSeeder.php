<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Truncate all main tables
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\Service::truncate();
        \App\Models\Testimoni::truncate();
        \App\Models\Produk::truncate();
        \App\Models\Berita::truncate();
        \App\Models\Cabang::truncate();
        \App\Models\TypeService::truncate();
        \App\Models\Pengguna::truncate();
        \App\Models\PenggunaAdmin::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Buat cabang terlebih dahulu
        $cabangPakis = \App\Models\Cabang::create([
            'nama_cabang' => 'Pakis',
        ]);
        $cabangSulfat = \App\Models\Cabang::create([
            'nama_cabang' => 'Sulfat',
        ]);

        // Seed akun admin hanya di local/staging
        if (app()->environment(['local', 'staging'])) {
            // Create only two admin accounts
            $adminPakis = \App\Models\Pengguna::create([
                'nama' => 'Admin Pakis',
                'username' => 'admin-pakis',
                'password' => \Hash::make('admin123'),
                'no_hp' => '081234567890',
                'peran' => 'admin',
            ]);
            $adminSulfat = \App\Models\Pengguna::create([
                'nama' => 'Admin Sulfat',
                'username' => 'admin-sulfat',
                'password' => \Hash::make('admin123'),
                'no_hp' => '081298765432',
                'peran' => 'admin',
            ]);
            \App\Models\PenggunaAdmin::create([
                'id_pengguna' => $adminPakis->id_pengguna,
                'id_cabang' => $cabangPakis->id_cabang, // Pakis
            ]);
            \App\Models\PenggunaAdmin::create([
                'id_pengguna' => $adminSulfat->id_pengguna,
                'id_cabang' => $cabangSulfat->id_cabang, // Sulfat
            ]);
        }
    }
} 