<?php

namespace App\Models;
use App\Models\User;
use App\Models\Property;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviews extends Model


    {
        use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name' ,
        'property_id' ,
        'user_id' ,
        'profile_picture',
        'rating' ,
        'comment' 
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
    
