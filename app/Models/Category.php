<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    protected static function booted(): void
    {
        static::creating(function ($category) {

            if (!$category->slug) {

                $baseSlug = Str::slug($category->name);

                $slug = $baseSlug;

                $counter = 1;

                while (
                    Category::where('slug', $slug)->exists()
                ) {
                    $slug = $baseSlug . '-' . $counter;

                    $counter++;
                }

                $category->slug = $slug;
            }
        });

        static::updating(function ($category) {

            if ($category->isDirty('name')) {

                $baseSlug = Str::slug($category->name);

                $slug = $baseSlug;

                $counter = 1;

                while (
                    Category::where('slug', $slug)
                    ->where('id', '!=', $category->id)
                    ->exists()
                ) {
                    $slug = $baseSlug . '-' . $counter;

                    $counter++;
                }

                $category->slug = $slug;
            }
        });
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
