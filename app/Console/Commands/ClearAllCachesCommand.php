<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class ClearAllCachesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:clear-all {--force : Force clear without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all application caches including Laravel, browser, and custom caches';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->option('force')) {
            if (!$this->confirm('This will clear ALL caches. Are you sure?')) {
                $this->info('Cache clearing cancelled.');
                return 0;
            }
        }

        $this->info('🧹 Clearing all caches...');
        $this->newLine();

        // 1. Laravel Application Caches
        $this->info('📦 Clearing Laravel caches...');
        Artisan::call('cache:clear');
        $this->line('   ✅ Application cache cleared');

        Artisan::call('config:clear');
        $this->line('   ✅ Configuration cache cleared');

        Artisan::call('view:clear');
        $this->line('   ✅ View cache cleared');

        Artisan::call('route:clear');
        $this->line('   ✅ Route cache cleared');

        // 2. Clear compiled classes
        $this->info('🔧 Clearing compiled classes...');
        Artisan::call('clear-compiled');
        $this->line('   ✅ Compiled classes cleared');

        // 3. Clear custom caches
        $this->info('🎯 Clearing custom caches...');
        Cache::forget('all_produk');
        Cache::forget('api_produk');
        Cache::forget('featured_products');
        Cache::forget('testimonials');
        $this->line('   ✅ Custom caches cleared');

        // 4. Clear file caches
        $this->info('📁 Clearing file caches...');
        $cachePath = storage_path('framework/cache');
        if (File::exists($cachePath)) {
            File::deleteDirectory($cachePath);
            File::makeDirectory($cachePath, 0755, true);
        }
        $this->line('   ✅ File cache cleared');

        // 5. Clear view cache files
        $viewCachePath = storage_path('framework/views');
        if (File::exists($viewCachePath)) {
            File::deleteDirectory($viewCachePath);
            File::makeDirectory($viewCachePath, 0755, true);
        }
        $this->line('   ✅ View cache files cleared');

        // 6. Clear session files (optional)
        if ($this->confirm('Clear session files as well? (This will log out all users)')) {
            $sessionPath = storage_path('framework/sessions');
            if (File::exists($sessionPath)) {
                File::deleteDirectory($sessionPath);
                File::makeDirectory($sessionPath, 0755, true);
            }
            $this->line('   ✅ Session files cleared');
        }

        // 7. Optimize (optional)
        if ($this->confirm('Run optimization after clearing caches?')) {
            $this->info('⚡ Running optimization...');
            Artisan::call('optimize');
            $this->line('   ✅ Application optimized');
        }

        $this->newLine();
        $this->info('🎉 All caches cleared successfully!');
        $this->info('💡 Tip: If you\'re still seeing old data, try:');
        $this->line('   - Hard refresh browser (Ctrl+F5)');
        $this->line('   - Clear browser cache');
        $this->line('   - Check CDN cache if using CDN');
        $this->line('   - Check hosting provider cache settings');

        return 0;
    }
}
