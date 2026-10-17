<?php

namespace App\Models;

use App\Enums\ProductType;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

#[Fillable(['name', 'type', 'category_id', 'description', 'purchase_price', 'selling_price', 'is_signature', 'is_active'])]
class Product extends Model implements HasMedia
{
    use HasFactory, HasUuids, InteractsWithMedia;

    protected function casts(): array
    {
        return ['type' => ProductType::class, 'is_active' => 'boolean', 'is_signature' => 'boolean', 'purchase_price' => 'decimal:2', 'selling_price' => 'decimal:2'];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function barcodes()
    {
        return $this->hasMany(Barcode::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('product-images')->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit(Fit::Crop, 400, 400)->nonQueued();
    }
}
