<?php

namespace App\Models; // Consider moving User model into the Models directory if using Laravel 8 or newer

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable; // Import Notifiable trait if you plan to use notifications

class User extends Authenticatable
{

    use Notifiable,HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token',];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // If your application uses API tokens or you have custom attributes that need casting, you can add them here as well.
}
