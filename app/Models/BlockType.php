<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BlockType extends Model
{
    /** @use HasFactory<\Database\Factories\BlockTypeFactory> */
    use HasFactory;

    protected $fillable = ['name', 'type', 'fields'];

    protected $casts = [
        'fields' => 'array',
    ];

    public function blocks(): HasMany
    {
        return $this->hasMany(Block::class);
    }
}
