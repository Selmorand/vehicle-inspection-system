<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240', // 10MB max
            'type' => 'required|string'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            // Process and compress the image
            $img = Image::read($image->getRealPath());
            
            // Resize if larger than 1920px width while maintaining aspect ratio
            if ($img->width() > 1920) {
                $img->scale(width: 1920);
            }
            
            // Compress based on file type
            $quality = 85; // 85% quality is a good balance
            
            // Save to storage
            $path = 'uploads/' . $request->type . '/' . $filename;
            Storage::disk('public')->put($path, $img->encode('jpg', $quality));
            
            return response()->json([
                'success' => true,
                'path' => Storage::url($path),
                'filename' => $filename
            ]);
        }
        
        return response()->json(['success' => false, 'message' => 'No image uploaded'], 400);
    }
    
    public function compress(Request $request)
    {
        $request->validate([
            'image_path' => 'required|string'
        ]);
        
        $path = $request->image_path;
        
        if (Storage::disk('public')->exists($path)) {
            $image = Storage::disk('public')->get($path);
            $img = Image::read($image);
            
            // Compress to 70% quality for web display
            $compressed = $img->encode('jpg', 70);
            
            return response($compressed, 200)
                ->header('Content-Type', 'image/jpeg')
                ->header('Cache-Control', 'public, max-age=3600');
        }
        
        return response()->json(['error' => 'Image not found'], 404);
    }
}