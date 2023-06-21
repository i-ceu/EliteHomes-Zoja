<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use App\Models\Favourite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Property extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'property_name',
        'property_address',
        'property_price',
        'category_id',
        'property_description',
        'property_stock',
        'property_total_floor_area',
        'property_bedroom_number',
        'property_toilet_number',
        'property_plan_image_url',
        'property_other_image_url',
        'user_id'
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
    public function favourites(): BelongsTo
    {
        return $this->belongsTo(Favourite::class);
    }
    public function reviews(): BelongsTo
    {
        return $this->belongsTo(Reviews::class);
    }
}
