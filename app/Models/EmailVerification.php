<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailVerification extends Model
{
    use HasFactory;
    const UPDATED_AT = null;    
    protected $table = 'EmailVerification';
    protected $fillable = [
        'email',
        'otp',
        'created_at',
    ];
}
