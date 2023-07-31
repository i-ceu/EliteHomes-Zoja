<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Property;
use App\Models\Favourite;
use Spatie\MediaLibrary\HasMedia;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids, InteractsWithMedia;

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public function getMediaDirectory(): string
    {
        // You can customize the folder structure here
        return 'avatars/' . $this->id;
    }
    protected $fillable = [
        'username',
        'email',
        'first_name',
        'last_name',
        'profile_picture',
        'password',
        'confirm_password',
        'phone_number',
        'is_landlord',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'confirm_password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'confirm_password' => 'hashed',
    ];


    public function property(): HasMany
    {
        return $this->hasMany(Property::class, 'user_id');
    }
   
    
    public function favourites(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'favourites', 'user_id', 'property_id')
            ->select('property_other_image_url', 'category_id', 'property_address', 'property_name', 'property_description', 'id')
            ->withTimestamps();
    }
    

    public function registerMediaCollection(): void
    {
        $this->addMediaCollection('profile_picture');
    }
    public function addProfilePicture()
    {
        return Attribute::make(
            get: fn () => $this->addMedia('profile_picture') ?: null
        );
    }
}
