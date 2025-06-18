<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Media extends Model
{
    /** @use HasFactory<\Database\Factories\MediaFactory> */
    use HasFactory;

    protected $table = 'medias';

    protected $fillable = ['name', 'path', 'type', 'metadata'];

    protected $casts = [
        'path' => 'array',
        'metadata' => 'array',
    ];

    public function blocks(): MorphToMany
    {
        return $this->morphedByMany(Block::class, 'mediaable');
    }
}
