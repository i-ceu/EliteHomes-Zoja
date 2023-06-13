<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Property extends Model
{
    use HasFactory;

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
}
