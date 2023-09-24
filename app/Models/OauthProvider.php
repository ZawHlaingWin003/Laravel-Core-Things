<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OauthProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'github_id',
        'github_token',
        'facebook_id',
        'facebook_token',
        'google_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
