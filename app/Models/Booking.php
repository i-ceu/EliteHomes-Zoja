<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'property_id',
        'message',
    ];

    // public function category(): BelongsTo
    // {
    //     return $this->belongsTo(Property::class);
    // }

    // protected static function boot()
    // {
    //     parent::boot();
    //     static::created(function (Property $property) {
    //     });
    // }

}
