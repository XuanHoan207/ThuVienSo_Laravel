<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookReadProgress extends Model
{
    protected $table = 'book_read_progress';

    protected $fillable = [
        'user_id',
        'book_id',
        'last_page',
        'max_pages_read',
        'last_read_at',
    ];

    protected function casts(): array
    {
        return [
            'last_page' => 'integer',
            'max_pages_read' => 'integer',
            'last_read_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
