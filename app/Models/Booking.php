<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Property;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Booking extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'email',
        'message',
        'phone_number',
        // 'property_id',
        'sender_id',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // protected static function boot()
    // {
    //     parent::boot();
    //     static::created(function (Property $property) {
    //     });
    // }

}
