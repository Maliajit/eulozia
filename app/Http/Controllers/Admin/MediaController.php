<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        try {
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
        } catch (\Exception $e) {
            Log::error('Media getData error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve media files'
            ], 500);
        }
    }


    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $media = Media::find($id);
            if (!$media) {
                return response()->json(['success' => false, 'message' => 'Media not found'], 404);
            }

            $media->update([
                'alt_text' => $request->alt_text
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Media updated successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Media update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update media info'
            ], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $media = Media::find($id);
            if (!$media) {
                return response()->json(['success' => false, 'message' => 'Media not found'], 404);
            }

            // Store paths for deletion after DB commit (safe if rollback)
            // But actually it's better to delete after commit for data integrity
            // or before if we are sure. Let's delete after commit to be safe for DB.
            // Wait, if we delete files and DB fails, we lost files.
            // If we commit DB and file delete fails, we have dead files.
            // Dead files are better than lost files for inconsistent DB.

            $pathsToDelete = [$media->file_path];
            if ($media->thumbnails) {
                foreach ($media->thumbnails as $thumbPath) {
                    $pathsToDelete[] = $thumbPath;
                }
            }

            // Check if media is in use
            if (
                $media->categories()->exists() ||
                $media->brands()->exists() ||
                $media->attributeValues()->exists() ||
                $media->variantImages()->exists() ||
                $media->reviewImages()->exists()
            ) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete media as it is currently in use by other records.'
                ], 400);
            }

            $media->delete();

            DB::commit();

            // Delete physical files after successful commit
            foreach ($pathsToDelete as $path) {
                if (Storage::disk('local')->exists($path)) {
                    Storage::disk('local')->delete($path);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Media deleted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Media destroy error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete media'
            ], 500);
        }
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'No files selected'], 400);
        }

        DB::beginTransaction();
        try {
            $mediaItems = Media::whereIn('id', $ids)->get();
            $deletedCount = 0;
            $allPathsToDelete = [];

            foreach ($mediaItems as $media) {
                // Check if in use
                if (
                    $media->categories()->exists() ||
                    $media->brands()->exists() ||
                    $media->attributeValues()->exists() ||
                    $media->variantImages()->exists() ||
                    $media->reviewImages()->exists()
                ) {
                    continue; // Skip items in use
                }

                $allPathsToDelete[] = $media->file_path;
                if ($media->thumbnails) {
                    foreach ($media->thumbnails as $thumbPath) {
                        $allPathsToDelete[] = $thumbPath;
                    }
                }
                $media->delete();
                $deletedCount++;
            }

            DB::commit();

            // Delete physical files after successful commit
            foreach ($allPathsToDelete as $path) {
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'deleted_count' => $deletedCount
                ],
                'message' => "Successfully deleted {$deletedCount} file(s)"
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Media bulkDelete error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete selected media files'
            ], 500);
        }
    }

    public function upload(Request $request)
    {
        try {
            $request->validate([
                'files.*' => 'required|file|max:10240', // 10MB max per file
            ]);

            if (!$request->hasFile('files')) {
                return response()->json(['success' => false, 'message' => 'No files uploaded'], 400);
            }

            $uploadedMedia = [];
            $errors = [];

            foreach ($request->file('files') as $file) {
                DB::beginTransaction();
                try {
                    $originalName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $fileName = pathinfo($originalName, PATHINFO_FILENAME);
                    $uniqueName = Str::slug($fileName) . '_' . time() . '_' . Str::random(5) . '.' . $extension;

                    $storagePath = 'products/media/' . date('Y/m');
                    $fullPath = $storagePath . '/' . $uniqueName;

                    // Physical upload
                    Storage::disk('local')->putFileAs($storagePath, $file, $uniqueName);

                    // Create thumbnails if image
                    $thumbnails = [];
                    if (str_starts_with($file->getMimeType(), 'image/') && isset($this->imageManager)) {
                        $thumbnails = $this->createThumbnails($file, $storagePath, $uniqueName);
                    }

                    $media = Media::create([
                        'file_name' => $originalName,
                        'file_path' => $fullPath,
                        'disk' => 'local',
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

                    DB::commit();

                    $uploadedMedia[] = [
                        'id' => $media->id,
                        'url' => asset(Storage::url($fullPath)),
                        'file_name' => $originalName
                    ];

                } catch (\Exception $e) {
                    DB::rollBack();
                    // Clean up physical file if DB failed
                    if (isset($fullPath) && Storage::disk('local')->exists($fullPath)) {
                        Storage::disk('local')->delete($fullPath);
                    }
                    if (isset($thumbnails) && !empty($thumbnails)) {
                        foreach ($thumbnails as $thumbPath) {
                            if (Storage::disk('local')->exists($thumbPath)) {
                                Storage::disk('local')->delete($thumbPath);
                            }
                        }
                    }

                    Log::error("Media upload individual error: " . $e->getMessage());
                    $errors[] = "Failed to upload {$file->getClientOriginalName()}";
                }
            }

            return response()->json([
                'success' => count($uploadedMedia) > 0,
                'data' => [
                    'total_uploaded' => count($uploadedMedia),
                    'files' => $uploadedMedia
                ],
                'errors' => $errors,
                'message' => count($uploadedMedia) > 0 ? 'File(s) processed.' : 'No files uploaded successfully.'
            ]);
        } catch (\Exception $e) {
            Log::error('Media upload general error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during upload process.'
            ], 500);
        }
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
            Storage::disk('local')->put($storagePath . '/' . $smallName, (string) $smallImage->encodeByExtension($extension));
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
