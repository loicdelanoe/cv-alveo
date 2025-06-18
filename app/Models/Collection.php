<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;

class Collection extends Model implements Sitemapable
{
    /** @use HasFactory<\Database\Factories\CollectionFactory> */
    use HasFactory;

    protected $fillable = [
        'status',
        'title',
        'meta_title',
        'meta_description',
        'og_type',
        'slug',
        'content',
        'collection_type_id',
    ];

    protected $casts = [
        'content' => 'array',
    ];

    public function collectionType(): BelongsTo
    {
        return $this->belongsTo(CollectionType::class);
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->format('Y-m-d H:i:s'),
        );
    }

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->format('Y-m-d H:i:s'),
        );
    }

    public function toSitemapTag(): Url|string|array
    {
        return Url::create(route('page.collection', [$this->collectionType->type, $this->slug]))
            ->setLastModificationDate(Carbon::parse($this->updated_at));
    }
}
