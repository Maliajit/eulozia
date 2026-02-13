<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

/**
 * Admin Media Controller
 * 
 * Purpose: Centralized asset management system for images and documents.
 * 
 * Data Flow: 
 * - Handles file uploads with slugification and timestamping for uniqueness.
 * - Generates thumbnails for images using Intervention Image.
 * - Provides paginated JSON data for the universal Media Library modal.
 * 
 * Database: 
 * - `media`: Stores file paths, metadata, uploader info, and thumbnail paths.
 * 
 * Dependencies: Storage Facade (S3/Local), Intervention Image, PHP GD/ImageMagick.
 */
class MediaController extends Controller
{
    private ImageManager $imageManager;

    public function __construct()
    {
        if (class_exists(Driver::class)) {
            $this->imageManager = new ImageManager(new Driver());
        }
    }

    public function index()
    {
        return view('admin.media.index');
    }

    /**
     * Get Media Data for Modals/AJAX
     */
    public function getData(Request $request)
    {
        $query = Media::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('file_name', 'LIKE', "%{$search}%")
                ->orWhere('alt_text', 'LIKE', "%{$search}%");
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');
        $query->orderBy($sortBy, $sortDir);

        $media = $query->paginate($request->get('per_page', 12));

        $media->getCollection()->transform(function ($item) {
            $url = asset(Storage::url($item->file_path));
            $thumbUrl = asset(Storage::url($item->thumbnails['small'] ?? $item->file_path));

            return [
                'id' => $item->id,
                'url' => $url,
                'thumbnail_url' => $thumbUrl,
                'thumb_url' => $thumbUrl, // Compatibility alias
                'file_path' => $item->file_path,
                'path' => $url, // Compatibility alias
                'file_name' => $item->file_name,
                'filename' => $item->file_name, // Compatibility alias
                'alt_text' => $item->alt_text,
                'mime_type' => $item->mime_type,
                'is_image' => str_starts_with($item->mime_type, 'image/'),
                'size_formatted' => $this->formatBytes($item->file_size),
                'created_at_formatted' => $item->created_at->format('M d, Y H:i'),
            ];
        });


        return response()->json([
            'success' => true,
            'data' => $media
        ]);
    }


    public function update(Request $request, $id)
    {
        $media = Media::findOrFail($id);
        $media->update([
            'alt_text' => $request->alt_text
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Media updated successfully'
        ]);
    }

    public function destroy($id)
    {
        $media = Media::findOrFail($id);

        // Delete physical files
        if (Storage::disk('public')->exists($media->file_path)) {
            Storage::disk('public')->delete($media->file_path);
        }

        if ($media->thumbnails) {
            foreach ($media->thumbnails as $thumbPath) {
                if (Storage::disk('public')->exists($thumbPath)) {
                    Storage::disk('public')->delete($thumbPath);
                }
            }
        }

        $media->delete();

        return response()->json([
            'success' => true,
            'message' => 'Media deleted successfully'
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'No files selected'], 400);
        }

        $mediaItems = Media::whereIn('id', $ids)->get();
        $deletedCount = 0;

        foreach ($mediaItems as $media) {
            // Delete physical files
            if (Storage::disk('public')->exists($media->file_path)) {
                Storage::disk('public')->delete($media->file_path);
            }

            if ($media->thumbnails) {
                foreach ($media->thumbnails as $thumbPath) {
                    if (Storage::disk('public')->exists($thumbPath)) {
                        Storage::disk('public')->delete($thumbPath);
                    }
                }
            }

            $media->delete();
            $deletedCount++;
        }

        return response()->json([
            'success' => true,
            'data' => [
                'deleted_count' => $deletedCount
            ]
        ]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'files.*' => 'required|file|max:10240', // 10MB max per file
        ]);

        if (!$request->hasFile('files')) {
            return response()->json(['success' => false, 'message' => 'No files uploaded'], 400);
        }

        $uploadedMedia = [];
        $errors = [];

        foreach ($request->file('files') as $file) {
            try {
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $fileName = pathinfo($originalName, PATHINFO_FILENAME);
                $uniqueName = Str::slug($fileName) . '_' . time() . '_' . Str::random(5) . '.' . $extension;

                $storagePath = 'products/media/' . date('Y/m');
                $fullPath = $storagePath . '/' . $uniqueName;

                Storage::disk('public')->putFileAs($storagePath, $file, $uniqueName);

                // Create thumbnails if image
                $thumbnails = [];
                if (str_starts_with($file->getMimeType(), 'image/') && isset($this->imageManager)) {
                    $thumbnails = $this->createThumbnails($file, $storagePath, $uniqueName);
                }

                $media = Media::create([
                    'file_name' => $originalName,
                    'file_path' => $fullPath,
                    'disk' => 'public',
                    'mime_type' => $file->getMimeType(),
                    'file_type' => str_starts_with($file->getMimeType(), 'image/') ? 'image' : 'document',
                    'file_size' => $file->getSize(),
                    'thumbnails' => $thumbnails ?: null,
                    'alt_text' => $request->alt_text,
                    'metadata' => [
                        'original_name' => $originalName,
                        'extension' => $extension,
                    ],
                    'uploaded_by' => \Illuminate\Support\Facades\Auth::guard('admin')->id() ?? auth()->id(),
                    'uploader_type' => 'admin',
                ]);

                $uploadedMedia[] = [
                    'id' => $media->id,
                    'url' => asset(Storage::url($fullPath)),
                    'file_name' => $originalName
                ];

            } catch (\Exception $e) {
                $errors[] = "Failed to upload {$file->getClientOriginalName()}: " . $e->getMessage();
            }
        }

        return response()->json([
            'success' => count($errors) === 0,
            'data' => [
                'total_uploaded' => count($uploadedMedia),
                'files' => $uploadedMedia
            ],
            'errors' => $errors
        ]);
    }

    private function createThumbnails($file, $storagePath, $fileName)
    {
        $thumbnails = [];
        try {
            $image = $this->imageManager->read($file->getRealPath());
            $originalName = pathinfo($fileName, PATHINFO_FILENAME);
            $extension = pathinfo($fileName, PATHINFO_EXTENSION);

            // Small
            $smallName = $originalName . '_small.' . $extension;
            $smallImage = clone $image;
            $smallImage->cover(150, 150);
            Storage::disk('public')->put($storagePath . '/' . $smallName, (string) $smallImage->encodeByExtension($extension));
            $thumbnails['small'] = $storagePath . '/' . $smallName;

        } catch (\Exception $e) {
            // Squelch image error to ensure primary upload succeeds
        }

        return $thumbnails;
    }

    private function formatBytes($bytes, $decimals = 2)
    {
        if ($bytes == 0)
            return '0 Bytes';
        $k = 1024;
        $dm = $decimals < 0 ? 0 : $decimals;
        $sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $i = floor(log($bytes) / log($k));
        return (float) number_format($bytes / pow($k, $i), $dm) . ' ' . $sizes[$i];
    }
}
