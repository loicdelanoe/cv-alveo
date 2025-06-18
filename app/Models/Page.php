<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;

class Page extends Model implements Sitemapable
{
    /** @use HasFactory<\Database\Factories\PageFactory> */
    use HasFactory;

    protected $fillable = ['title', 'slug', 'status', 'meta_title', 'meta_description', 'og_type', 'is_home', 'collection_type_id', 'is_archive'];

    protected $casts = [
        'is_home' => 'boolean',
        'is_archive' => 'boolean',
    ];

    public function blocks(): BelongsToMany
    {
        return $this->belongsToMany(Block::class, Section::class)->withPivot('order')->orderBy('order');
    }

    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(Menu::class, Navigation::class);
    }

    public function collections(): HasMany
    {
        return $this->hasMany(Collection::class, 'collection_type_id', 'collection_type_id');
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
        return Url::create(route('page.show', $this->slug))
            ->setLastModificationDate(Carbon::parse($this->updated_at));
    }
}
