<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boking extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'message'
    ];

    //   public function category(): BelongsTo
    // {
    //     return $this->belongsTo(Category::class);
    // }
}
