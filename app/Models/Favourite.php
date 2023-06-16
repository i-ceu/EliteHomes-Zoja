<?php

namespace App\Models;

use App\Models\User;
use App\Models\Property;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Favourite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'property_id'
    ];

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function property(): HasMany
    {
        return $this->hasMany(Property::class);
    }
}
