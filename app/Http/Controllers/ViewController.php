<?php

namespace App\Http\Controllers;

use App\Concerns\HasHydration;
use App\Models\BlockType;
use App\Models\Collection;
use App\Models\CollectionType;
use App\Models\Page;
use Inertia\Inertia;

class ViewController extends Controller
{
    use HasHydration;

    /**
     * Display home page.
     */
    public function index()
    {
        $page = Page::where('is_home', true)->firstOrFail();

        if ($page->status === 'draft') {
            abort(404);
        }

        $page->load(['blocks']);

        $this->hydratePage($page);

        return Inertia::render('Page/Index', compact('page'));
    }

    /**
     * Display page.
     */
    public function page(string $slug)
    {
        $page = Page::where([
            ['slug', $slug],
            ['is_home', false],
        ])->firstOrFail();

        if ($page->status === 'draft') {
            abort(404);
        }

        $page->load(['blocks']);

        if ($page->is_archive) {
            $page->load('collections');
        }

        $this->hydratePage($page);

        return Inertia::render('Page/Page', compact('page'));
    }

    /**
     * Display collection.
     */
    public function collection(string $collection, string $slug)
    {
        $collectionType = CollectionType::where('type', $collection)->firstOrFail();

        $collectionPage = Collection::where([
            ['slug', $slug],
            ['collection_type_id', $collectionType->id],
        ])->firstOrFail();

        if ($collectionPage->status === 'draft') {
            abort(404);
        }

        $this->hydrateCollection($collectionPage);

        return Inertia::render('Collection/Collection', compact('collectionPage'));
    }

    public function navigation()
    {
        $blockTypes = BlockType::all();
        $collectionTypes = CollectionType::all();

        return response()->json([
            'blockTypes' => $blockTypes->only('type', 'name'),
            'collectionTypes' => $collectionTypes,
        ]);
    }
}
