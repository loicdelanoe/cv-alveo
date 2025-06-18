<?php

namespace App\Http\Controllers;

use App\Models\BlockType;
use App\Models\CollectionType;
use App\Models\Menu;
use App\Models\Page;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $page = Page::all();
        $collectionTypes = CollectionType::all();
        $blockTypes = BlockType::all();
        $menus = Menu::orderBy('id', 'desc')->take(3)->get();
        $menus->load('pages');

        return Inertia::render('Admin/Dashboard/Index', compact('page', 'collectionTypes', 'blockTypes', 'menus'));
    }
}
