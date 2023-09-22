<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'author_id'
    ];

    public function title(): Attribute
    {
        return Attribute::make(
            get: fn($value) => ucfirst($value)
        );
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
