<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlockTypeRequest;
use App\Models\Block;
use App\Models\BlockType;
use App\Models\CollectionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Inertia\Inertia;
use Inertia\Response;

class BlockTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blockTypes = BlockType::all();

        return Inertia::render('Admin/BlockType/Index', compact('blockTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $fieldsValidation = config('fields.validation');
        $collectionTypes = CollectionType::all()->pluck('type');

        return Inertia::render('Admin/BlockType/Create', compact('fieldsValidation', 'collectionTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlockTypeRequest $request)
    {
        $validated = $request->validated();

        if ($validated['component']) {
            $path = resource_path("js/Components/Blocks/{$validated['component']}.vue");

            $fileContent = <<<'EOT'
            <script setup lang="ts">
            defineProps<{
                content: any
            }>()
            </script>

            <template>
                <section>
                    <pre>{{ content }}</pre>
                </section>
            </template>

            <style scoped></style>
            EOT;

            if (! File::exists(dirname($path))) {
                File::makeDirectory(dirname($path), 0755, true);
            }

            File::put($path, $fileContent);
        }

        $blockType = BlockType::create($validated);

        return to_route('admin.block-type.show', $blockType->type);
    }

    /**
     * Display the specified resource.
     */
    public function show(BlockType $blockType)
    {
        $blocks = Block::where('block_type_id', $blockType->id)->paginate(8);

        return Inertia::render('Admin/BlockType/Show', compact('blocks', 'blockType'));
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
    public function destroy(BlockType $blockType)
    {
        $blocks = Block::where('block_type_id', $blockType->id)->get();

        // Delete blocks
        foreach ($blocks as $block) {
            $block->delete();
        }

        // Delete block type
        $blockType->delete();

        return to_route('admin.page.index')->with('success', 'Block type deleted successfully.');
    }
}
