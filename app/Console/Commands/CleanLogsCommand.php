<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class CleanLogsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:clean {--days=3 : Number of days to keep logs} {--size=25 : Max log file size in MB}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean old log files and manage log rotation (optimized for 5-minute intervals)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = $this->option('days');
        $maxSize = $this->option('size') * 1024 * 1024; // Convert MB to bytes
        $logPath = storage_path('logs');
        
        $this->info("Starting log cleanup...");
        $this->info("Keeping logs for {$days} days");
        $this->info("Max file size: " . ($maxSize / 1024 / 1024) . " MB");
        
        $deletedCount = 0;
        $rotatedCount = 0;
        
        // Clean old log files
        if (File::exists($logPath)) {
            $files = File::files($logPath);
            $cutoffDate = Carbon::now()->subDays($days);
            
            foreach ($files as $file) {
                $fileName = $file->getFilename();
                
                // Skip .gitignore and other system files
                if (in_array($fileName, ['.gitignore', '.DS_Store'])) {
                    continue;
                }
                
                $filePath = $file->getPathname();
                $fileSize = File::size($filePath);
                $fileModified = Carbon::createFromTimestamp(File::lastModified($filePath));
                
                // Delete old files
                if ($fileModified->lt($cutoffDate)) {
                    File::delete($filePath);
                    $deletedCount++;
                    $this->line("Deleted old log: {$fileName}");
                }
                // Rotate large files
                elseif ($fileSize > $maxSize) {
                    $this->rotateLogFile($filePath, $fileName);
                    $rotatedCount++;
                    $this->line("Rotated large log: {$fileName}");
                }
            }
        }
        
        // Clean cache files
        $this->cleanCacheFiles();
        
        $this->info("Log cleanup completed!");
        $this->info("Deleted: {$deletedCount} old files");
        $this->info("Rotated: {$rotatedCount} large files");
        
        return 0;
    }
    
    /**
     * Rotate large log files
     */
    private function rotateLogFile($filePath, $fileName)
    {
        $backupName = $fileName . '.' . date('Y-m-d-H-i-s') . '.bak';
        $backupPath = storage_path('logs/' . $backupName);
        
        // Create backup
        File::copy($filePath, $backupPath);
        
        // Truncate original file
        File::put($filePath, '');
    }
    
    /**
     * Clean cache files
     */
    private function cleanCacheFiles()
    {
        $cachePaths = [
            storage_path('framework/cache'),
            storage_path('framework/sessions'),
            storage_path('framework/views'),
        ];
        
        foreach ($cachePaths as $cachePath) {
            if (File::exists($cachePath)) {
                $files = File::files($cachePath);
                $cutoffDate = Carbon::now()->subDays(3);
                
                foreach ($files as $file) {
                    $fileModified = Carbon::createFromTimestamp(File::lastModified($file->getPathname()));
                    
                    if ($fileModified->lt($cutoffDate)) {
                        File::delete($file->getPathname());
                    }
                }
            }
        }
    }
} 