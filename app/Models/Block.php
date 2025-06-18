<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Block extends Model
{
    /** @use HasFactory<\Database\Factories\BlockFactory> */
    use HasFactory;

    protected $fillable = ['type', 'content', 'order', 'block_type_id'];

    protected $casts = [
        'content' => 'json',
    ];

    public function blockType(): BelongsTo
    {
        return $this->belongsTo(BlockType::class);
    }

    public function pages(): BelongsToMany
    {
        return $this->belongsToMany(Page::class, Section::class);
    }

    public function medias(): MorphToMany
    {
        return $this->morphToMany(Media::class, 'mediaable');
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
}
