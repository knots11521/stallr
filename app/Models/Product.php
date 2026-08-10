<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'name',
        'slug',
        'sku',
        'price',
        'stock',
        'description',
        'status',
        'is_featured',
        'approved_at',
        'approved_by',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Boot
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        static::creating(function ($product) {

            if (!$product->slug) {
                $product->slug = self::generateUniqueSlug(
                    $product->name
                );
            }
        });

        static::updating(function ($product) {

            if ($product->isDirty('name')) {
                $product->slug = self::generateUniqueSlug(
                    $product->name,
                    $product->id
                );
            }
        });
    }

    private static function generateUniqueSlug(
        string $name,
        ?int $ignoreId = null
    ): string {
        $baseSlug = Str::slug($name);

        $slug = $baseSlug;

        $counter = 1;

        while (
            Product::where('slug', $slug)
            ->when($ignoreId, function ($query) use ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            })
            ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;

            $counter++;
        }

        return $slug;
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeSearch($query, ?string $search)
    {
        return $query->when($search, function ($query) use ($search) {

            $query->where(function ($query) use ($search) {

                $query->where(
                    'name',
                    'like',
                    "%{$search}%"
                )->orWhere(
                    'description',
                    'like',
                    "%{$search}%"
                );
            });
        });
    }

    public function scopePriceBetween(
        $query,
        $min = null,
        $max = null
    ) {
        return $query
            ->when(
                $min !== null,
                fn($q) => $q->where('price', '>=', $min)
            )
            ->when(
                $max !== null,
                fn($q) => $q->where('price', '<=', $max)
            );
    }

    public function scopeCategory(
        $query,
        ?string $category
    ) {
        return $query->when($category, function ($query) use ($category) {

            $query->whereHas(
                'categories',
                function ($q) use ($category) {
                    $q->where('slug', $category);
                }
            );
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'approved_by'
        );
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
