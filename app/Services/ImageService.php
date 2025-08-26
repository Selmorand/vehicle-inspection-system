<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class ImageService
{
    /**
     * Get or create a thumbnail for PDF use
     * 
     * @param string $imagePath The original image path
     * @param int $width Thumbnail width
     * @param int $height Thumbnail height
     * @return string Path to thumbnail
     */
    public function getThumbnailForPdf($imagePath, $width = 150, $height = 150)
    {
        // Handle different path formats
        if (file_exists($imagePath)) {
            // This is already a full path
            $fullPath = $imagePath;
            $relativePath = str_replace(storage_path('app/public/'), '', $imagePath);
        } else {
            // This is a relative path
            $relativePath = ltrim($imagePath, '/');
            $fullPath = storage_path('app/public/' . $relativePath);
        }
        
        // Clean the path
        $relativePath = ltrim($relativePath, '/');
        
        if (!file_exists($fullPath)) {
            return null;
        }
        
        // Create thumbnail path
        $pathInfo = pathinfo($relativePath);
        $thumbnailDir = $pathInfo['dirname'] . '/thumbnails';
        $thumbnailName = $pathInfo['filename'] . '_150x150.' . $pathInfo['extension'];
        $thumbnailRelativePath = $thumbnailDir . '/' . $thumbnailName;
        $thumbnailFullPath = storage_path('app/public/' . $thumbnailRelativePath);
        
        // Check if thumbnail already exists
        if (file_exists($thumbnailFullPath)) {
            return $thumbnailFullPath;
        }
        
        // Create thumbnail directory if it doesn't exist
        $thumbnailDirFull = storage_path('app/public/' . $thumbnailDir);
        if (!file_exists($thumbnailDirFull)) {
            mkdir($thumbnailDirFull, 0777, true);
        }
        
        try {
            // Create thumbnail using basic PHP GD functions
            return $this->createThumbnailWithGD($fullPath, $thumbnailFullPath, $width, $height);
            
        } catch (\Exception $e) {
            // Log error in production only
            if (!config('app.debug')) {
                \Log::error('Failed to create thumbnail: ' . $e->getMessage(), [
                    'original' => $fullPath,
                    'thumbnail' => $thumbnailFullPath
                ]);
            }
            
            // Return original if thumbnail creation fails
            return $fullPath;
        }
    }
    
    /**
     * Convert storage URL to file path and create thumbnail
     */
    public function prepareImageForPdf($imageUrl)
    {
        // Extract the path after /storage/
        if (preg_match('/\/storage\/(.+)$/i', $imageUrl, $matches)) {
            $relativePath = $matches[1];
            $fullPath = storage_path('app/public/' . $relativePath);
            
            if (file_exists($fullPath)) {
                // Get or create thumbnail
                return $this->getThumbnailForPdf($fullPath);
            }
        }
        
        return null;
    }
    
    /**
     * Create thumbnail using PHP GD extension
     */
    private function createThumbnailWithGD($sourcePath, $destPath, $width, $height)
    {
        if (!extension_loaded('gd')) {
            throw new \Exception('GD extension not available');
        }
        
        // Get image info
        $imageInfo = getimagesize($sourcePath);
        if (!$imageInfo) {
            throw new \Exception('Cannot get image information');
        }
        
        $sourceWidth = $imageInfo[0];
        $sourceHeight = $imageInfo[1];
        $imageType = $imageInfo[2];
        
        // Create source image resource
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                $sourceImage = imagecreatefromjpeg($sourcePath);
                break;
            case IMAGETYPE_PNG:
                $sourceImage = imagecreatefrompng($sourcePath);
                break;
            case IMAGETYPE_GIF:
                $sourceImage = imagecreatefromgif($sourcePath);
                break;
            default:
                throw new \Exception('Unsupported image type');
        }
        
        if (!$sourceImage) {
            throw new \Exception('Failed to create image resource');
        }
        
        // Calculate crop dimensions (center crop)
        $sourceRatio = $sourceWidth / $sourceHeight;
        $destRatio = $width / $height;
        
        if ($sourceRatio > $destRatio) {
            // Source is wider - crop width
            $cropHeight = $sourceHeight;
            $cropWidth = $sourceHeight * $destRatio;
            $cropX = ($sourceWidth - $cropWidth) / 2;
            $cropY = 0;
        } else {
            // Source is taller - crop height
            $cropWidth = $sourceWidth;
            $cropHeight = $sourceWidth / $destRatio;
            $cropX = 0;
            $cropY = ($sourceHeight - $cropHeight) / 2;
        }
        
        // Create destination image
        $destImage = imagecreatetruecolor($width, $height);
        
        // Preserve transparency for PNG
        if ($imageType == IMAGETYPE_PNG) {
            imagealphablending($destImage, false);
            imagesavealpha($destImage, true);
        }
        
        // Copy and resize
        imagecopyresampled(
            $destImage, $sourceImage,
            0, 0, $cropX, $cropY,
            $width, $height, $cropWidth, $cropHeight
        );
        
        // Save thumbnail
        $result = false;
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                $result = imagejpeg($destImage, $destPath, 85);
                break;
            case IMAGETYPE_PNG:
                $result = imagepng($destImage, $destPath, 8);
                break;
            case IMAGETYPE_GIF:
                $result = imagegif($destImage, $destPath);
                break;
        }
        
        // Clean up
        imagedestroy($sourceImage);
        imagedestroy($destImage);
        
        if (!$result) {
            throw new \Exception('Failed to save thumbnail');
        }
        
        return $destPath;
    }
}