<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'caption', 'image', 'is_active', 'sort_order'];

    protected function casts(): array
    {
        return [
            'is_active'  => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order')->orderBy('id');
    }

    /** Primary image URL: first product_image, fallback to legacy image column */
    public function getPrimaryImageUrlAttribute(): string
    {
        $first = $this->images->first();
        if ($first) {
            return $first->url;
        }
        return $this->image
            ? asset('images/product/' . $this->image)
            : asset('images/logo/lushdailylogo.png');
    }

    /** All image URLs: product_images + legacy image if no product_images */
    public function getAllImageUrlsAttribute(): array
    {
        if ($this->images->isNotEmpty()) {
            return $this->images->map->url->all();
        }
        return $this->image
            ? [asset('images/product/' . $this->image)]
            : [asset('images/logo/lushdailylogo.png')];
    }

    /** Legacy single-image accessor kept for backward compat */
    public function getImageUrlAttribute(): string
    {
        return $this->primary_image_url;
    }

    /** Display name: name column, or extracted from caption as fallback */
    public function getTitleAttribute(): string
    {
        if ($this->name) {
            return $this->name;
        }

        $plain = strip_tags($this->caption ?? '');
        $plain = html_entity_decode($plain, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $plain = str_replace("\xc2\xa0", ' ', $plain);
        $plain = trim($plain);

        // Try bold markdown *text* (legacy plain-text captions)
        preg_match('/\*([^*]+)\*/', $this->caption ?? '', $matches);
        if ($matches) {
            return trim($matches[1]);
        }

        $firstLine = strtok($plain ?: 'Produk', "\n");
        return mb_strimwidth(trim($firstLine), 0, 60, '…');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
