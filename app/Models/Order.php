<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'payment_status',
        'subtotal',
        'total',
        'currency',
        'stripe_payment_intent_id',
        'paid_at',
    ];

    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            if (! $order->order_number) {
                $order->order_number = 'STL-' . now()->format('YmdHis') . '-' . strtoupper(
                    Str::random(6)
                );
            }
        });
    }

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'total' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vendorOrders(): HasMany
    {
        return $this->hasMany(VendorOrder::class);
    }
}
