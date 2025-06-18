<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCollectionTypeRequest;
use App\Models\Collection;
use App\Models\CollectionType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CollectionTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $collectionTypes = CollectionType::all();

        return Inertia::render('Admin/CollectionType/Index', compact('collectionTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/CollectionType/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCollectionTypeRequest $request)
    {
        $validated = $request->validated();

        $collectionType = CollectionType::create($validated);

        return to_route('admin.collection-type.show', $collectionType);
    }

    /**
     * Display the specified resource.
     */
    public function show(CollectionType $collectionType, Request $request)
    {
        $collection = Collection::when($request->search, function ($query) use ($request) {
            $query->where('title', 'like', '%'.$request->search.'%');
        })->where('collection_type_id', $collectionType->id)->orderBy('created_at', 'desc')->paginate(8);

        return Inertia::render('Admin/CollectionType/Show', compact('collection', 'collectionType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CollectionType $collectionType)
    {
        $collections = Collection::where('collection_type_id', $collectionType->id)->get();

        // Delete collections
        foreach ($collections as $collection) {
            $collection->delete();
        }

        // Delete collection type
        $collectionType->delete();

        return to_route('admin.page.index')->with('success', 'Block type deleted successfully.');
    }
}
