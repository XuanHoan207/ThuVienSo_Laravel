<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'color',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tag) {
            if (empty($tag->slug)) {
                $tag->slug = Str::slug($tag->name);
            }
        });
    }

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'book_tag')
            ->withTimestamps();
    }

    public function activeBooks(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'book_tag')
            ->wherePivotIn('status', ['approved', null])
            ->withTimestamps();
    }

    public function getBooksCountAttribute(): int
    {
        return $this->books()->where('books.status', 'approved')->whereNull('books.deleted_at')->count();
    }
}
