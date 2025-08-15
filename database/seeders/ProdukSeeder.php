<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produk;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'nama_produk' => 'Motul Oil 7100 4T',
                'harga' => 350000,
                'stok' => 50,
                'gambar_produk' => 'motul-oil.jpg',
                'deskripsi' => 'High performance synthetic oil for 4-stroke engines',
                'kategori' => 'Oil'
            ],
            [
                'nama_produk' => 'Castrol Power 1',
                'harga' => 280000,
                'stok' => 60,
                'gambar_produk' => 'castrol-oil.jpg',
                'deskripsi' => 'Synthetic motorcycle oil for optimal performance',
                'kategori' => 'Oil'
            ],
            [
                'nama_produk' => 'Shell Advance Ultra',
                'harga' => 320000,
                'stok' => 45,
                'gambar_produk' => 'shell-oil.jpg',
                'deskripsi' => 'Premium synthetic oil for maximum engine protection',
                'kategori' => 'Oil'
            ],
            [
                'nama_produk' => 'Repsol Moto Racing',
                'harga' => 380000,
                'stok' => 30,
                'gambar_produk' => 'repsol-oil.jpg',
                'deskripsi' => 'Racing oil for high-performance motorcycles',
                'kategori' => 'Oil'
            ],
            [
                'nama_produk' => 'Brembo Brake Pads',
                'harga' => 850000,
                'stok' => 30,
                'gambar_produk' => 'brembo-pads.jpg',
                'deskripsi' => 'High-performance brake pads for better stopping power',
                'kategori' => 'Second Part'
            ],
            [
                'nama_produk' => 'Michelin Pilot Power Tires',
                'harga' => 1200000,
                'stok' => 25,
                'gambar_produk' => 'michelin-tires.jpg',
                'deskripsi' => 'High-performance tires for sport riding',
                'kategori' => 'Second Part'
            ],
            [
                'nama_produk' => 'K&N Air Filter',
                'harga' => 450000,
                'stok' => 40,
                'gambar_produk' => 'kn-filter.jpg',
                'deskripsi' => 'High-flow air filter for better performance',
                'kategori' => 'Second Part'
            ],
            [
                'nama_produk' => 'Akrapovic Exhaust',
                'harga' => 3500000,
                'stok' => 8,
                'gambar_produk' => 'akrapovic-exhaust.jpg',
                'deskripsi' => 'Titanium exhaust system for better sound and performance',
                'kategori' => 'Second Part'
            ],
            [
                'nama_produk' => 'Ohlins Suspension Shocks',
                'harga' => 28900000,
                'stok' => 5,
                'gambar_produk' => 'ohlins-shocks.jpg',
                'deskripsi' => 'Premium suspension system for maximum performance',
                'kategori' => 'New Part'
            ],
            [
                'nama_produk' => 'Kawasaki H2R',
                'harga' => 750000000,
                'stok' => 2,
                'gambar_produk' => 'kawasaki-h2r.jpg',
                'deskripsi' => 'Supercharged sportbike with incredible power',
                'kategori' => 'New Part'
            ],
            [
                'nama_produk' => 'Yamaha R1M',
                'harga' => 650000000,
                'stok' => 3,
                'gambar_produk' => 'yamaha-r1m.jpg',
                'deskripsi' => 'Track-focused superbike with advanced electronics',
                'kategori' => 'New Part'
            ],
            [
                'nama_produk' => 'Honda CBR1000RR',
                'harga' => 580000000,
                'stok' => 4,
                'gambar_produk' => 'honda-cbr.jpg',
                'deskripsi' => 'Fireblade with cutting-edge technology',
                'kategori' => 'New Part'
            ],
            [
                'nama_produk' => 'Ducati Panigale V4',
                'harga' => 850000000,
                'stok' => 2,
                'gambar_produk' => 'ducati-panigale.jpg',
                'deskripsi' => 'Italian superbike with V4 engine',
                'kategori' => 'New Part'
            ],
            [
                'nama_produk' => 'BMW S1000RR',
                'harga' => 720000000,
                'stok' => 3,
                'gambar_produk' => 'bmw-s1000rr.jpg',
                'deskripsi' => 'German engineering meets superbike performance',
                'kategori' => 'New Part'
            ],
            [
                'nama_produk' => 'Mifta Motor Sport Jacket',
                'harga' => 850000,
                'stok' => 20,
                'gambar_produk' => 'mms-jacket.jpg',
                'deskripsi' => 'Premium leather jacket with safety features',
                'kategori' => 'Apparel'
            ],
            [
                'nama_produk' => 'Racing Helmet',
                'harga' => 1200000,
                'stok' => 15,
                'gambar_produk' => 'racing-helmet.jpg',
                'deskripsi' => 'High-quality racing helmet for maximum protection',
                'kategori' => 'Apparel'
            ],
            [
                'nama_produk' => 'Motorcycle Gloves',
                'harga' => 350000,
                'stok' => 35,
                'gambar_produk' => 'motorcycle-gloves.jpg',
                'deskripsi' => 'Comfortable and protective riding gloves',
                'kategori' => 'Apparel'
            ],
            [
                'nama_produk' => 'Racing Boots',
                'harga' => 950000,
                'stok' => 12,
                'gambar_produk' => 'racing-boots.jpg',
                'deskripsi' => 'Professional racing boots for track use',
                'kategori' => 'Apparel'
            ]
        ];

        foreach ($products as $product) {
            Produk::create($product);
        }
    }
} 