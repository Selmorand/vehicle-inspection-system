<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\File;

class OptimizeImages extends Command
{
    protected $signature = 'images:optimize {--path=public/images} {--quality=85}';
    protected $description = 'Optimize all images in the specified directory';

    public function handle()
    {
        $path = base_path($this->option('path'));
        $quality = $this->option('quality');
        
        if (!File::exists($path)) {
            $this->error("Path does not exist: {$path}");
            return 1;
        }
        
        $this->info("Optimizing images in: {$path}");
        $this->info("Quality setting: {$quality}%");
        
        // Get all image files
        $images = File::allFiles($path);
        $totalSize = 0;
        $newSize = 0;
        $count = 0;
        
        $progressBar = $this->output->createProgressBar(count($images));
        $progressBar->start();
        
        foreach ($images as $file) {
            $extension = strtolower($file->getExtension());
            
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                $filePath = $file->getRealPath();
                $originalSize = filesize($filePath);
                $totalSize += $originalSize;
                
                try {
                    // Process image
                    $img = Image::read($filePath);
                    
                    // Resize if too large
                    if ($img->width() > 2000) {
                        $img->scale(width: 2000);
                    }
                    
                    // Save with compression
                    $img->save($filePath, $quality);
                    
                    $newFileSize = filesize($filePath);
                    $newSize += $newFileSize;
                    $count++;
                    
                    $this->line(sprintf(
                        "\n%s: %.1fKB -> %.1fKB (%.1f%% reduction)",
                        $file->getFilename(),
                        $originalSize / 1024,
                        $newFileSize / 1024,
                        (1 - $newFileSize / $originalSize) * 100
                    ));
                } catch (\Exception $e) {
                    $this->error("\nFailed to optimize: {$file->getFilename()}");
                }
            }
            
            $progressBar->advance();
        }
        
        $progressBar->finish();
        
        $this->info("\n\nOptimization complete!");
        $this->info("Images processed: {$count}");
        $this->info(sprintf(
            "Total size reduction: %.1fMB -> %.1fMB (%.1f%% saved)",
            $totalSize / 1024 / 1024,
            $newSize / 1024 / 1024,
            (1 - $newSize / $totalSize) * 100
        ));
        
        return 0;
    }
}