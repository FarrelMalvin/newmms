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
        $this->call([
            CabangSeeder::class,
            TypeServiceSeeder::class,
            PenggunaSeeder::class,
            ServiceSeeder::class, // Tambahkan ServiceSeeder
            TestimoniSeeder::class, // Tambahkan TestimoniSeeder
            ProdukSeeder::class, // Tambahkan ProdukSeeder
<<<<<<< HEAD

=======
>>>>>>> 885471175fa0715ebbfa0816a9c109590157b94f
        ]);
        \App\Models\Pengguna::create([
            'nama' => 'Admin Satu',
            'username' => 'admin1',
            'password' => Hash::make('admin1password'),
            'no_hp' => '081234567890',
            'peran' => 'admin',
        ]);
        \App\Models\Pengguna::create([
            'nama' => 'Admin Dua',
            'username' => 'admin2',
            'password' => Hash::make('admin2password'),
            'no_hp' => '081298765432',
            'peran' => 'admin',
        ]);
    }
} 