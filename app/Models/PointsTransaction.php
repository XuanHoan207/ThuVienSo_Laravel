<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PointsTransaction extends Model
{
    use HasFactory;

    protected $table = 'points_transactions';

    protected $fillable = [
        'user_id',
        'amount',
        'points',
        'type',
        'status',
        'payment_method',
        'reference_id',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'points' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function isPositive(): bool
    {
        return in_array($this->type, ['recharge', 'refund', 'bonus']);
    }
}
