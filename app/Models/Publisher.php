<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Publisher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'info',
        'logo',
        'website',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($publisher) {
            if (empty($publisher->slug)) {
                $publisher->slug = Str::slug($publisher->name);
            }
        });
    }

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
