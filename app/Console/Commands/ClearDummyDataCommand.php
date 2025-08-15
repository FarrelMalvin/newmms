<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Produk;
use App\Models\Testimoni;
use App\Models\Berita;
use App\Models\Service;
use App\Models\Pengguna;

class ClearDummyDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:clear-dummy {--force : Force clear without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all dummy data from database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->option('force')) {
            if (!$this->confirm('Are you sure you want to clear all dummy data? This action cannot be undone.')) {
                $this->info('Operation cancelled.');
                return;
            }
        }

        $this->info('=== CLEARING DUMMY DATA ===');

        try {
            // Disable foreign key checks temporarily
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
            
            $this->info('1. Clearing Services...');
            Service::truncate();
            $this->info('   ✅ Services cleared');
            
            $this->info('2. Clearing Testimonials...');
            Testimoni::truncate();
            $this->info('   ✅ Testimonials cleared');
            
            $this->info('3. Clearing Products...');
            Produk::truncate();
            $this->info('   ✅ Products cleared');
            
            $this->info('4. Clearing News...');
            Berita::truncate();
            $this->info('   ✅ News cleared');
            
            $this->info('5. Clearing regular users (keeping admins)...');
            $deletedUsers = Pengguna::where('peran', '!=', 'admin')->delete();
            $this->info("   ✅ {$deletedUsers} regular users cleared");
            
            // Re-enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
            
            $this->info("\n=== VERIFICATION ===");
            $this->info('Produk: ' . Produk::count());
            $this->info('Testimoni: ' . Testimoni::count());
            $this->info('Berita: ' . Berita::count());
            $this->info('Service: ' . Service::count());
            $this->info('Pengguna: ' . Pengguna::count());
            
            $this->info("\n✅ All dummy data cleared successfully!");
            
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        }
    }
}
