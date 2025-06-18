<?php

namespace App\Http\Controllers;

use App\Concerns\hasDynamicValidation;
use App\Models\Block;
use App\Models\BlockType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BlockController extends Controller
{
    use hasDynamicValidation;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blocks = Block::all();
        $blockTypes = BlockType::all();

        return Inertia::render('Admin/Block/Index', compact('blocks', 'blockTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(BlockType $blockType)
    {
        return Inertia::render('Admin/Block/Create', compact('blockType'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, BlockType $blockType)
    {
        $validated = $this->validateBlock($request, $blockType);

        $validated['block_type_id'] = $blockType->id;

        $block = Block::create($validated);

        if ($request->expectsJson()) {
            return $block;
        }

        return to_route('admin.block-type.show', $blockType);
    }

    /**
     * Display the specified resource.
     */
    public function show(Block $block)
    {
        $block->load([
            'blockType',
            'pages',
        ]);

        return Inertia::render('Admin/Block/Show', compact('block'));
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
    public function update(Request $request, Block $block)
    {
        $block->load(['blockType']);

        $validated = $this->validateBlock($request, $block->blockType);

        $block->update($validated);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Block $block)
    {
        // Check if the block is used in any page
        $block->load(['blockType']);

        $blockType = $block->blockType;

        // Delete the block
        $block->delete();

        return to_route('admin.block-type.show', $blockType->type);
    }

    public function getBlocksByType(BlockType $blockType)
    {
        $blocks = Block::where('block_type_id', $blockType->id)->paginate(8);

        return $blocks;
    }
}
