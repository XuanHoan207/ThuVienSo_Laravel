<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'content',
        'link',
        'icon',
        'is_read',
        'read_at',
        'data',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
            'read_at' => 'datetime',
            'data' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function markAsRead(): void
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    public static function createNotification(array $data): self
    {
        return self::create($data);
    }

    // Helper method để tạo thông báo liên quan đến sách
    public static function createBookNotification(
        int $userId,
        string $type,
        string $title,
        string $content,
        array $bookData,
        ?string $link = null
    ): self {
        $icons = [
            'book_approved' => 'bi-check-circle',
            'book_rejected' => 'bi-x-circle',
            'book_pending' => 'bi-clock',
            'book_new' => 'bi-plus-circle',
        ];

        return self::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'content' => $content,
            'icon' => $icons[$type] ?? 'bi-bell',
            'link' => $link,
            'is_read' => false,
            'data' => [
                'book' => $bookData,
            ],
        ]);
    }
}
