<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMediaRequest;
use App\Models\Media;
use App\Service\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class MediaController extends Controller
{
    public function index()
    {
        $medias = Media::all();

        if (request()->wantsJson()) {
            return response()->json($medias);
        }

        return Inertia::render('Admin/Media/Index', compact('medias'));
    }

    public function store(StoreMediaRequest $request)
    {
        $validated = $request->validated();

        $files = $validated['files'];

        foreach ($files as $file) {
            (new FileService)->handleFile($file);
        }
    }

    public function update(Request $request, Media $media)
    {
        $media->update($request->all());
    }

    public function getMedia(Media $media)
    {
        return response()->json($media);
    }

    public function destroy(Media $media)
    {
        (new FileService)->deleteFile($media);

        $media->delete();
    }
}
