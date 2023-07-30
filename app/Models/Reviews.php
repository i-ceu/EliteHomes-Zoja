<?php

namespace App\Models;
use App\Models\User;
use App\Models\Property;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Reviews extends Model implements HasMedia


    {
        use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'property_id' ,
        'user_id' ,
        'rating' ,
        'comment' 
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function property(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    }
    
