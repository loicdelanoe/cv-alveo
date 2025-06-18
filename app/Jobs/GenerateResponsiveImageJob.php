<?php

namespace App\Jobs;

use App\Models\Media;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use Spatie\Glide\GlideImage;

class GenerateResponsiveImageJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected int $mediaId,
        protected string $storedFile,
        protected string $uuid,
        protected string $fileName
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $media = Media::findOrFail($this->mediaId);

        $paths = $media->path;

        foreach (config('image.sizes') as $size => $width) {
            $outputDir = 'uploads/'.$this->uuid;
            $outputPath = $outputDir.'/'.$size.'-'.$this->fileName;

            $paths[$width.'w'] = Storage::url($outputPath);

            Storage::disk('public')->makeDirectory($outputDir);

            GlideImage::create(Storage::disk('public')->path($this->storedFile))
                ->modify(['w' => $width])
                ->save(Storage::disk('public')->path($outputPath));

            $paths[$width.'w'] = Storage::url($outputPath);
        }

        $media->update([
            'path' => $paths,
        ]);
    }
}
