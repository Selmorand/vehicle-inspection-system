<?php

namespace App\Services;

use Mpdf\Mpdf;
use App\Services\ImageService;

class PdfService
{
    public function generatePdf($html, $filename = 'report.pdf')
    {
        // Pre-process HTML to convert asset URLs to file paths for images
        $html = $this->processImagesForPdf($html);
        
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font_size' => 10,
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 16,
            'margin_bottom' => 16,
            'tempDir' => storage_path('app/temp'),
            'allow_output_buffering' => true,
            'shrink_tables_to_fit' => 1,
            'use_kwt' => true, // Keep with table
            'packTableData' => true,
            'img_dpi' => 96,
            'showImageErrors' => false,
            'curlAllowUnsafeSslRequests' => true,
            'allow_charset_conversion' => true
        ]);
        
        // Set memory and time limits for large documents
        ini_set('memory_limit', '512M');
        set_time_limit(300);
        
        // Enable image debugging in development
        if (config('app.debug')) {
            $mpdf->showImageErrors = true;
        }
        
        $mpdf->WriteHTML($html);
        
        return $mpdf->Output($filename, 'I'); // I = display inline
    }
    
    /**
     * Process images in HTML to convert URLs to file paths and create thumbnails
     */
    private function processImagesForPdf($html)
    {
        $imageService = new ImageService();
        
        // Convert storage URLs to thumbnail file paths
        $pattern = '/src="([^"]*storage[^"]+)"/i';
        
        $html = preg_replace_callback($pattern, function($matches) use ($imageService) {
            $url = $matches[1];
            
            // Extract the path after /storage/
            if (preg_match('/\/storage\/(.+)$/i', $url, $pathMatches)) {
                $relativePath = $pathMatches[1];
                $filePath = storage_path('app/public/' . $relativePath);
                
                // Check if file exists
                if (file_exists($filePath)) {
                    // Get or create thumbnail
                    $thumbnailPath = $imageService->getThumbnailForPdf($filePath, 150, 150);
                    
                    if ($thumbnailPath) {
                        return 'src="' . $thumbnailPath . '"';
                    }
                    
                    // Fallback to original if thumbnail creation fails
                    return 'src="' . $filePath . '"';
                }
            }
            
            // If not a storage URL or file doesn't exist, return original
            return $matches[0];
        }, $html);
        
        return $html;
    }
}