<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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
        'low_stock_threshold',
        'description',
        'status',
        'is_featured',
        'approved_at',
        'approved_by',
        'average_rating',
        'review_count',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
        'low_stock_threshold' => 'integer',
        'average_rating' => 'decimal:2',
        'review_count' => 'integer',
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

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function recalculateRating(): void
    {
        $approvedReviews = $this->reviews()->where('status', 'approved');

        $this->average_rating = (float) $approvedReviews->avg('rating');
        $this->review_count = $approvedReviews->count();
        $this->save();
    }

    public function scopeTopRated($query)
    {
        return $query->orderByDesc('average_rating');
    }

    public function scopeRating($query, ?float $min): void
    {
        $query->when($min !== null, function ($q) use ($min) {
            $q->where('average_rating', '>=', $min);
        });
    }
}
