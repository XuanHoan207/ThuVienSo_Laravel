<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'isbn',
        'thumbnail',
        'file_path',
        'file_size',
        'file_type',
        'description',
        'category_id',
        'publisher_id',
        'user_id',
        'published_year',
        'pages',
        'language',
        'price_points',
        'status',
        'view_count',
        'download_count',
        'rating_avg',
        'rating_count',
    ];

    protected function casts(): array
    {
        return [
            'view_count' => 'integer',
            'download_count' => 'integer',
            'rating_avg' => 'decimal:2',
            'rating_count' => 'integer',
            'pages' => 'integer',
            'file_size' => 'integer',
            'published_year' => 'integer',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($book) {
            if (empty($book->slug)) {
                $book->slug = Str::slug($book->title);
            }
        });
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function publisher(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'book_author')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'book_tag')
            ->withTimestamps();
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function approvedComments(): HasMany
    {
        return $this->hasMany(Comment::class)->where('status', 'approved');
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    public function bookDownloads(): HasMany
    {
        return $this->hasMany(BookDownload::class);
    }

    public function bookViews(): HasMany
    {
        return $this->hasMany(BookView::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'approved');
    }

    public function incrementViewCount(): void
    {
        $this->increment('view_count');
    }

    public function incrementDownloadCount(): void
    {
        $this->increment('download_count');
    }

    public function updateRating(): void
    {
        $stats = $this->ratings()->selectRaw('AVG(stars) as avg_rating, COUNT(*) as count')->first();
        
        $this->update([
            'rating_avg' => $stats->avg_rating ?? 0,
            'rating_count' => $stats->count ?? 0,
        ]);
    }

    public function getAuthorNamesAttribute(): string
    {
        return $this->authors->pluck('name')->join(', ');
    }

    public function getTagNamesAttribute(): string
    {
        return $this->tags->pluck('name')->join(', ');
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price_points) . ' điểm';
    }

    public function getFormattedFileSizeAttribute(): string
    {
        if (!$this->file_size) return 'N/A';
        
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        
        while ($bytes >= 1024 && $i < 3) {
            $bytes /= 1024;
            $i++;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }
}
