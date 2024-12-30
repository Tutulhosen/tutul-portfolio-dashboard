<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $table = 'user_profiles';  


    protected $fillable = [
        'user_id',
        'phone',
        'whatsapp',
        'designation',
        'short_description',
        'logo',
        'profile_picture',
        'resume',
        'github',
        'linkedin',
        'twitter',
        'facebook',
        
    ];

    // You can also define relationships if needed
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
