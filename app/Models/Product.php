<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['caption', 'image', 'is_active', 'sort_order'];

    protected function casts(): array
    {
        return [
            'is_active'  => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image
            ? asset('images/product/' . $this->image)
            : asset('images/logo/lushdailylogo.png');
    }

    public function getTitleAttribute(): string
    {
        preg_match('/\*([^*]+)\*/', $this->caption, $matches);
        if ($matches) {
            return trim($matches[1]);
        }
        $firstLine = strtok($this->caption, "\n");
        return mb_strimwidth(trim($firstLine), 0, 60, '…');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
