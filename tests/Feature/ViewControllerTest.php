<?php

use App\Models\Collection;
use App\Models\CollectionType;
use App\Models\Page;
use Inertia\Testing\AssertableInertia as Assert;

it('displays the home page if published', function () {
    $page = Page::factory()->create([
        'title' => 'Accueil',
        'slug' => 'accueil',
        'status' => 'published',
        'is_home' => true,
    ]);

    $this->get(route('page.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $inertia) => $inertia
            ->component('Page/Index')
            ->where('page.id', $page->id)
        );
});

it('returns 404 if home page is a draft', function () {
    Page::factory()->create([
        'title' => 'Accueil',
        'slug' => 'accueil',
        'status' => 'draft',
        'is_home' => true,
    ]);

    $this->get(route('page.index'))->assertNotFound();
});

it('displays a regular page if published', function () {
    $page = Page::factory()->create([
        'title' => 'About',
        'slug' => 'about',
        'status' => 'published',
        'is_home' => false,
    ]);

    $this->get(route('page.show', $page->slug))
        ->assertOk()
        ->assertInertia(fn (Assert $inertia) => $inertia
            ->component('Page/Page')
            ->where('page.id', $page->id)
        );
});

it('returns 404 if regular page is a draft', function () {
    $page = Page::factory()->create([
        'slug' => 'about',
        'status' => 'draft',
        'is_home' => false,
    ]);

    $this->get(route('page.show', $page->slug))->assertNotFound();
});

it('displays a collection page if published', function () {
    $type = CollectionType::factory()->create(['type' => 'articles']);

    $collection = Collection::factory()->create([
        'title' => 'Article 1',
        'slug' => 'article-1',
        'status' => 'published',
        'collection_type_id' => $type->id,
    ]);

    $this->get(route('page.collection', [$type->type, $collection->slug]))
        ->assertOk()
        ->assertInertia(fn (Assert $inertia) => $inertia
            ->component('Collection/Collection')
            ->where('collectionPage.id', $collection->id)
        );
});

it('returns 404 if collection page is a draft', function () {
    $type = CollectionType::factory()->create(['type' => 'articles']);

    $collection = Collection::factory()->create([
        'slug' => 'article-1',
        'status' => 'draft',
        'collection_type_id' => $type->id,
    ]);

    $this->get(route('page.collection', [$type->type, $collection->slug]))->assertNotFound();
});
