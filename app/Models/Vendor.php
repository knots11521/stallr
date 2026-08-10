<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vendor extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'store_name',
        'slug',
        'description',
        'logo',
        'banner',
        'phone',
        'address',
        'is_verified',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
    ];

    protected static function booted(): void
    {
        /*
         * Generate slug when creating a vendor.
         */
        static::creating(function ($vendor) {
            if (! $vendor->slug) {
                $vendor->slug = self::generateUniqueSlug(
                    $vendor->store_name
                );
            }
        });

        /*
         * Regenerate slug when store name changes.
         */
        static::updating(function ($vendor) {
            if ($vendor->isDirty('store_name')) {
                $vendor->slug = self::generateUniqueSlug(
                    $vendor->store_name,
                    $vendor->id
                );
            }
        });
    }

    /**
     * Generate a unique vendor slug.
     */
    private static function generateUniqueSlug(
        string $storeName,
        ?int $ignoreId = null
    ): string {
        $baseSlug = Str::slug($storeName);

        $slug = $baseSlug;

        $counter = 1;

        while (
            self::where('slug', $slug)
            ->when(
                $ignoreId,
                fn($query) => $query->where('id', '!=', $ignoreId)
            )
            ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;

            $counter++;
        }

        return $slug;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function vendorOrders(): HasMany
    {
        return $this->hasMany(VendorOrder::class);
    }
}
