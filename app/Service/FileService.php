<?php

namespace App\Service;

use App\Jobs\GenerateResponsiveImageJob;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function handleFile($file)
    {
        $uuid = Str::uuid();

        $fileName = $uuid.'.'.$file->getClientOriginalExtension();

        switch ($file->getClientMimeType()) {
            case 'image/jpeg':
            case 'image/png':
                $sizes = getimagesize($file);

                $image = Storage::disk('public')->putFileAs('uploads/'.$uuid, $file, $fileName);

                $paths = ['original' => Storage::url($image)];

                $media = Media::create([
                    'name' => $file->getClientOriginalName(),
                    'path' => $paths,
                    'type' => $file->getClientMimeType(),
                    'metadata' => [
                        'alt' => $file->getClientOriginalName(),
                        'width' => $sizes[0],
                        'height' => $sizes[1],
                    ],
                ]);

                GenerateResponsiveImageJob::dispatch($media->id, $image, $uuid, $fileName);
                break;
            case 'video/mp4':
                $video = Storage::disk('public')->putFileAs('uploads', $file, $fileName);

                Media::create([
                    'name' => $file->getClientOriginalName(),
                    'path' => Storage::url($video),
                    'metadata' => [
                        'alt' => $file->getClientOriginalName(),
                    ],
                    'type' => $file->getClientMimeType(),
                ]);
                break;
            default:
                $uploadedFile = Storage::disk('public')->putFileAs('uploads', $file, $fileName);

                Media::create([
                    'name' => $file->getClientOriginalName(),
                    'path' => Storage::url($uploadedFile),
                    'metadata' => [
                        'alt' => $file->getClientOriginalName(),
                    ],
                    'type' => $file->getClientMimeType(),
                ]);
                break;
        }
    }

    public function deleteFile($media)
    {
        if (Str::startsWith($media->type, 'image/' && ! Str::contains($media->type, 'svg'))) {
            $segments = explode('/', $media->path['original']);

            $filteredSegments = array_slice($segments, 2, -1);

            $path = implode('/', $filteredSegments);

            Storage::disk('public')->deleteDirectory($path);
        } else {
            Storage::disk('public')->delete(str_replace('/storage', '', $media->path));
        }
    }
}
