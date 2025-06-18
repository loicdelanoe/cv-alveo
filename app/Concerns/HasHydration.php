<?php

namespace App\Concerns;

use App\Models\Collection;
use App\Models\Media;
use App\Models\Page;

trait HasHydration
{
    public function hydratePage(Page $page)
    {

        if ($page->relationLoaded('blocks')) {
            $page->blocks->transform(function ($block) {
                $content = $block->content;
                $fields = $block->blockType->fields;

                $block->content = $this->resolveMedia($content, $fields);

                return $block;
            });
        }

        if ($page->relationLoaded('collections') && $page->is_archive) {
            $page->collections->transform(function ($collection) {
                $this->hydrateCollection($collection);

                return $collection;
            });
        }
    }

    public function hydrateCollection(Collection $collection)
    {
        $content = $collection->content;
        $fields = $collection->collectionType->fields;

        $collection->content = $this->resolveMedia($content, $fields);
    }

    public function resolveMedia($content, $fields)
    {
        foreach ($fields as $field) {
            switch ($field['type']) {
                case 'image':
                case 'video':
                    $mediaId = $content[$field['name']];
                    $media = Media::findOrFail($mediaId);

                    $content[$field['name']] = $media;
                    break;
                case 'gallery':
                    $mediaIds = $content[$field['name']];
                    $media = Media::whereIn('id', $mediaIds)->get();

                    $content[$field['name']] = $media;
                    break;
            }
        }

        return $content;
    }
}
